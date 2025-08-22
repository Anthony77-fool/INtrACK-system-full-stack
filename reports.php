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
              <select id="classSelect" class="form-select cursor-pointer">
                <option selected disabled class="cursor-pointer">Select Class</option>
              </select>
            </div>
          </div>

          <div class="col-4"><!-- In or Out -->
            <h4 class="custom-color fs-6">Attendance Type*</h4>
            <!-- for In and out -->
            <div>
              <select id="attendanceTypeSelect" class="form-select cursor-pointer">
                <option selected disabled class="cursor-pointer">Log as In or Out</option>
                <option value="IN">In</option>
                <option value="OUT">Out</option>
              </select>
            </div>
          </div>

          <div class="btn-container col-4 d-flex-center">
            <!-- Generate reports btn -->
            <button class="btn btn-success h-75 w-100 mt-3 fs-5 cstm-lttr-spcng" title="Generate a Report" id="generateReport-btn">Generate Report</button>
          </div>

          <!-- Date -->
          <div class="col-12">
            <h4 class="custom-color fs-6">Attendance Date*</h4>
            
            <div class="d-flex justify-content-between">

              <div class="custom-select-w"><!-- Month -->
                <select id="monthSelect" class="form-select cursor-pointer">
                  <option selected disabled class="cursor-pointer">Select Month</option>
                </select>
              </div>

            <div class="custom-select-w"><!-- day -->
              <select id="daySelect" class="form-select cursor-pointer">
                <option selected disabled class="cursor-pointer">Select Day</option>
              </select>
            </div>

            <div class="custom-select-w"><!-- Year -->
              <select id="yearSelect" class="form-select cursor-pointer">
                <option selected disabled class="cursor-pointer">Select Year</option>
              </select>
            </div>

            </div>
          </div>

        </div>
      </div>

    </section>

    <!-- for the generated attendance -->
    <section id="attendanceSection" class="py-4 px-3 mt-4">
      <!-- JS will inject default notice OR table -->
    </section>

  </main>

  <?php
    require_once 'includes_php/Aside-Bar.php'; // Include the Aside Bar
  ?>

  <!-- Comment/Remark Modal -->
  <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg rounded-4">
        <div class="modal-header bg-light d-flex justify-content-between">
          <h5 class="modal-title fw-bold" id="commentModalLabel">Add Remark</h5>
          <i class="fa-solid fa-circle-xmark fs-1 text-success" type="button" data-bs-dismiss="modal" aria-label="Close" title="Exit Remark"></i>
        </div>

        <div class="modal-body">
          <form id="commentForm">
            <div class="mb-3">
              <label for="commentUser" class="form-label fw-semibold">Student</label>
              <input type="text" class="form-control" id="commentUser" readonly>
            </div>
            <div class="mb-3">
              <label for="commentText" class="form-label fw-semibold">Your Remark</label>
              <textarea class="form-control" id="commentText" rows="4" placeholder="Write your comment here..." required></textarea>
            </div>
          </form>
        </div>

        <!-- Hidden Inputs: for storing certain id's -->
        <input type="hidden" id="commentStudentId">
        <input type="hidden" id="commentSessionId">

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal" title="Cancel Remark">Cancel</button>
          <button type="submit" form="commentForm" class="btn btn-success rounded-pill" title="Save Remark">Save</button>
        </div>
      </div>
    </div>
  </div>

  <script src="js/calendar.js"></script><!-- for the calendar "ASIDE" -->
  <script src="js/tooltip.js"></script>
  <script src="js_loops_backend/reports.js"></script>

  <!-- Add comment for student reports must be below report.js -->
  <script src="js_backend/add-comment-reports.js"></script>


</body>
</html>
