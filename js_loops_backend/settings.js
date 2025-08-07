$(document).ready(function () {
  $.ajax({
    url: 'php/get-user-info.php',
    method: 'GET',
    dataType: 'json',
    success: function (data) {

      console.log('Error:', data);

      // Check if the response is successful
      if (data.status === 'success') {
        
        const user = data.user;
        convertAddress(user.address); 
        console.log(convertAddress(user.address));

        const html = `
          <section class="custom-shadow pt-4 pb-5 px-3 container">
            <h2 class="ms-3 custom-header-fs custom-color fw-semibold">Settings</h2>

            <h4 class="fw-semibold ms-3 text-success w-25 ps-2 mt-2">Profile</h4>
            <hr class="hr-thick-success w-25 ms-3 my-0">

            <header class="row align-items-center mt-5">
              <div class="col-4 d-flex justify-content-center">
                <div class="border rounded-circle photo-container" style="height: 200px; width: 200px;">
                  <img src="${user.profileImg}" alt="uploaded profile image" class="w-100 h-100 rounded-circle object-fit-contain">
                  <i class="fa-solid fa-camera fs-2 custom-color bg-secondary-subtle border p-2 rounded-circle cursor-pointer" id="photo_cameraEdit" title="Upload Profile Picture"></i>
                </div>
              </div>
              <div class="col-8 custom-color">
                <h4 class="fw-bold text-dark">${user.fullname}</h4>
                <h5 class="mt-3">user${user.user_id}</h5>
                <h5>${user.role}</h5>
              </div>
              <i class="fa-solid fa-pen-to-square fs-2 position-absolute w-25 custom-color cursor-pointer" id="edit-user-details-icon"></i>
            </header>

            <div class="row gy-5 mt-1 ps-4">
              <div class="d-flex flex-column col-4">
                <h5 class="fw-bold">Gender</h5>
                <h6 class="custom-color">${user.gender}</h6>
              </div>
              <div class="d-flex flex-column col-4">
                <h5 class="fw-bold">Age</h5>
                <h6 class="custom-color">${user.age}</h6>
              </div>
              <div class="d-flex flex-column col-4">
                <h5 class="fw-bold">Birth Date</h5>
                <h6 class="custom-color">${user.birthdate}</h6>
              </div>
              <div class="d-flex flex-column col-4">
                <h5 class="fw-bold">Phone Number</h5>
                <h6 class="custom-color">${user.phone}</h6>
              </div>
              <div class="d-flex flex-column col-4">
                <h5 class="fw-bold">Email</h5>
                <h6 class="custom-color">${user.email}</h6>
              </div>
              <div class="d-flex flex-column col-4">
                <h5 class="fw-bold">Address</h5>
                <h6 class="custom-color" id="address-display">Loading address...</h6>
              </div>
              <div class="col-4">
                <label for="password" class="form-label fw-bold fs-5">Password</label>
                <div class="input-group">
                  <input type="password" id="password" class="form-control" value="${user.password}" disabled>
                  <button class="btn btn-outline-secondary" type="button" id="togglePassword" title="Show/Hide Password">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                  </button>
                  <button class="btn btn-outline-success" type="button" id="changePassword" title="Change Password" onclick="location.href='change-password.html'">
                    <i class="fa-solid fa-key"></i>
                  </button>
                </div>
              </div>
              <div class="d-flex flex-column col-12">
                <h5 class="fw-bold">About</h5>
                <h6 class="custom-color w-50 cstm-lttr-spcng">${user.about}</h6>
              </div>
            </div>
          </section>
        `;

        $("main").html(html);
      } else {
        $("main").html(`<h4 class="text-danger">Error: ${data.message}</h4>`);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", error);
      $("main").html('<h4 class="text-danger">Failed to load user data.</h4>');
    }
  });


  // --- Helper: Convert address codes to readable format ---
  // This function fetches the full address based on the provided codes
  // and updates the DOM with the formatted address.
  function convertAddress(address) {
    const { barangay_code, municipality_code, province_code } = address;

    // First: Get province name
    fetch(`https://psgc.gitlab.io/api/provinces/${province_code}`)
      .then(res => res.json())
      .then(province => {
        // Second: Get municipality name under that province
        fetch(`https://psgc.gitlab.io/api/provinces/${province_code}/municipalities`)
          .then(res => res.json())
          .then(municipalities => {
            const municipality = municipalities.find(m => m.code === municipality_code);

            // Third: Get barangay name under that municipality
            fetch(`https://psgc.gitlab.io/api/municipalities/${municipality_code}/barangays`)
              .then(res => res.json())
              .then(barangays => {
                const barangay = barangays.find(b => b.code === barangay_code);

                // 🧠 Assemble readable address
                const fullAddress = `${barangay.name}, ${municipality.name}, ${province.name}`;

                // 🖊️ Insert into DOM
                document.querySelector('#address-display').textContent = fullAddress;
              });
          });
      });
  }

});