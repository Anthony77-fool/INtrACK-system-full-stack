<?php
session_start();
require_once '../conn/db_conn.php';
header('Content-Type: application/json');

// ✅ Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Not logged in.'
    ]);
    exit;
}

// ✅ Get POST data safely
$student_id = $_POST['studentId'] ?? null;
$session_id = $_POST['sessionId'] ?? null;

if (!$student_id || !$session_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields.'
    ]);
    exit;
}

// ✅ Prepare SQL query to get the remark
$sql = "SELECT remark FROM notes WHERE student_id = ? AND session_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Prepare failed: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("ii", $student_id, $session_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Remark exists
    echo json_encode([
        'status' => 'success',
        'hasRemark' => true,
        'remark' => $row['remark']
    ]);
} else {
    // No remark found
    echo json_encode([
        'status' => 'success',
        'hasRemark' => false,
        'remark' => null
    ]);
}

$stmt->close();
$conn->close();
?>