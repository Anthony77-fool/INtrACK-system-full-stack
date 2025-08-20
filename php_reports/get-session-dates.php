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

    $class_id = $_POST['class_id'] ?? 0;
    $type = $_POST['type'] ?? '';

    // Fetch sessions filtered by class & type
    $sql = "SELECT date_created 
            FROM sessions 
            WHERE class_id = ? AND attendance_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $class_id, $type);
    $stmt->execute();
    $result = $stmt->get_result();

    $sessions = [];
    while ($row = $result->fetch_assoc()) {
        $sessions[] = [ "date_created" => $row['date_created'] ];
    }

    echo json_encode($sessions);


?>