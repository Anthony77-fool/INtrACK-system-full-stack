<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    // Destroy the session
    session_unset();
    session_destroy();

    echo 'success';
    exit;
}

echo 'invalid';
?>
