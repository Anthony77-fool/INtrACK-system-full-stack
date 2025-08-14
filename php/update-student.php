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

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //get values from js
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $lrn = $_POST['lrn'];
    $gender = $_POST['gender'];
    $birth_month = $_POST['birth_month'];
    $birth_day = $_POST['birth_day'];
    $birth_year = $_POST['birth_year'];
    $province = $_POST['province_code'];
    $municipality = $_POST['municipality_code'];
    $parent_FName = $_POST['parent_FName'];
    $parent_email = $_POST['parent_email'];

    $conn->begin_transaction();

    // Get address_id, birth_date_id, and current image
    $stmt = $conn->prepare("SELECT address_id, birth_date_id, image_url FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->bind_result($address_id, $birth_date_id, $currentImagePath);
    $stmt->fetch();
    $stmt->close();

    // Handle file upload
    $uploadDir = '../images/profileImg/';
    $profileImagePath = $currentImagePath; // default image if no upload

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['profile_image']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
            $profileImagePath = 'images/profileImg/' . $fileName; // Store relative path in DB
        }
    }

    // Update students
    $stmt = $conn->prepare("UPDATE students SET firstName=?, middleName=?, lastName=?, lrn=?, gender=?, image_url=?, parentFName=?, parent_email=? WHERE student_id=?");
    $stmt->bind_param("ssssssssi", $first_name, $middle_name, $last_name, $lrn, $gender, $profileImagePath, $parent_FName, $parent_email, $student_id);
    $stmt->execute();
    $stmt->close();

    // Update address
    $stmt = $conn->prepare("UPDATE address SET province_code=?, municipality_code=?, barangay_code=? WHERE address_id=?");
    $stmt->bind_param("ssss", $province, $municipality, $barangay, $address_id);
    $stmt->execute();
    $stmt->close();

    // Update birth_date
    $stmt = $conn->prepare("UPDATE birth_date SET birthMonth=?, birthDay=?, birthYear=? WHERE birth_date_id=?");
    $stmt->bind_param("ssss", $birth_month, $birth_day, $birth_year, $birth_date_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo 'success';
  }
?>
