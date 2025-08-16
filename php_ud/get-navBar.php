<?php
  session_start();
  require_once '../conn/db_conn.php';

  header('Content-Type: application/json');

  if (!isset($_SESSION['user_id'])) {
      echo json_encode([
          'status' => 'error',
          'message' => 'Not logged in.'
      ]);
      exit;
  }

  $user_id = $_SESSION['user_id'];

  try {
      $sql = "SELECT firstName, lastName FROM users WHERE user_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($row = $result->fetch_assoc()) {
          echo json_encode([
              'status' => 'success',
              'firstName' => $row['firstName'],
              'lastName' => $row['lastName']
          ]);
      } else {
          echo json_encode([
              'status' => 'error',
              'message' => 'User not found.'
          ]);
      }

      $stmt->close();
      $conn->close();
  } catch (Exception $e) {
      echo json_encode([
          'status' => 'error',
          'message' => 'Database error: ' . $e->getMessage()
      ]);
  }
?>
