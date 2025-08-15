<?php

  $default_profile_img = 'images/profileImg/default-profile-pic.png'; // Default profile image path

  echo '
    <!-- POP UP for Viewing Student -->
    <!-- Modal -->
    <div class="modal fade" id="viewStudent_Form" tabindex="-1" aria-labelledby="formTitle_View" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <form>
            <!-- Head -->
            <header class="modal-header d-flex-center custom-shadow">
              <img src="images/inTrack-logo.jpg" alt="" id="viewModal_Header" class="w-25">
              <i class="fa-solid fa-circle-xmark cursor-pointer fs-1" id="exitView_Modal" data-bs-dismiss="modal" title="Exit Form"></i><!-- ICON for exiting modal -->
            </header>

            <!-- Inputs -->
            <div class="modal-body container">
              <div class="row">

                <!-- Photo container (Left) -->
                <div class="col-6">
                  <div class="border rounded d-flex align-items-center justify-content-center photo-container student-image-container" style="height: 415px; width: 370px">
                    <!-- IMG DATA -->
                    <img src="'. $default_profile_img .'" alt="uploaded profile image" class="w-100 h-100 object-fit-contain rounded">
                  </div>
                </div>

                <!-- LRN & Names, GENDER -->
                <div class="col-6 d-flex flex-column gap-3">
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">First Name*</label>
                    <input class="form-control" type="text" placeholder="Marck Anthony" disabled>
                  </div>

                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Middle Name*</label>
                    <input class="form-control" type="text" placeholder="Licuan" disabled>
                  </div>
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Last Name*</label>
                    <input class="form-control" type="text" placeholder="Sabado" disabled>
                  </div>
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">LRN*</label>
                    <input class="form-control" type="text" placeholder="127283642" disabled>
                  </div>

                  <!-- GENDER -->
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Gender*</label>

                    <div class="d-flex gap-3">
                      <!-- MALE -->
                      <div class="form-control d-flex align-items-center gap-2 border rounded-1">
                        <input class="form-check-input cursor-pointer" type="radio" name="gender" id="genderMale" value="Male" checked disabled>
                        <label class="form-check-label mb-0 cursor-pointer" for="genderMale">Male</label>
                      </div>
                      <!-- FEMALE -->
                      <div class="form-control d-flex align-items-center gap-2 border rounded-1">
                        <input class="form-check-input cursor-pointer" type="radio" name="gender" id="genderFemale" value="Female" disabled>
                        <label class="form-check-label mb-0 cursor-pointer" for="genderFemale">Female</label>
                      </div>
                    </div>

                  </div>

                </div>


                <!-- Address Selects -->
                <div class="mt-3">
                  <!-- Label -->
                  <label class="form-label fw-semibold fs-6 custom-color">Address*</label>

                  <div class="d-flex gap-3">
                    <!-- Province Data -->
                    <input class="form-control" type="text" disabled placeholder="Ilocos Norte">

                    <!-- Municipality Data -->
                    <input class="form-control" type="text" disabled placeholder="Pasuquin">

                    <!-- Barangay Data -->
                    <input class="form-control" type="text" disabled placeholder="Susugaen">
                  </div>
                
                </div>

                <!-- Birth Date -->
                <div class="mt-3">
                  <!-- Label -->
                  <label class="form-label fw-semibold fs-6 custom-color">Birth Date*</label>

                  <div class="d-flex gap-3">
                    <!-- Month data -->
                    <input class="form-control" type="text" disabled placeholder="Month">

                    <!-- Day data -->
                    <input class="form-control" type="text" disabled placeholder="11">

                    <!-- Year data -->
                    <input class="form-control" type="text" disabled placeholder="2005">
                  </div>

                </div>

                <!-- Parent Credentials -->
                <div class="mt-3">
                  <!-- Label -->
                  <label class="form-label fw-semibold fs-6 custom-color">Parent Credentials*</label>

                  <div class="d-flex gap-3">
                    <input class="form-control" type="text" placeholder="Parent De Example" disabled>
                    <input class="form-control" type="text" placeholder="example@gmail.com" disabled>
                  </div>
                  
                </div>

              </div>
            </div>

            <!-- Buttons for finalizing -->
            <footer class="modal-footer d-flex-center flex-column py-5">
              <!-- Label -->
              <label class="form-label fw-semibold fs-6 custom-color">Generated QR*</label>
              
              <!-- Photo container (Left) -->
              <div class=" border rounded d-flex align-items-center justify-content-center photo-container qr-code-container">
                <!-- IMG DATA -->
                <img src="images/qr-code-sample.png" alt="uploaded profile image" class="w-100 custom-h-qr object-fit-contain rounded">
                <i class="bi bi-download fs-1" id="download_QR_Icon" title="Download QR Code"><!-- ICON for Downloading QR --></i>
              </div>
            </footer>
          </form>

        </div>
      </div>
    </div>
  ';
?>