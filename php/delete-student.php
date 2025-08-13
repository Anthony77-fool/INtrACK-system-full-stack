<?php
  session_start();
  require_once '../conn/db_conn.php';

  header('Content-Type: application/json');

  // Check if user is logged in
  if (!isset($_SESSION['user_id'])) {
      echo json_encode([
          'status' => 'error',
          'message' => 'Not logged in.'
      ]);
      exit;
  }

  $user_id = $_SESSION['user_id'];

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
      $student_id = intval($_POST['student_id']);

      // Only delete from students table
      $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
      $stmt->bind_param("i", $student_id);

      if ($stmt->execute()) {
          http_response_code(200);
          echo json_encode(["status" => "success"]);
      } else {
          http_response_code(500);
          echo json_encode(["status" => "error", "message" => $stmt->error]);
      }

      $stmt->close();
      $conn->close();
  } else {
      http_response_code(400);
      echo json_encode(["status" => "error", "message" => "Invalid request"]);
  }

?>