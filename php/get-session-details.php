<?php
session_start();
require_once '../conn/db_conn.php';

header('Content-Type: application/json');

// Check login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in.']);
    exit;
}

$session_id = $_GET['session_id'] ?? null;

if (!$session_id) {
    echo json_encode(['status' => 'error', 'message' => 'Missing session_id.']);
    exit;
}

// Query: join sessions and class
$sql = "SELECT 
            s.session_id,
            s.class_id,
            c.grade_level,
            c.section_name,
            s.date_created,
            s.time_created
        FROM sessions s
        JOIN class c ON s.class_id = c.class_id
        WHERE s.session_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $session_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Format date to "July 23, 2025"
    $formatted_date = date("F j, Y", strtotime($row['date_created']));
    // Format time to "7:00 AM"
    $formatted_time = date("g:i A", strtotime($row['time_created']));

    echo json_encode([
        'status' => 'success',
        'data' => [
            'grade_level' => $row['grade_level'],
            'section_name' => $row['section_name'],
            'date' => $formatted_date,
            'time' => $formatted_time
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Session not found.']);
}

$stmt->close();
$conn->close();
?>