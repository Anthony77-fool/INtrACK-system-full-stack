<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Reports</title>

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

  <?php
    $pageTitle = 'Reports'; // Set the page title
    require_once 'includes_php/Nav-Bar.php'; // Include the Navigation Bar
  ?>

  <!-- this is main -->
  <main class="d-flex flex-column gap-4  p-5 d-none d-lg-block">

    <!-- Section for creating a class -->
    <section class="custom-shadow py-4 px-3">
      <h3 class="ms-2 custom-header-fs custom-color fw-semibold">Generate QR Attendance Session</h3>

      <!-- container for input fields -->
      <div class="container">
        <div class="row gy-2">

          <div class="col-4"><!-- Class input -->
            <h4 class="custom-color fs-6">Class*</h4>
            <!-- for the class dropdown option -->
            <div>
              <select id="schoolYearSelect" class="form-select cursor-pointer">
                <option selected disabled class="cursor-pointer">Select Class</option>
              </select>
            </div>
          </div>

          <div class="col-4"><!-- In or Out -->
            <h4 class="custom-color fs-6">Attendance Type*</h4>
            <!-- for the sy. dropdown option -->
            <div>
              <select id="schoolYearSelect" class="form-select cursor-pointer">
                <option selected disabled class="cursor-pointer">Log as In or Out</option>
                <option value="">In</option>
                <option value="">Out</option>
              </select>
            </div>
          </div>

          <div class="btn-container col-4 d-flex-center">
            <!-- Redirected to qr scanner page -->
            <button class="btn btn-success h-75 w-100 mt-3 fs-5 cstm-lttr-spcng" title="Generate a New Session">Generate Report</button>
          </div>

          <!-- Date -->
          <div class="col-12">
            <h4 class="custom-color fs-6">Attendance Date*</h4>
            
            <div class="d-flex justify-content-between">

              <div class="custom-select-w"><!-- Month -->
                <select id="schoolYearSelect" class="form-select cursor-pointer">
                  <option selected disabled class="cursor-pointer">Select Month</option>
                  <option value="">In</option>
                  <option value="">Out</option>
                </select>
              </div>

            <div class="custom-select-w"><!-- day -->
              <select id="schoolYearSelect" class="form-select cursor-pointer">
                <option selected disabled class="cursor-pointer">Select Day</option>
                <option value="">In</option>
                <option value="">Out</option>
              </select>
            </div>

            <div class="custom-select-w"><!-- Year -->
              <select id="schoolYearSelect" class="form-select cursor-pointer">
                <option selected disabled class="cursor-pointer">Select Year</option>
                <option value="">In</option>
                <option value="">Out</option>
              </select>
            </div>

            </div>
          </div>

        </div>
      </div>

    </section>

    <!-- for the generated attendance -->
    <section class="custom-shadow py-4 px-3 mt-4">
      <!-- Table -->
      <table class="table table-borderless">
        <thead><!-- Head -->
          <th class="text-muted fs-5 text-center">#</th>
          <th class="text-muted fs-5 text-center">Name</th>
          <th class="text-muted fs-5 text-center">Present</th>
          <th class="text-muted fs-5 text-center">Absent</th>
          <th class="text-muted fs-5 text-center">Note</th>
        </thead>

        <!-- BODY -->
        <tbody>
          <tr>
            <td class="text-black-50 fw-bolder fs-6 text-center">1</td><!-- Number -->
            <td class="text-black-50 fw-bolder fs-6 text-center">Klein Moretti</td><!-- Full Name -->
            <td class="text-center"><i class="fa-solid fa-circle text-success border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i></td><!-- Present -->
            <td class="text-center"><i class="fa-solid fa-circle custom-color border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i></td><!-- Absent -->
            <td class="text-center"><i class="fa-solid fa-comments cstm-view-icon fs-4 cursor-pointer"></i></td><!-- Note -->
          </tr>
          <tr>
            <td class="text-black-50 fw-bolder fs-6 text-center">2</td><!-- Number -->
            <td class="text-black-50 fw-bolder fs-6 text-center">Fitz Chivalry</td><!-- Full Name -->
            <td class="text-center"><i class="fa-solid fa-circle custom-color border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i></td><!-- Present -->
            <td class="text-center"><i class="fa-solid fa-circle text-success border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i></td><!-- Absent -->
            <td class="text-center"><i class="fa-solid fa-comments cstm-view-icon fs-4 cursor-pointer"></i></td><!-- Note -->
          </tr>
          <tr>
            <td class="text-black-50 fw-bolder fs-6 text-center">3</td><!-- Number -->
            <td class="text-black-50 fw-bolder fs-6 text-center">Fitz Chivalry</td><!-- Full Name -->
            <td class="text-center"><i class="fa-solid fa-circle custom-color border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i></td><!-- Present -->
            <td class="text-center"><i class="fa-solid fa-circle custom-color border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i></td><!-- Absent -->
            <td class="text-center"><i class="fa-solid fa-comments custom-color fs-4 cursor-pointer"></i></td><!-- Note -->
          </tr>
        </tbody>

      </table>
    </section>

  </main>

  <?php
    require_once 'includes_php/Aside-Bar.php'; // Include the Aside Bar
  ?>

  <script src="js/sySelect.js"></script><!-- for the class management s.y. selection -->
  <script src="js/calendar.js"></script><!-- for the calendar "ASIDE" -->
  <script src="js/tooltip.js"></script>

  <!-- error page -->
  <script src="js/errorPage.js" type="module"></script>

</body>
</html>
