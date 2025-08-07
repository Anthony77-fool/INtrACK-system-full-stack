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

  //this is array for converting months numbers to names
  // Convert numeric month to full month name
  $months = [
      1 => 'January', 2 => 'February', 3 => 'March',
      4 => 'April', 5 => 'May', 6 => 'June',
      7 => 'July', 8 => 'August', 9 => 'September',
      10 => 'October', 11 => 'November', 12 => 'December'
  ];

  // --- Fetch account info ---
  $sql = "SELECT email, password FROM accounts WHERE user_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if (!$stmt) {
      echo json_encode(['status' => 'error', 'message' => 'Account statement preparation failed.']);
      exit;
  }
  mysqli_stmt_bind_param($stmt, "i", $user_id);
  mysqli_stmt_execute($stmt);
  $account_result = mysqli_stmt_get_result($stmt);
  $account = mysqli_fetch_assoc($account_result);
  mysqli_stmt_close($stmt);

  if (!$account) {
      echo json_encode(['status' => 'error', 'message' => 'Account not found.']);
      exit;
  }

  // --- Fetch user info ---
  $sql = "SELECT firstName, middleName, lastName, phoneNumber, gender, address_id, birth_date_id FROM users WHERE user_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if (!$stmt) {
      echo json_encode(['status' => 'error', 'message' => 'User statement preparation failed.']);
      exit;
  }
  mysqli_stmt_bind_param($stmt, "i", $user_id);
  mysqli_stmt_execute($stmt);
  $user_result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($user_result);
  mysqli_stmt_close($stmt);

  if (!$user) {
      echo json_encode(['status' => 'error', 'message' => 'User not found.']);
      exit;
  }

  // --- Fetch address info ---
  $sql = "SELECT province_code, municipality_code, barangay_code FROM address WHERE address_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $user['address_id']);
  mysqli_stmt_execute($stmt);
  $address_result = mysqli_stmt_get_result($stmt);
  $address = mysqli_fetch_assoc($address_result);
  mysqli_stmt_close($stmt);

  // --- Fetch birth date info ---
  $sql = "SELECT birthMonth, birthDay, birthYear FROM birth_date WHERE birth_date_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $user['birth_date_id']);
  mysqli_stmt_execute($stmt);
  $birth_result = mysqli_stmt_get_result($stmt);
  $birth = mysqli_fetch_assoc($birth_result);
  mysqli_stmt_close($stmt);

  // Format data
  $fullname = "{$user['firstName']} {$user['middleName']} {$user['lastName']}";
  $birthdate = "{$months[$birth['birthMonth']]} {$birth['birthDay']}, {$birth['birthYear']}";
  $age = calculateAge($birth['birthYear'], $birth['birthMonth'], $birth['birthDay']);

  // --- Assemble user data ---
  $userData = [
      'fullname' => $fullname,
      'user_id' => $user_id,
      'role' => 'Adviser', // Static for now
      'gender' => $user['gender'],
      'age' => $age,
      'birthdate' => $birthdate,
      'phone' => $user['phoneNumber'],
      'email' => $account['email'],
      'address' => [
        'barangay_code' => $address['barangay_code'],
        'municipality_code' => $address['municipality_code'],
        'province_code' => $address['province_code']
      ],
      'about' => 'INtrACK is a QR code-based attendance system designed to simplify and speed up the process of tracking student attendance. It allows teachers to scan student QR codes for real-time logging, reducing manual errors and paperwork. The system features user profiles, secure access for advisers, and organized attendance records for easy monitoring and reporting.',
      'profileImg' => 'images/profileImg/Sabado-Marck-Anthony.png', // Static path
      'password' => $account['password'] // ⚠️ For demo only – avoid in production
  ];

  // Return JSON response
  echo json_encode(['status' => 'success', 'user' => $userData]);

  // --- Helper: Calculate age ---
  function calculateAge($year, $month, $day) {
      $birthdate = new DateTime("$year-$month-$day");
      $today = new DateTime();
      return $today->diff($birthdate)->y;
  }

?>
