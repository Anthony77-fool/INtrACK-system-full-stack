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

  $user_id = $_SESSION['user_id'];

  // ✅ Check if file is uploaded
  if (!isset($_FILES['profilePic']) || $_FILES['profilePic']['error'] !== UPLOAD_ERR_OK) {
      echo json_encode([
          'status' => 'error',
          'message' => 'No file uploaded or upload error.'
      ]);
      exit;
  }

  $uploadDir = '../images/profileImg/'; // folder relative to this PHP file
  if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true); // create folder if not exist
  }

  // ✅ Generate unique file name to prevent overwrite
  $ext = pathinfo($_FILES['profilePic']['name'], PATHINFO_EXTENSION);
  $fileName = uniqid("profile_", true) . "." . strtolower($ext);
  $filePath = $uploadDir . $fileName;

  // ✅ Move uploaded file
  if (!move_uploaded_file($_FILES['profilePic']['tmp_name'], $filePath)) {
      echo json_encode([
          'status' => 'error',
          'message' => 'Failed to save uploaded file.'
      ]);
      exit;
  }

  // ✅ Path to store in DB (relative to project root for frontend usage)
  $dbFilePath = "images/profileImg/" . $fileName;

  // ✅ Update DB
  $sql = "UPDATE users SET profile_image_url = ? WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si", $dbFilePath, $user_id);

  if ($stmt->execute()) {
      echo json_encode([
          'status' => 'success',
          'message' => 'Profile picture updated successfully.',
          'imageUrl' => $dbFilePath
      ]);
  } else {
      echo json_encode([
          'status' => 'error',
          'message' => 'Database update failed: ' . $stmt->error
      ]);
  }

  $stmt->close();
  $conn->close();
?>