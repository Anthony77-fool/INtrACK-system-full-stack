<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Class Management</title>

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
  <main class="d-flex flex-column  p-5 d-none d-lg-block">

    <!-- Section for creating a class -->
    <section class="custom-shadow py-4 px-3">
      <h3 class="ms-2 custom-header-fs custom-color fw-semibold">Create Class</h3>

      <!-- container for input fields -->
      <div class="container">
        <div class="row gy-2">

          <div class="col-4"><!-- Section Input -->
            <h4 class="custom-color fs-6">Section Name*</h4>
            <input class="w-100 ps-2 form-control" type="text" id="section-name" placeholder="e.g. Descartes">
          </div>

          <div class="col-4">
            <h4 class="custom-color fs-6">Grade Level*</h4><!-- Grade Level Input -->
            <input class="w-100 ps-2 form-control" type="number" id="grade-level" placeholder="e.g. 11" min="7" max="12" onkeydown="return false;">
          </div>

          <div class="col-4"><!-- SY input -->
            <h4 class="custom-color fs-6">School Year*</h4>
            <!-- for the sy. dropdown option -->
            <div>
              <select id="schoolYearSelect" class="form-select cursor-pointer">
                <option value="" selected disabled class="cursor-pointer">Select School Year</option>
              </select>
            </div>
          </div>

          <div class="col-4"> <!-- Strand input -->
            <h4 class="custom-color fs-6">Strand* (only if SHS)</h4>
            <input class="w-100 ps-2 form-control" id="strand" type="text" placeholder="e.g. STEM" oninput="this.value = this.value.toUpperCase();">
          </div>

          <div class="btn-container col-4 d-flex-center">
            <button class="btn btn-success h-75 w-100 mt-3 fs-5 cstm-lttr-spcng" id="create-class_BTN" title="Create a new Class">Create Class</button>
          </div>

        </div>
      </div>

    </section>

    <!-- Created Class Sections -->
    <section class=" container mt-4" id="createdClassSection">
      
    </section>

  </main>

  <?php
    require_once 'includes_php/Aside-Bar.php'; // Include the Aside Bar
  ?>

  <!-- Modal for notice -->
  <div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger d-flex justify-content-between">
          <h5 class="modal-title text-white cstm-lttr-spcng" id="noticeModalLabel">Incomplete Fields</h5>
          <button type="button" class="bg-transparent exit-icon_BTN" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-circle-xmark fs-1 text-white"></i>
          </button>
        </div>
        <div class="modal-body">
          Please fill in all required fields before submitting.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Notice Modal -->

  <script src="js/sySelect.js"></script><!-- for the class management s.y. selection -->
  <script src="js/calendar.js"></script><!-- for the calendar "ASIDE" -->
  <script src="js/tooltip.js"></script>

  <!-- error page -->
  <script src="js/errorPage.js" type="module"></script>

  <!-- class management JS -->
  <script src="js_loops_backend/class-management.js"></script>

</body>
</html>
