<?php
require_once '../conn/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Retrieve POST data
  $firstName = $_POST['firstName'];
  $middleName = $_POST['middleName'];
  $lastName = $_POST['lastName'];
  $gender = $_POST['gender'];
  $phone = $_POST['phone'];

  $province = $_POST['province'];
  $municipality = $_POST['municipality'];
  $barangay = $_POST['barangay'];

  $month = $_POST['birthMonth'];
  $day = $_POST['birthDay'];
  $year = $_POST['birthYear'];

  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Always hash passwords
  $email = $_GET['email'] ?? null;

  if (!$email) {
    die("No email provided.");
  }

  // 1. Insert into address table
  $stmt = $conn->prepare("INSERT INTO address (province, municipality, barangay) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $province, $municipality, $barangay);
  $stmt->execute();
  $address_id = $stmt->insert_id;
  $stmt->close();

  // 2. Insert into date_birth table
  $stmt = $conn->prepare("INSERT INTO date_birth (month, day, year) VALUES (?, ?, ?)");
  $stmt->bind_param("sii", $month, $day, $year);
  $stmt->execute();
  $date_birth_id = $stmt->insert_id;
  $stmt->close();

  // 3. Insert into user table
  $stmt = $conn->prepare("INSERT INTO user (first_name, middle_name, last_name, gender, phone, address_id, date_birth_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssiii", $firstName, $middleName, $lastName, $gender, $phone, $address_id, $date_birth_id);
  $stmt->execute();
  $user_id = $stmt->insert_id;
  $stmt->close();

  // 4. Insert into account table
  $stmt = $conn->prepare("INSERT INTO account (user_id, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("iss", $user_id, $email, $password);
  $stmt->execute();
  $stmt->close();

  echo "Registration successful!";
  // Redirect or render confirmation page
} else {
  echo "Invalid request.";
}
?>
