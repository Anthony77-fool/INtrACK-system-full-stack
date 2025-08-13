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

  //get user_id
  $user_id = $_SESSION['user_id'];

  // Prepare and execute the query
  $sql = "SELECT * FROM students";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
      http_response_code(500);
      echo json_encode(['error' => 'Statement preparation failed']);
      exit;
  }

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  $records = [];

  while ($row = mysqli_fetch_assoc($result)) {
      // Extract address_id and birth_date_id
      $address_id = $row['address_id'];
      $birth_date_id = $row['birth_date_id'];

      // --- Fetch address info ---
      $address_stmt = mysqli_prepare($conn, "SELECT province_code, municipality_code, barangay_code FROM address WHERE address_id = ?");
      mysqli_stmt_bind_param($address_stmt, "i", $address_id);
      mysqli_stmt_execute($address_stmt);
      $address_result = mysqli_stmt_get_result($address_stmt);
      $address_data = mysqli_fetch_assoc($address_result);
      mysqli_stmt_close($address_stmt);

      // Merge address info into student record
      if ($address_data) {
          $row['province_code'] = $address_data['province_code'];
          $row['municipality_code'] = $address_data['municipality_code'];
          $row['barangay_code'] = $address_data['barangay_code'];
      }

      // --- Fetch birth date info ---
      $birth_stmt = mysqli_prepare($conn, "SELECT birthMonth, birthDay, birthYear FROM birth_date WHERE birth_date_id = ?");
      mysqli_stmt_bind_param($birth_stmt, "i", $birth_date_id);
      mysqli_stmt_execute($birth_stmt);
      $birth_result = mysqli_stmt_get_result($birth_stmt);
      $birth_data = mysqli_fetch_assoc($birth_result);
      mysqli_stmt_close($birth_stmt);

      // Merge birth date info into student record
      if ($birth_data) {
          $row['birthMonth'] = $birth_data['birthMonth'];
          $row['birthDay'] = $birth_data['birthDay'];
          $row['birthYear'] = $birth_data['birthYear'];
      }

      $records[] = $row;
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  // Send JSON response
  header('Content-Type: application/json');
  echo json_encode($records);

?>