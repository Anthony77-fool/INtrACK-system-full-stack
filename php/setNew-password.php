<?php
  session_start();
  require_once '../conn/db_conn.php'; // adjust path if needed

  header('Content-Type: application/json');

  // Validate POST inputs
  if (!isset($_POST['email']) || !isset($_POST['newPassword'])) {
      echo json_encode([
          'status' => 'error',
          'message' => 'Missing required fields.'
      ]);
      exit;
  }

  $email = trim($_POST['email']);
  $newPassword = trim($_POST['newPassword']);

  // Check if email is valid
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode([
          'status' => 'error',
          'message' => 'Invalid email format.'
      ]);
      exit;
  }

  // Hash the password securely
  $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

  // Update password in DB
  try {
      $stmt = $conn->prepare("UPDATE accounts SET password = ? WHERE email = ?");
      $stmt->bind_param("ss", $hashedPassword, $email);

      if ($stmt->execute()) {
          if ($stmt->affected_rows > 0) {
              echo json_encode([
                  'status' => 'success',
                  'message' => 'Password updated successfully.'
              ]);
          } else {
              echo json_encode([
                  'status' => 'error',
                  'message' => 'Email not found in our records.'
              ]);
          }
      } else {
          echo json_encode([
              'status' => 'error',
              'message' => 'Failed to update password. Please try again.'
          ]);
      }
      $stmt->close();
  } catch (Exception $e) {
      echo json_encode([
          'status' => 'error',
          'message' => 'Server error: ' . $e->getMessage()
      ]);
  }
  $conn->close();

?>