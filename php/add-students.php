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

    // Handle file upload
$uploadDir = '../images/profileImg/';
$profileImagePath = 'images/profileImg/default-profile-pic.png'; // default image if no upload

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $fileName = basename($_FILES['profile_image']['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
        $profileImagePath = 'images/profileImg/' . $fileName; // Store relative path in DB
    }
}


    // Sanitize and collect POST data
    $firstName     = $_POST['first_name'] ?? '';
    $middleName    = $_POST['middle_name'] ?? '';
    $lastName      = $_POST['last_name'] ?? '';
    $lrn           = $_POST['lrn'] ?? '';
    $gender        = $_POST['gender'] ?? '';

    $province      = $_POST['province_code'] ?? '';
    $municipality  = $_POST['municipality_code'] ?? '';
    $barangay      = $_POST['barangay_code'] ?? '';

    $birthMonth    = $_POST['birth_month'] ?? '';
    $birthDay      = $_POST['birth_day'] ?? '';
    $birthYear     = $_POST['birth_year'] ?? '';

    $parent_FName  = $_POST['parent_name'];
    $parent_email  = $_POST['parent_email'];
    $class_id  = $_POST['classId_add'];

    // Insert into address table (optional if normalized)
    $insertAddressSql = "INSERT INTO address (province_code, municipality_code, barangay_code)
                        VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertAddressSql);
    $stmt->bind_param("sss", $province, $municipality, $barangay);
    $stmt->execute();
    $address_id = $stmt->insert_id;
    $stmt->close();

    // Insert into birth_date table (optional if normalized)
    $insertBirthSql = "INSERT INTO birth_date (birthMonth, birthDay, birthYear)
                        VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertBirthSql);
    $stmt->bind_param("sis", $birthMonth, $birthDay, $birthYear);
    $stmt->execute();
    $birth_date_id = $stmt->insert_id;
    $stmt->close();

    // Insert into students table
    $insertStudentSql = "INSERT INTO students 
        ( teacher_id, firstName, middleName, lastName, lrn, gender, address_id, birth_date_id, parentFName, parent_email, image_url, class_id, qr_code_img_url)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
    $stmt = $conn->prepare($insertStudentSql);
    $stmt->bind_param("sssssssssssis", $user_id, $firstName, $middleName, $lastName, $lrn, $gender, $address_id, $birth_date_id, $parent_FName, $parent_email, $profileImagePath, $class_id, $qr_code_img_url);

    if ($stmt->execute()) {
    // Get the new student's auto-increment ID
    $student_id = $stmt->insert_id;

    // === Generate QR code image using student_id ===
    $qrDir = '../images/qr_codes/';
    if (!is_dir($qrDir)) {
        mkdir($qrDir, 0775, true);
    }

    // File name and full path
    $qrFileName = 'qr_' . $student_id . '.png';
    $qrFilePath = $qrDir . $qrFileName;

    // Generate QR code (student_id as content)
    QRcode::png((string)$student_id, $qrFilePath, QR_ECLEVEL_L, 4, 2);

    // Save relative path to DB
    $qr_code_img_url = 'images/qr_codes/' . $qrFileName;

    // Update student record with QR code path
    $updateSql = "UPDATE students SET qr_code_img_url = ? WHERE student_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $qr_code_img_url, $student_id);
    $updateStmt->execute();
    $updateStmt->close();

    echo json_encode([
        'status' => 'success',
        'message' => 'Student added successfully.',
        'qr_url'  => $qr_code_img_url,
        'student_id' => $student_id
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => $stmt->error
    ]);
}


    $stmt->close();
    $conn->close();
?>
