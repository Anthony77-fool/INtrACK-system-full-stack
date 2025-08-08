<?php
  // Start session and include database connection
  session_start();
  require_once '../conn/db_conn.php';

  // Set response header to JSON
  header('Content-Type: application/json');

  // Get class_id from POST request
  $class_id = $_POST['class_id'] ?? '';
  if (empty($class_id)) {
      // If class_id is missing, return error response
      echo json_encode(['status' => 'error', 'message' => 'Class ID is required']);
      exit;
  }

  $query = "DELETE FROM class WHERE class_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $class_id);
  // Execute query and return appropriate response
  if ($stmt->execute()) {
      echo json_encode(['status' => 'success', 'message' => 'Class deleted successfully']);
  } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete class']);
  }
  // Close statement and database connection
  $stmt->close();
  $conn->close();
  exit; 

?>