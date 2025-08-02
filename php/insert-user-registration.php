<?php
require_once '../conn/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Retrieve POST data
  $firstName = $_POST['first_name'];
  $middleName = $_POST['middle_name'];
  $lastName = $_POST['last_name'];
  $gender = $_POST['gender'];
  $phoneNumber = $_POST['phone_number'];

  $province_code = $_POST['province_code'];
  $municipality_code = $_POST['municipality_code'];
  $barangay_code = $_POST['barangay_code'];

  $birthMonth = $_POST['birthMonth'];
  $birthDay = $_POST['birthDay'];
  $birthYear = $_POST['birthYear'];

  $email = $_POST['email'] ?? null;
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Always hash passwords

  if (!$email) {
    die("No email provided.");
  }

  // 1. Insert into address table
  $stmt = $conn->prepare("INSERT INTO address (province_code, municipality_code, barangay_code) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $province_code, $municipality_code, $barangay_code);
  $stmt->execute();
  $address_id = $stmt->insert_id;//get the last inserted ID
  $stmt->close();

  // 2. Insert into date_birth table
  $stmt = $conn->prepare("INSERT INTO birth_date (birthMonth, birthDay, birthYear) VALUES (?, ?, ?)");
  $stmt->bind_param("sis", $birthMonth, $birthDay, $birthYear);
  $stmt->execute();
  $birth_date_id = $stmt->insert_id;//get the last inserted ID
  $stmt->close();

  // 3. Insert into user table
  $stmt = $conn->prepare("INSERT INTO users (firstName, middleName, lastName, phoneNumber, gender, address_id, birth_date_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssii", $firstName, $middleName, $lastName, $phoneNumber , $gender, $address_id, $birth_date_id);
  $stmt->execute();
  $user_id = $stmt->insert_id;// get the last inserted ID
  $stmt->close();

  // 4. Insert into account table
  $stmt = $conn->prepare("INSERT INTO accounts ( email,  password, user_id) VALUES (?, ?, ?)");
  $stmt->bind_param("ssi", $email, $password, $user_id);
  $stmt->execute();
  $stmt->close();

  echo "Registration successful!";
  // Redirect or render confirmation page
} else {
  echo "Invalid request.";
}
?>
