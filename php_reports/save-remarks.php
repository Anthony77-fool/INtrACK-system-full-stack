<?php
session_start();
require_once '../conn/db_conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Not logged in.'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

//get pass datas from js
$student_id = $_POST['student_id'];
$remark = $_POST['remark'];

//insert in the database

?>