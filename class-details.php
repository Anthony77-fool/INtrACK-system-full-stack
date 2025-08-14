<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Class Details</title>

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
  <link rel="stylesheet" href="css/modal-z-index.css">
  <link rel="stylesheet" href="css/tooltipStyle.css">

</head>
<body>
  
  <?php
    $pageTitle = 'Class-Management'; // Set the page title
    require_once 'includes_php/Nav-Bar.php'; // Include the Navigation Bar
  ?>

  <!-- this is main -->
  <main class="d-flex flex-column gap-4  p-5">

     <!-- Section header -->
    <section class="custom-shadow py-4 px-3" id="main_sectionHeader">

    </section>

    <!-- Tables for students -->
    <section class="custom-shadow">

      <!-- HEAD MOST OF THE SECTION -->
      <header class="d-flex justify-content-between">

        <h3 class="fs-4 custom-color fw-semibold">Student List</h3>

        <div class="d-flex flex-row align-items-center gap-3">

          <!-- Search Bar -->
          <form class="d-flex position-relative" role="search" id="search_Form">
            <input type="search" id="searchInput-students" name="search" class="form-control rounded-pill ps-5 pe-5" placeholder="Search" aria-label="Search">

            <!-- Search Icon (left inside input) -->
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>

            <!-- Sort Icon (right inside input) -->
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted" style="cursor: pointer;" data-bs-toggle="dropdown">
              <i class="bi bi-funnel"></i>
            </span>

            <!-- Dropdown menu for sorting -->
            <ul class="dropdown-menu dropdown-menu-end mt-2">
              <li><a class="dropdown-item sort-option" data-sort="az" href="#">Sort A-Z</a></li>
              <li><a class="dropdown-item sort-option" data-sort="date" href="#">Sort by Date</a></li>
              <li><a class="dropdown-item sort-option" data-sort="default" href="#">Default</a></li>
            </ul>
          </form>

          <button class="btn btn-success rounded-pill px-3 py-2" data-bs-toggle="modal" data-bs-target="#addStudent_Form" title="Add a New Student"><!-- BTN to ADD STudents -->
            <i class="fa-solid fa-plus bg-white rounded-circle text-success p-1" id="addStudent_Button"></i>
            Add Student
          </button>

        </div>

      </header>

      <!-- TABLE -->
      <table class="table table-borderless mt-3">

        <!-- Table head -->
        <thead class="inner-shadow table-secondary text-center">
          <tr>
            <th class="text-muted"><!-- to select all row datas -->
              #
            </th>
            <th class="text-muted">Last Name</th>
            <th class="text-muted">First Name</th>
            <th class="text-muted">Middle Name</th>
            <th class="text-muted">Actions</th>
          </tr>
        </thead>

        <!-- TABLE DATAS 1ST(WHITE) 2ND(GREY) -->
        <tbody class="text-center">

          <tr class="inner-shadow">
            <td class="text-muted">
              1
            </td>
            <td>Sabado</td>
            <td>Thalia Gielyn</td>
            <td>Licuan</td>
            <td class="d-flex flex-row align-items-center justify-content-evenly">
              <i class="fa-solid fa-eye cstm-view-icon cursor-pointer" data-bs-toggle="modal" data-bs-target="#viewStudent_Form" title="View Student"><!-- VIEW --></i>
              <i class="bi bi-box-arrow-up-right cstm-icon-clr cursor-pointer" data-bs-toggle="modal" data-bs-target="#editStudent_Form" title="Edit Student"><!-- EDIT --></i>
              <i class="bi bi-trash-fill text-danger cursor-pointer" title="Delete Student"><!-- DELETE --></i>
            </td>
          </tr>

          <tr class="inner-shadow table-secondary">
            <td class="text-muted">
              2
            </td>
            <td>Sabado</td>
            <td>Thalia Gielyn</td>
            <td>Licuan</td>
            <td class="d-flex flex-row align-items-center justify-content-evenly">
              <i class="fa-solid fa-eye cstm-view-icon cursor-pointer" data-bs-toggle="modal" data-bs-target="#viewStudent_Form" title="View Student"><!-- VIEW --></i>
              <i class="bi bi-box-arrow-up-right text-success cursor-pointer" data-bs-toggle="modal" data-bs-target="#editStudent_Form" title="Edit Student"><!-- EDIT --></i>
              <i class="bi bi-trash-fill text-danger cursor-pointer" title="Delete Student"><!-- DELETE --></i>
            </td>
          </tr>

        </tbody>
      </table>

    </section>

  </main>

  <?php
    require_once 'includes_php/Aside-Bar.php'; // Include the Aside Bar
  ?>

  <?php
    require_once 'includes_php/adding-students-PopUp.php'; // Include the Pop Up for Adding Students
  ?>

  <?php
    require_once 'includes_php/viewing-students-PopUp.php'; // Include the Pop Up for Viewing Students
  ?>

  <?php
    require_once 'includes_php/editing-students-PopUp.php'; // Include the Pop Up for Editing Students
  ?>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header bg-danger text-white d-flex justify-content-between">
          <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
          <i class="fa-solid fa-circle-xmark cursor-pointer fs-1" id="exitDelete_Modal" data-bs-dismiss="modal" title="Exit Form"></i><!-- ICON for exiting modal -->
        </div>
        <div class="modal-body text-center">
          <p class="fs-5">Are you sure you want to delete this student?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancel Delete">Cancel</button>
          <button id="confirmDeleteBtn" type="button" class="btn btn-danger" title="Confirm Deletion">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <script src="js/calendar.js"></script><!-- for the calendar "ASIDE" -->
  <script src="js/address_Selection.js"></script>
  <script src="js/birthdate_Selection.js"></script>
  <script src="js/tooltip.js"></script><!-- ToolTip js -->

  <script src="js_loops_backend/display-students.js"></script><!-- Must be the first script in backend -->
  <script src="js_loops_backend/class-details.js"></script><!-- JS for Class Details Page -->
  <script src="js_backend/add-student.js"></script><!-- JS for Add Students -->
  <script src="js_backend/view-student.js"></script><!-- For Viewing Students -->
  <script src="js_backend/update-student.js"></script><!-- For Updating Students -->

  <script src="js/download-qr.js"></script><!-- Last One for the download of QR Code -->
  <script src="js_backend/delete-student.js"></script>

</body>
</html>