<?php
  require_once '../conn/db_conn.php';

  if (isset($_POST['email'])) {
      $email = $_POST['email'];

      $email = filter_var($email, FILTER_SANITIZE_EMAIL);

      $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          echo "exists"; // email already in use
      } else {
          echo "ok"; // proceed with registration
      }
  } else {
      echo "missing";
  }
?>