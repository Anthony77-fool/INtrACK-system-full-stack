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

  // 1️⃣ Count total classes
  $sql_classes = "SELECT COUNT(*) AS total_classes FROM class WHERE user_id = ?";
  $stmt1 = $conn->prepare($sql_classes);
  $stmt1->bind_param("i", $user_id);
  $stmt1->execute();
  $result1 = $stmt1->get_result();
  $total_classes = $result1->fetch_assoc()['total_classes'];
  $stmt1->close();

  // Get latest class_id for this teacher
  $sql = "SELECT class_id 
          FROM class 
          WHERE user_id = ? 
          ORDER BY class_id DESC 
          LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result($latest_class_id);
  $stmt->fetch();
  $stmt->close();

  // Count all classes for this teacher
  $sqlTotalClasses = "SELECT COUNT(*) FROM class WHERE user_id = ?";
  $stmt = $conn->prepare($sqlTotalClasses);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result($total_classes);
  $stmt->fetch();
  $stmt->close();

  // Count students in latest class
  $sqlLatestStudents = "SELECT COUNT(*) FROM students WHERE class_id = ? AND teacher_id = ?";
  $stmt = $conn->prepare($sqlLatestStudents);
  $stmt->bind_param("ii", $latest_class_id, $user_id);
  $stmt->execute();
  $stmt->bind_result($latest_students_total);
  $stmt->fetch();
  $stmt->close();

  echo json_encode([
      'status' => 'success',
      'total_classes' => $total_classes,
      'latest_students_total' => $latest_students_total
  ]);

  $conn->close();
?>