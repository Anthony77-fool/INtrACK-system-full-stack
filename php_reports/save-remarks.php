<?php
session_start();
require_once '../conn/db_conn.php';
header('Content-Type: application/json');

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Not logged in.'
    ]);
    exit;
}

// ✅ Get passed data from JS
$session_id = $_POST['sessionId'] ?? null;
$student_id = $_POST['studentId'] ?? null;
$remark     = $_POST['remark'] ?? null;

// ✅ Basic validation
if (!$session_id || !$student_id || !$remark) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields.'
    ]);
    exit;
}

// ✅ Upsert: update if exists, insert if not
$sql = "INSERT INTO notes (session_id, student_id, remark) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE remark = VALUES(remark)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Prepare failed: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("iis", $session_id, $student_id, $remark);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Remark saved successfully.',
        'studentId' => $student_id,
        'sessionId' => $session_id
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Insert/update failed: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
