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

  //Fetch class data
  $sql = "SELECT class_id, section_name, grade_level, school_year, strand FROM class WHERE user_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if (!$stmt) {
      echo json_encode(['status' => 'error', 'message' => 'Class statement preparation failed.']);
      exit;
  }
  mysqli_stmt_bind_param($stmt, "i", $user_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $classes = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_stmt_close($stmt);

  $classData = [];
  foreach ($classes as $class) {
      $classData[] = [
          'class_id' => $class['class_id'],
          'section_name' => $class['section_name'], 
          'grade_level' => $class['grade_level'],
          'school_year' => $class['school_year'],
          'strand' => $class['strand']
      ];
  }
  echo json_encode([
      'status' => 'success',
      'classes' => $classData
  ]);
  exit;

?>