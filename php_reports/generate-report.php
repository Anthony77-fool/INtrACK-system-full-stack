<?php
session_start();
require_once '../conn/db_conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Not logged in.'
    ]);
    exit;
}

$teacher_id = $_SESSION['user_id'];

// Get datas from JS
$class_id = $_POST['class_id'] ?? 0;
$type     = $_POST['type'] ?? '';
$month    = $_POST['month'] ?? '';
$day      = $_POST['day'] ?? '';
$year     = $_POST['year'] ?? '';

// Convert month name + day + year → YYYY-MM-DD
$month_number = date('m', strtotime($month)); 
$date_created = sprintf("%04d-%02d-%02d", $year, $month_number, $day);

// --- STEP 1: Get session_id from sessions table ---
$sql = "SELECT session_id 
        FROM sessions 
        WHERE user_id = ? AND class_id = ? AND attendance_type = ? AND date_created = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $teacher_id, $class_id, $type, $date_created);
$stmt->execute();
$result = $stmt->get_result();
$session = $result->fetch_assoc();

//set the get session_id
$session_id = $session['session_id'];

// --- STEP 2: Get all student_ids + notes from reports table ---
$sql = "SELECT student_id, note FROM reports WHERE session_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $session_id); // use "i" not "s"
$stmt->execute();
$result = $stmt->get_result();

$report_data = [];
while ($row = $result->fetch_assoc()) {
    $note_status = (!empty($row['note'])) ? 'ACTIVE' : 'INACTIVE';
    $report_data[$row['student_id']] = [
        'present' => true,
        'note_status' => $note_status
    ];
}

// --- STEP 3: Get all students in this class ---
$sql = "SELECT student_id, firstName, lastName 
        FROM students 
        WHERE class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $student_id = $row['student_id'];

    // Default values
    $status = 'ABSENT';
    $note_status = 'INACTIVE';

    // If student has report entry
    if (isset($report_data[$student_id])) {
        $status = 'Present';
        $note_status = $report_data[$student_id]['note_status'];
    }

    $students[] = [
        'student_id'     => $student_id,
        'session_id'    => $session_id,
        'firstName'   => $row['firstName'],
        'lastName'    => $row['lastName'],
        'status'      => $status,
        'note_status' => $note_status
    ];
}

// --- STEP 4: Return JSON ---
echo json_encode([
    'status'   => 'success',
    'students' => $students
]);


//now first convert month,day,year in this format "2025-08-15", date_created
//get session_id in sessions table using user_id, type, class_id, and the date_created
//go to reports table get the student_id, all of them at ounce, flag them as present
//now go to students table get all students with their user_id and firstName, lastName, 
//now compare the present and absent, flag is either present or absent
//then past the collected data to the js, user_id, firstName, lastName, present/absent

?>