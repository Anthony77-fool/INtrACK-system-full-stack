<?php
  session_start();
  require_once '../conn/db_conn.php';

  // Check if user is logged in
  if (!isset($_SESSION['user_id'])) {
      echo "Not logged in.";
      exit;
  }

  $user_id = $_SESSION['user_id'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Retrieve post data
    $sectionName = $_POST['section_name'] ?? '';
    $gradeLevel = $_POST['grade_level'] ?? '';
    $schoolYear = $_POST['school_year'] ?? '';
    $strand = $_POST['strand'] ?? '';

    //Validate Strand field
    if (empty($strand)) {
      $strand = 'JHS';
    }

    //Insert the class into the database
    $stmt = $conn->prepare("INSERT INTO class (section_name, grade_level, school_year, strand, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $sectionName, $gradeLevel, $schoolYear, $strand, $user_id);
    $stmt->execute();
    $stmt->close();

    echo "Registration successful!";

  } else {
    echo "Invalid request.";
  }


?>