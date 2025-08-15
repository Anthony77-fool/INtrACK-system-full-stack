<?php
    session_start();
    include_once '../conn/db_conn.php';

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
    $searchTerm = $_POST['search'] ?? '';
    $sort = $_POST['sort'] ?? 'default';
    $class_id = $_POST['class_id'] ?? '';

    $like = "%" . $searchTerm . "%";

    // Add class_id filter
    $baseSql = "SELECT * FROM students 
                WHERE class_id = ? 
                AND (firstName LIKE ? 
                    OR lastName LIKE ? 
                    OR middleName LIKE ?)";

    // Sorting logic
    switch ($sort) {
        case 'az':
            $baseSql .= " ORDER BY lastName ASC, firstName ASC, middleName ASC";
            break;
        case 'date':
            $baseSql .= " ORDER BY year DESC, month DESC, day DESC";
            break;
        case 'default':
        default:
            break;
    }

    $stmt = $conn->prepare($baseSql);
    $stmt->bind_param("isss", $class_id, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
?>
