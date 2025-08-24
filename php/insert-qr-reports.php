<?php
session_start();
require_once '../conn/db_conn.php';

header('Content-Type: application/json');

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in.']);
    exit;
}

$session_id   = $_POST['session_id'] ?? null;
$class_id     = $_POST['class_id'] ?? null;
$student_id   = $_POST['student_id'] ?? null;
$date_created = $_POST['date_created'] ?? null; // Expecting YYYY-MM-DD HH:MM:SS

// Validate inputs
if (!$session_id || !$student_id || !$date_created) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required data.']);
    exit;
}

// ✅ NEW VALIDATION: Check session ownership and class_id
$sessionSql = "SELECT class_id, user_id, attendance_type 
               FROM sessions 
               WHERE session_id = ?";
$sessionStmt = $conn->prepare($sessionSql);
$sessionStmt->bind_param("i", $session_id);
$sessionStmt->execute();
$sessionResult = $sessionStmt->get_result();

if ($sessionResult->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid session.']);
    exit;
}

$sessionRow     = $sessionResult->fetch_assoc();
$session_class  = $sessionRow['class_id'];
$session_user   = $sessionRow['user_id'];
$attendance_type = $sessionRow['attendance_type'];

$sessionStmt->close();

// Make sure session belongs to logged-in teacher
if ($session_user != $_SESSION['user_id']) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Session does not belong to you.']);
    exit;
}

// Fetch student details for validation
$studentSql = "SELECT firstName, middleName, lastName, parent_email, class_id, teacher_id 
               FROM students 
               WHERE student_id = ?";
$studentStmt = $conn->prepare($studentSql);
$studentStmt->bind_param("i", $student_id);
$studentStmt->execute();
$studentResult = $studentStmt->get_result();

if ($studentResult->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Student not found.']);
    exit;
}

$student = $studentResult->fetch_assoc();
$studentStmt->close();

// Validate class match
if ($student['class_id'] != $session_class) {
    echo json_encode(['status' => 'error', 'message' => 'This student does not belong to this class.']);
    exit;
}

// Optional: Validate teacher match (extra lock)
if ($student['teacher_id'] != $_SESSION['user_id']) {
    echo json_encode(['status' => 'error', 'message' => 'This student does not belong to your roster.']);
    exit;
}

// ✅ At this point: validated teacher → session → student

// Prevent duplicate scans
$checkSql = "SELECT report_id FROM reports WHERE session_id = ? AND student_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $session_id, $student_id);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    $fullname = trim($student['firstName'] . ' ' . 
        (!empty($student['middleName']) ? strtoupper(substr($student['middleName'], 0, 1)) . '.' : '') . 
        ' ' . $student['lastName']);

    echo json_encode([
        'status' => 'duplicate',
        'message' => "This student ($fullname) is already recorded for this session.",
        'fullname' => $fullname,
        'parent_email' => $student['parent_email'] ?? '',
        'attendance_type' => $attendance_type
    ]);
    $checkStmt->close();
    $conn->close();
    exit;
}

$checkStmt->close();

// Insert scan record
$sql = "INSERT INTO reports (session_id, student_id, date_created) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $session_id, $student_id, $date_created);

$fullname = trim($student['firstName'] . ' ' . 
    (!empty($student['middleName']) ? strtoupper(substr($student['middleName'], 0, 1)) . '.' : '') . 
    ' ' . $student['lastName']);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Scan saved successfully.',
        'fullname' => $fullname,
        'parent_email' => $student['parent_email'] ?? '',
        'attendance_type' => $attendance_type
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database insert failed.']);
}

$stmt->close();
$conn->close();
?>
