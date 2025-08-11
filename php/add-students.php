<?php
    // Connect to database
    require_once '../conn/db_conn.php';

    // Handle file upload
    $uploadDir = '../images/profileImg/';
    $fileName = basename($_FILES['profile_image']['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
        $profileImagePath = 'images/profileImg/' . $fileName; // Store relative path in DB
    } else {
        $profileImagePath = 'images/profileImg/default-profile-pic.png'; // Fallback or handle error
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

    $birthMonth    = $_POST['birthMonth'] ?? '';
    $birthDay      = $_POST['birthDay'] ?? '';
    $birthYear     = $_POST['birthYear'] ?? '';

    $parent_FName  = $_POST['parent_name'];
    $parent_email  = $_POST['parent_email'];
    $class_id  = $_POST['classId_add'];

    // Combine birthdate into one string
    $birthDate = "$birthYear-$birthMonth-$birthDay";

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
        (firstName, middleName, lastName, lrn, gender, address_id, birth_date_id, parentFName, parent_email, image_url, class_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
    $stmt = $conn->prepare($insertStudentSql);
    $stmt->bind_param("ssssssssssi", $firstName, $middleName, $lastName, $lrn, $gender, $address_id, $birth_date_id, $parent_FName, $parent_email, $profileImagePath, $class_id);

    if ($stmt->execute()) {
        echo "Student added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>
