<?php
  session_start();
    // Connect to database
    require_once '../conn/db_conn.php';
    require_once '../libs/phpqrcode/qrlib.php'; // adjust path if needed

    // Prepare empty qr_code_img_url for initial insert
    $qr_code_img_url = '';

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Not logged in.'
        ]);
        exit;
    }

    //this is teachers id
    $user_id = $_SESSION['user_id'];

  //navigate to class table then select section_name that corresponds to the user_id

  // Fetch classes assigned to this teacher
  $sql = "SELECT class_id, section_name 
          FROM class 
          WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  $classes = [];
  while ($row = $result->fetch_assoc()) {
      $classes[] = [
          "class_id" => $row['class_id'],
          "section_name" => $row['section_name']
      ];
  }

  echo json_encode($classes);

?>