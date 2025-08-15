<?php
  session_start();
  require_once '../conn/db_conn.php';

  header('Content-Type: application/json');

  // Check login
  if (!isset($_SESSION['user_id'])) {
      echo json_encode(['status' => 'error', 'message' => 'Not logged in.']);
      exit;
  }

  $user_id = $_SESSION['user_id'];
  $class_id = $_POST['class_id'] ?? null;
  $attendance_type = $_POST['attendance_type'] ?? null;
  $date_created = $_POST['date_created'] ?? null;
  $time_created = $_POST['time_created'] ?? null;

  // Validation
  if (!$class_id || !$attendance_type || !$date_created || !$time_created) {
      echo json_encode(['status' => 'error', 'message' => 'Missing required data.']);
      exit;
  }

  $sql = "INSERT INTO sessions (user_id, class_id, attendance_type, date_created, time_created)
          VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iisss", $user_id, $class_id, $attendance_type, $date_created, $time_created);

  if ($stmt->execute()) {
      echo json_encode(['status' => 'success', 'message' => 'Session created successfully']);
  } else {
      echo json_encode(['status' => 'error', 'message' => 'Database insert failed']);
  }

  $stmt->close();
  $conn->close();
?>