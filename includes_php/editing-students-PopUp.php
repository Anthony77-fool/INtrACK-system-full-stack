<?php

  $default_profile_img = 'images/profileImg/default-profile-pic.png'; // Default profile image path

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
                  <div class="border rounded d-flex align-items-center justify-content-center photo-container student-image-container" style="height: 415px; width: 370px">
                    <!-- IMG DATA -->
                    <img src="'. $default_profile_img .'" alt="uploaded profile image" class="h-100 w-100 object-fit-contain rounded" id="update_studentProfileImg">

                    <!-- Hidden file input -->
                    <input type="file" id="update_profileImageInput" name="profile_image" accept="image/*" hidden>

                    <i class="fa-solid fa-camera fs-2 custom-color bg-secondary-subtle border p-2 rounded-circle cursor-pointer" id="update_Editing-Photo" title="Upload Profile Picture"></i>
                  </div>
                </div>

                <!-- LRN & Names, GENDER -->
                <div class="col-6 d-flex flex-column gap-3">

                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">First Name*</label>
                    <input class="form-control" type="text" placeholder="Marck Anthony" name="edit_firstName">
                  </div>
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Middle Name*</label>
                    <input class="form-control" type="text" placeholder="Licuan" name="edit_middleName">
                  </div>
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Last Name*</label>
                    <input class="form-control" type="text" placeholder="Sabado" name="edit_lastName">
                  </div>
                  
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">LRN*</label>
                    <input class="form-control" type="text" placeholder="127283642" name="edit_lrn">
                  </div>

                  <!-- GENDER -->
                  <div>
                    <!-- Label -->
                    <label class="form-label fw-semibold fs-6 custom-color">Gender*</label>

                    <div class="d-flex gap-3">
                      <!-- MALE -->
                      <div class="form-control d-flex align-items-center gap-2 border rounded-1">
                        <input class="form-check-input cursor-pointer" type="radio" name="edit_Gender" id="genderMale" value="Male">
                        <label class="form-check-label mb-0 cursor-pointer" for="genderMale">Male</label>
                      </div>

                      <!-- FEMALE -->
                      <div class="form-control d-flex align-items-center gap-2 border rounded-1">
                        <input class="form-check-input cursor-pointer" type="radio" name="edit_Gender" id="genderFemale" value="Female">
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
                    <select id="edit_province" class="form-select cursor-pointer" name="edit_province">
                      <option selected disabled class="cursor-pointer">Select Province</option>
                    </select>

                    <!-- Municipality Dropdown -->
                    <select id="edit_municipality" class="form-select cursor-pointer" name="edit_municipality">
                      <option selected disabled class="cursor-pointer">Select Municipality</option>
                    </select>

                    <!-- Barangay Dropdown -->
                    <select id="edit_barangay" class="form-select cursor-pointer" name="edit_barangay">
                      <option selected disabled class="cursor-pointer">Select Barangay</option>
                    </select>
                  </div>
                
                </div>

                <!-- Birth Date -->
                <div class="mt-3">
                  <!-- Label -->
                  <label class="form-label fw-semibold fs-6 custom-color">Birth Date*</label>

                  <div class="d-flex gap-3">
                    <select id="edit_BirthMonth" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Month</option>
                    </select>

                    <select id="edit_BirthDay" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Day</option>
                    </select>

                    <select id="edit_BirthYear" class="form-select cursor-pointer">
                      <option selected disabled class="cursor-pointer">Select Year</option>
                    </select>
                  </div>

                </div>

                <!-- Parent Credentials -->
                <div class="mt-3">
                  <!-- Label -->
                  <label class="form-label fw-semibold fs-6 custom-color">Parent Credentials*</label>

                  <div class="d-flex gap-3">
                    <input class="form-control" type="text" placeholder="Parent De Example" name="parent_FName">
                    <input class="form-control" type="text" placeholder="example@gmail.com" name="parent_email">
                  </div>
        
                </div>

              </div>
            </div>

            <!-- Buttons for finalizing -->
            <footer class="modal-footer d-flex-center py-4 d-flex gap-5">
              <!-- Both triggered by js(opened 2nd modals) -->
              <button type="button" class="btn btn-success w-25 py-2 cstm-lttr-spcng fs-5" title="Update Student" id="openConfirmUpdate">Update</button>
              <button type="button" class="btn btn-danger w-25 py-2 cstm-lttr-spcng fs-5 openCancelConfirmBtn" title="Cancel Update" data-bs-dismiss="modal">Cancel</button>
            </footer>
          </form>

        </div>
      </div>
    </div>
  ';
?>