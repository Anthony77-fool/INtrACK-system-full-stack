<?php

  echo '
    <!-- POP UP for Editing/Updating Student -->
    <!-- Modal -->
    <div class="modal fade" id="editStudent_Form" tabindex="-1" aria-labelledby="formTitle_Edit" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <form>
            <!-- Head -->
            <header class="modal-header d-flex-center cstm-box-bg-clr py-4">
              <h5 class="modal-title custom-header-fs text-white fw-bolder cstm-lttr-spcng" id="formTitle_Edit">Editing Student</h5>
            </header>

            <!-- Inputs -->
            <div class="modal-body container">
              <div class="row">

                <!-- Photo container (Left) -->
                <div class="col-6">
                  <div class="border rounded d-flex align-items-center justify-content-center photo-container" style="height: 415px;">
                    <!-- IMG DATA -->
                    <img src="images/profileImg/Sabado-Marck-Anthony.png" alt="uploaded profile image" class="w-100 h-100 object-fit-contain rounded">
                    <i class="fa-solid fa-camera fs-2 custom-color bg-secondary-subtle border p-2 rounded-circle cursor-pointer" id="photo_cameraEdit-student" title="Upload Profile Picture"></i>
                  </div>
                </div>

                <!-- LRN & Names, GENDER -->
                <div class="col-6 d-flex flex-column gap-3">

                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">First Name*</label>
                    <input class="form-control" type="text" placeholder="e.g. Thalia Gielyn">
                  </div>
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Middle Name*</label>
                    <input class="form-control" type="text" placeholder="e.g. Licuan">
                  </div>
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Last Name*</label>
                    <input class="form-control" type="text" placeholder="e.g. Sabado">
                  </div>
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">LRN*</label>
                    <input class="form-control" type="text" placeholder="12923486">
                  </div>

                  <!-- GENDER -->
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Gender*</label>

                    <div class="d-flex gap-3">
                      <!-- MALE -->
                      <div class="form-control d-flex align-items-center gap-2 border rounded-1">
                        <input class="form-check-input cursor-pointer" type="radio" name="gender" id="genderMale" value="Male">
                        <label class="form-check-label mb-0 cursor-pointer" for="genderMale">Male</label>
                      </div>

                      <!-- FEMALE -->
                      <div class="form-control d-flex align-items-center gap-2 border rounded-1">
                        <input class="form-check-input cursor-pointer" type="radio" name="gender" id="genderFemale" value="Female">
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
                    <!-- Province Dropdown -->
                    <select id="province" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Province</option>
                    </select>

                    <!-- Municipality Dropdown -->
                    <select id="municipality" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Municipality</option>
                    </select>

                    <!-- Barangay Dropdown -->
                    <select id="barangay" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Barangay</option>
                    </select>
                  </div>
                
                </div>

                <!-- Birth Date -->
                <div class="mt-3">
                  <!-- Label -->
                  <label class="form-label fw-semibold fs-6 custom-color">Birth Date*</label>

                  <div class="d-flex gap-3">
                    <select id="birthMonth" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Month</option>
                    </select>

                    <select id="birthDay" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Day</option>
                    </select>

                    <select id="birthYear" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Year</option>
                    </select>
                  </div>

                </div>

                <!-- Parent Credentials -->
                <div class="mt-3">
                  <!-- Label -->
                  <label class="form-label fw-semibold fs-6 custom-color">Birth Date*</label>

                  <div class="d-flex gap-3">
                    <input class="form-control" type="text" placeholder="Parent Full Name">
                    <input class="form-control" type="text" placeholder="Email Address">
                  </div>
        
                </div>

              </div>
            </div>

            <!-- Buttons for finalizing -->
            <footer class="modal-footer d-flex-center py-4 d-flex gap-5">
              <!-- Both triggered by js(opened 2nd modals) -->
              <button type="button" class="btn btn-success w-25 py-2 cstm-lttr-spcng fs-5" title="Update Student" id="openConfirmUpdate">Update</button>
              <button type="button" class="btn btn-danger w-25 py-2 cstm-lttr-spcng fs-5 openCancelConfirmBtn" title="Cancel Update" data-modal="edit">Cancel</button>
            </footer>
          </form>

        </div>
      </div>
    </div>
  ';
?>