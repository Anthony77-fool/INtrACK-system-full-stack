<?php
  session_start();
  require_once '../conn/db_conn.php';

  header('Content-Type: application/json');

  // Check if logged in
  if (!isset($_SESSION['user_id'])) {
      echo json_encode(['status' => 'error', 'message' => 'Not logged in.']);
      exit;
  }

  $session_id   = $_POST['session_id'] ?? null;
  $student_id   = $_POST['student_id'] ?? null;
  $date_created = $_POST['date_created'] ?? null; // Expecting YYYY-MM-DD HH:MM:SS

  // Validate inputs
  if (!$session_id || !$student_id || !$date_created) {
      echo json_encode(['status' => 'error', 'message' => 'Missing required data.']);
      exit;
  }

  // Optional: Prevent duplicate scans for same student in same session
    $checkSql = "SELECT report_id FROM reports WHERE session_id = ? AND student_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $session_id, $student_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Fetch student name for better message
        $studentSql = "SELECT firstName, middleName, lastName FROM students WHERE student_id = ?";
        $studentStmt = $conn->prepare($studentSql);
        $studentStmt->bind_param("i", $student_id);
        $studentStmt->execute();
        $studentResult = $studentStmt->get_result();

        $fullname = 'Unknown Student';
        if ($studentResult->num_rows > 0) {
            $student = $studentResult->fetch_assoc();
            $middleInitial = !empty($student['middleName']) ? strtoupper(substr($student['middleName'], 0, 1)) . '.' : '';
            $fullname = trim($student['firstName'] . ' ' . $middleInitial . ' ' . $student['lastName']);
        }
        $studentStmt->close();

        echo json_encode([
            'status' => 'duplicate',
            'message' => "This student ($fullname) is already recorded for this session.",
            'fullname' => $fullname
        ]);
        $checkStmt->close();
        $conn->close();
        exit;
    }


  // Fetch student details
  $studentSql = "SELECT firstName, middleName, lastName FROM students WHERE student_id = ?";
  $studentStmt = $conn->prepare($studentSql);
  $studentStmt->bind_param("i", $student_id);
  $studentStmt->execute();
  $studentResult = $studentStmt->get_result();

  if ($studentResult->num_rows === 0) {
      echo json_encode(['status' => 'error', 'message' => 'Student not found.']);
      $studentStmt->close();
      $conn->close();
      exit;
  }

  $student = $studentResult->fetch_assoc();
  $studentStmt->close();

  // Format fullname
  $middleInitial = '';
  if (!empty($student['middleName'])) {
      $middleInitial = strtoupper(substr($student['middleName'], 0, 1)) . '.';
  }
  $fullname = trim($student['firstName'] . ' ' . $middleInitial . ' ' . $student['lastName']);

  // Insert scan record
  $sql = "INSERT INTO reports (session_id, student_id, date_created) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iis", $session_id, $student_id, $date_created);

  if ($stmt->execute()) {
      echo json_encode([
          'status' => 'success',
          'message' => 'Scan saved successfully.',
          'fullname' => $fullname
      ]);
  } else {
      echo json_encode(['status' => 'error', 'message' => 'Database insert failed.']);
  }

  $stmt->close();
  $conn->close();
?>