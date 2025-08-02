<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Registration Page</title>

  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="images/inac-logo.png">

  <!--Bootstrap link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

  <!-- BS ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!--CDN for QRCode generator-->
  <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>

  <!--CDN for Webcam HTML5 -->
  <script src="https://unpkg.com/html5-qrcode"></script>

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- CUSTOM GOOGLE FONTS: Roboto -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Loved+by+the+King&family=Over+the+Rainbow&family=Roboto:ital,wght@0,100..900;1,100..900&family=Unkempt:wght@400;700&display=swap" rel="stylesheet">

  <!-- Google Font Link for Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

  <!-- FontAwesome Icons -->
  <script src="https://kit.fontawesome.com/da97a1e785.js" crossorigin="anonymous"></script>

  <!-- CUSTOM CSS CLasses -->
  <link rel="stylesheet" href="css/customClasses.css">
  <link rel="stylesheet" href="css/classManagementStle.css">
  <link rel="stylesheet" href="css/tooltipStyle.css">
  <link rel="stylesheet" href="css/verify_Email.css">

  <!-- 404 Error Page -->
  <link rel="stylesheet" href="css/pageErrorStyle.css">

  <style>
    /* Red border for input error */
    .error {
      border: 1px solid red;
    }
  </style>

</head>
<body class="d-flex flex-row">

  <!-- PICTURE Section -->
  <section class="w-50 d-flex-center position-fixed" id="picture_Section">
    <picture>
      <img src="images/Prototyping-process-pana.png" alt="" class="w-100">
    </picture>
  </section>

  <!-- Registration Section -->
  <form class="w-50 border border-1 d-flex flex-column gap-4" id="signUp-form" style="margin-left: 50%;" method="POST">

    <header>
      <picture>
        <img src="images/inTrack-logo.jpg" alt="This is INtrACK Logo" class="w-50">
      </picture>
    </header>

    <!-- Top Text -->
    <div class="d-flex-center flex-column">
      <h2 class="cstm-lttr-spcng text-info-emphasis">Registration</h2>
      <h6 class="text-secondary">Please complete to create your account</h6>
    </div>
    
    <!-- For First Name -->
    <div class="d-flex flex-column align-items-center w-100">
      <div class="w-50">
        <label for="first-name" class="form-label">First Name</label>
        <input type="text" id="first-name" placeholder="Thalia Gielyn" class="form-control" required>
      </div>
    </div>

    <!-- For Middle Name and Last Name -->
    <div class="d-flex justify-content-center align-items-center w-100">

      <div class="w-50 d-flex flex-row justify-content-center align-items-center gap-3">
        <div>
          <label for="middle-name" class="form-label">Middle Name</label>
          <input type="text" id="middle-name" placeholder="Licuan" class="form-control" required>
        </div>
        <div>
          <label for="last-name" class="form-label">Last Name</label>
          <input type="text" id="last-name" placeholder="Sabado" class="form-control" required>
        </div> 
      </div>

    </div>

    <!-- Phone Number -->
    <div class="d-flex flex-column align-items-center w-100">
      <div class="w-50">
        <label for="phone-number" class="form-label">Phone Number</label>
        <input type="text" id="phone-number" placeholder="123456789101" class="form-control" required>
      </div>
    </div>

    <!-- GENDER -->
    <div class="d-flex flex-column align-items-center w-100">
      <div class="w-50">

        <!-- Label -->
        <label class="form-label fw-semibold fs-6 custom-color">Gender*</label>

        <div class="d-flex gap-3">
          <!-- MALE -->
          <div class="form-control d-flex align-items-center gap-2 border rounded-2">
            <input class="form-check-input cursor-pointer gender" type="radio" name="gender" id="genderMale" value="Male" required>
            <label class="form-check-label mb-0 cursor-pointer" for="genderMale">Male</label>
          </div>
          <!-- FEMALE -->
          <div class="form-control d-flex align-items-center gap-2 border rounded-2">
            <input class="form-check-input cursor-pointer gender" type="radio" name="gender" id="genderFemale" value="Female" required>
            <label class="form-check-label mb-0 cursor-pointer" for="genderFemale">Female</label>
          </div>
        </div>

      </div>
    </div>

    <!-- Address Selects -->
    <div class="w-100 d-flex-center">

      <div class="d-flex flex-column w-50">
        <!-- Label -->
        <label class="form-label fw-semibold fs-6 custom-color">Address*</label>
        
        <div class="d-flex flex-column w-100 gap-4">
          <!-- Province Dropdown -->
          <select id="province" class="form-select cursor-pointer" required>
            <option selected disabled class="cursor-pointer">Select Province</option>
          </select>

          <!-- Municipality Dropdown -->
          <select id="municipality" class="form-select cursor-pointer" required>
            <option selected disabled class="cursor-pointer">Select Municipality</option>
          </select>

          <!-- Barangay Dropdown -->
          <select id="barangay" class="form-select cursor-pointer" required>
            <option selected disabled class="cursor-pointer">Select Barangay</option>
          </select>
        </div>
      </div>
    
    </div>

    <!-- Birth Date -->
    <div class="w-100 d-flex-center">

      <div class="w-50 d-flex flex-column">
        <!-- Label -->
        <label class="form-label fw-semibold fs-6 custom-color">Birth Date*</label>

        <div class="d-flex flex-column gap-3">
          <!-- Month, Day Selects Container -->
          <div class="d-flex flex-row gap-3">
            <select id="birthMonth" class="form-select cursor-pointer" required>
              <option selected disabled class="cursor-pointer">Select Month</option>
            </select>
            
            <select id="birthDay" class="form-select cursor-pointer" required>
              <option selected disabled class="cursor-pointer">Select Day</option>
            </select>
          </div>

          <!-- Year Select -->
          <select id="birthYear" class="form-select cursor-pointer" required>
            <option selected disabled class="cursor-pointer">Select Year</option>
          </select>
        </div>
      </div>

    </div>

    <!-- For New Password -->
    <div class="d-flex flex-column align-items-center w-100" id="change-pass-newPassSection">
      <div class="w-50">
        <label for="new-password" class="form-label">New Password</label>
        <div class="position-relative">
          <input type="password" id="new-password" placeholder="Enter your New Password" class="form-control pr-5" required>
          <i class="fa-solid fa-eye text-secondary toggle-password" data-target="#new-password"></i>
        </div>
      </div>
    </div>

    <!-- For Confirm Password -->
    <div class="d-flex flex-column align-items-center w-100" id="change-pass-confirmPassSection">
      <div class="w-50">
        <label for="confirm-password" class="form-label">Confirm Password</label>
        <div class="position-relative">
          <input type="password" id="confirm-password" placeholder="Confirm your Password" class="form-control pr-5" required>
          <i class="fa-solid fa-eye text-secondary toggle-password" data-target="#confirm-password"></i>
        </div>
        <div id="password-feedback" class="invalid-feedback">Please enter the correct password.</div>
      </div>
    </div>
    
    <!-- Sign Up btn -->
    <div class="d-flex-center w-100">
      <button class="btn btn-success w-50 cstm-lttr-spcng fw-bold fs-5" id="signUp-btn" type="submit">Sign Up</button>
    </div>

    <!-- User Notice -->
    <div class="w-100 d-flex-center text-secondary small pt-3">
      <p class="w-50 text-center">
        By clicking <strong class="text-success">Sign Up</strong>, you agree to the creation of your account in our system. 
        You also accept our terms, including how we manage your personal data and uphold your privacy. 
        Please ensure that the information you provide is accurate and truthful.
      </p>
    </div>

  </form>

  <script src="js/address_Selection.js"></script>
  <script src="js/birthdate_Selection.js"></script>
  <script src="js/tooltip.js"></script><!-- ToolTip js -->

  <script src="js_backend/sign_up.js"></script><!-- Email Verification js -->

</body>
</html>