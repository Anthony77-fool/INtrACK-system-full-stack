<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Settings</title>

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
  <link rel="stylesheet" href="css/calendar.css">
  <link rel="stylesheet" href="css/tooltipStyle.css">

  <!-- 404 Error Page -->
  <link rel="stylesheet" href="css/pageErrorStyle.css">

</head>
<body>

  <!-- This block only appears on small screens -->
  <div class="d-flex justify-content-center align-items-center flex-column d-block d-lg-none warning-container">
    <!-- Lottie animation -->
    <canvas id="canvas" class="lottie-overlay"></canvas>

    <!-- Message -->
    <h5>Sorry! This site works best on laptop and desktop devices</h5>
  </div>
  
  <?php
    $pageTitle = 'Settings'; // Set the page title
    require_once 'includes_php/Nav-Bar.php'; // Include the Navigation Bar
  ?>

  <!-- this is main -->
  <main class="d-flex flex-column gap-4 p-5 d-none d-lg-block">
    <!-- Main content JS Generated -->
  </main>

  <?php
    require_once 'includes_php/Aside-Bar.php'; // Include the Aside Bar
  ?>

  <!-- Profile Picture Modal -->
  <div class="modal fade" id="uploadProfilePicModal" tabindex="-1" aria-labelledby="uploadProfilePicLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        
        <!-- Modal Header -->
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title" id="uploadProfilePicLabel">Upload Profile Picture</h5>
          <i class="fa-solid fa-circle-xmark fs-1 text-success" type="button" data-bs-dismiss="modal" aria-label="Close" title="Exit"></i>
        </div>

        <!-- Modal Body -->
        <div class="modal-body text-center">
          <div class="mb-3">
            <!-- Preview Area -->
            <img id="previewImage" src="" class="rounded-circle border mb-3" style="width: 250px; height: 250px; object-fit: cover;">
          </div>
          <!-- File Input -->
          <input type="file" id="profilePicInput" class="form-control" accept="image/*">
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancel">Cancel</button>
          <button type="button" class="btn btn-success" id="saveProfilePic" title="Save Picture">Save</button>
        </div>

      </div>
    </div>
  </div>


  <script src="js/sySelect.js"></script><!-- for the class management s.y. selection -->
  <script src="js/calendar.js"></script><!-- for the calendar "ASIDE" -->
  <script src="js/tooltip.js"></script>
  <!-- error page -->
  <script src="js/errorPage.js" type="module"></script>

  <!-- for getting session id -->
  <script src="js_backend/get-session.js"></script>
  
  <!-- for getting user info -->
  <script src="js_loops_backend/settings.js"></script>

  <!-- for logout -->
  <script src="js_backend/log-out.js"></script>

  <!-- JS for editing the profile user details -->
  <script src="js_backend/edit-settings-details.js"></script>

</body>
</html>