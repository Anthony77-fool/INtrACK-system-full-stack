<?php

  // Default style for the footer
  $drodownStyleText = 'custom-color';
  $box_style = '';
  $text_white = '';
  $box_styleQR = '';
  $text_whiteQR = '';
  $box_styleR = '';
  $text_whiteR = '';

  // Check if the current page is 'Settings' to change the style
  if($pageTitle == 'Settings') {
    $drodownStyleText = 'text-white cstm-box-bg-clr';
  }
  elseif($pageTitle == 'Class-Management') {
    $box_style = 'cstm-box-bg-clr';
    $text_white = 'text-white';
  }
  elseif($pageTitle == 'QR-Scanner-Management') {
    $box_styleQR = 'cstm-box-bg-clr';
    $text_whiteQR = 'text-white';
  }
  elseif($pageTitle == 'Reports') {
    $box_styleR = 'cstm-box-bg-clr';
    $text_whiteR = 'text-white';
  }

  //anchor Links for the navigation bar
  $classManagementLink = 'class-management.php';
  $qrScannerManagementLink = 'qr-scanner-management.php';
  $reportsLink = 'reports.php';

  echo '
    <!-- Navigation: Hamburger Menu -->
    <nav class="position-fixed h-100 w-25 d-none d-lg-block">

      <!-- Aside Bar Header -->
      <header class="custom-shadow">
        <img class="img-logo-size" src="images/inTrack-logo.jpg" alt="This is inTrack-logo">
      </header>

      <!-- Aside Bar Body -->
      <div class="body mt-4">
        <ul class="list-unstyled d-flex flex-column gap-4">
          <!-- Class Management -->
          <li class="custom-shadow aside-bar-h d-flex align-items-center cursor-pointer ' . $box_style . '" onclick="window.location.href=\'' . $classManagementLink . '\'">
            <i class="fa-solid fa-school fs-3 ms-5 me-4 cstm-icon-clr ' . $text_white . '"></i>
            <span class="text-decoration-none fs-5 custom-color fw-bold cstm-lttr-spcng ' . $text_white . '">Class Management</span>
          </li>

          <!-- QR Scanner Management -->
          <li class="custom-shadow aside-bar-h d-flex align-items-center cursor-pointer ' . $box_styleQR . '"
              onclick="window.location.href=\'' . $qrScannerManagementLink . '\'">
            <i class="fa-solid fa-camera fs-3 ms-5 me-4 cstm-icon-clr ' . $text_whiteQR . '"></i>
            <span class="text-decoration-none fs-5 custom-color fw-bold cstm-lttr-spcng ' . $text_whiteQR . '">QR Scanner Management</span>
          </li>

          <!-- Reports -->
          <li class="custom-shadow aside-bar-h d-flex align-items-center cursor-pointer ' . $box_styleR . '"
              onclick="window.location.href=\'' . $reportsLink . '\'">
            <i class="fa-solid fa-chart-column fs-3 ms-5 me-4 cstm-icon-clr ' . $text_whiteR . '"></i>
            <span class="text-decoration-none fs-4 custom-color fw-bold cstm-lttr-spcng ' . $text_whiteR . '">Reports</span>
          </li>
        </ul>
      </div>


      <!-- Aside Bar Footer -->
      <footer class="custom-shadow aside-bar-h d-flex-center justify-content-evenly flex-row">
        <img class="rounded-circle border border-success-subtle border-2 custom-hm-img" id="user-hm-img" src="images/profileImg/default-profile-pic.png" alt="This is profile image">
        <div class="usrnme-footer-container d-flex-center">
          <h3 class="fs-5">Name de Sample</h3>
        </div>
        <div class="dropup-center">
          <!-- ICON for logout and settings -->
          <i class="fa-solid fa-angle-up fs-2 cursor-pointer" type="button" data-bs-toggle="dropdown"></i>
          <ul class="dropdown-menu rounded-0 custom-shadow border-0 p-0">
            <li><a class="dropdown-item cstm-lttr-spcng fs-5 p-2 '. $drodownStyleText .' text-center fw-bold" href="settings.php">Settings</a></li>
            <li><a class="dropdown-item cstm-lttr-spcng fs-5 p-2 custom-color text-center fw-bold" href="#" id="logoutBtn">Logout</a></li>
          </ul>
        </div>
      </footer>

    </nav>
  ';
  
  echo '
  <!-- for logout -->
  <script src="js_backend/log-out.js"></script> 
  <script src="js_backend/get-navBar-details.js"></script>
  ';

?>