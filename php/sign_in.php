<?php
session_start();
require_once '../conn/db_conn.php'; // Your database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id, password FROM accounts WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashedPassword);
        $stmt->fetch();

        // If password is plain text, use: ($password === $hashedPassword)
        // If hashed (recommended), use password_verify()
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $user_id;

            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'user_id' => $user_id
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Incorrect password.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Account not found.'
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
