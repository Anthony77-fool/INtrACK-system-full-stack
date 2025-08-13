<?php

  echo '
    <!-- ASide Bar -->
    <aside class="position-fixed h-100 d-flex flex-column gap-4" id="mini-sidebar">
      
      <!-- CALENDAR -->
      <article>
        <div class="wrapper custom-shadow">
          <header class="ps-4 pt-3 pb-0 pe-3">
            <p class="current-date fs-3 fw-semibold"></p>
            <div class="icons mb-3">
              <span id="prev" class="material-symbols-rounded cursor-pointer text-center rounded-circle">chevron_left</span>
              <span id="next" class="material-symbols-rounded cursor-pointer text-center rounded-circle">chevron_right</span>
            </div>
          </header>
          <div class="calendar">
            <ul class="weeks">
              <li>Sun</li>
              <li>Mon</li>
              <li>Tue</li>
              <li>Wed</li>
              <li>Thu</li>
              <li>Fri</li>
              <li>Sat</li>
            </ul>
            <ul class="days"></ul>
          </div>
        </div>
      </article>

      <!-- TOTAL Sections -->
      <article class="custom-shadow d-flex flex-row align-items-center class-bg-color p-3">
        <!-- <i class="bi bi-diagram-3"></i> -->
        <div class="bg-white py-1 px-3 rounded-3 me-3">
          <i class="bi bi-journal-bookmark fs-1 custom-color"></i>
        </div>
        <div class="">
          <h3 class="fw-bolder m-0 custom-color total-classes">0</h3>
          <h3 class="fs-6 text-muted">Total Class</h3>
        </div>
      </article>

      <!-- Latest STudents Section -->
      <article class="custom-shadow d-flex flex-row align-items-center students-sec-bg-color p-3">
        <!-- <i class="bi bi-diagram-3"></i> -->
        <div class="bg-white py-2 px-3 rounded-3 me-3">
          <i class="fa-solid fa-user-graduate students-sec-fs custom-color" ></i>
        </div>
        <div class="">
          <h3 class="fw-bolder m-0 custom-color latest_students_total">0</h3>
          <h3 class="fs-6 text-muted">Latest Students Total</h3>
        </div>
      </article>

    </aside>
  ';

  echo '
  <!-- for countings aside bar -->
  <script src="js_backend/aside-bar.js"></script> ';

?>