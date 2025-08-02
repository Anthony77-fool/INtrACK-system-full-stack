$(document).ready(function () {
  // Toggle password visibility
  $('.toggle-password').on('click', function () {
    const $input = $($(this).data('target'));
    const type = $input.attr('type') === 'password' ? 'text' : 'password';
    $input.attr('type', type);
    $(this).toggleClass('fa-eye fa-eye-slash');
  });

  // Check password match on Sign Up
  $('#signUp-form').on('submit', function (e) {
    e.preventDefault(); // prevent default form submission

    // Get values for the new password and confirm password fields
    const newPassword = $('#new-password').val().trim();
    const confirmPassword = $('#confirm-password').val().trim();
    const $feedback = $('#password-feedback');
    const $confirmInput = $('#confirm-password');

    // Get email from URL
    const params = new URLSearchParams(window.location.search);
    const email = params.get('email');
    // Get values for the form input fields
    const firstName = $('#first-name').val().trim();
    const middleName = $('#middle-name').val().trim();
    const lastName = $('#last-name').val().trim();
    const phoneNumber = $('#phone-number').val().trim();
    const gender = $('.gender:checked').val();
    const address_code = $('#address').val();
    const province_code = $('#province').val();
    const municipality_code = $('#municipality').val();
    const barangay_code = $('#barangay').val();
    const birthMonth = $('#birthMonth').val();
    const birthDay = $('#birthDay').val();
    const birthYear = $('#birthYear').val();


    // Validate
    if (newPassword === '' || confirmPassword === '') {
      $feedback.text('Please fill in both password fields.').show();
      $confirmInput.addClass('shake error');
    } else if (newPassword !== confirmPassword) {
      $feedback.text('Passwords do not match.').show();
      $confirmInput.addClass('shake error');
    } else {
      
      // Prepare form data
      const formData = 
      'first_name=' + encodeURIComponent(firstName) + 
      '&middle_name=' + encodeURIComponent(middleName) + 
      '&last_name=' + encodeURIComponent(lastName) + 
      '&phone_number=' + encodeURIComponent(phoneNumber) +
      '&gender=' + encodeURIComponent(gender) +
      '&address_code=' + encodeURIComponent(address_code) + 
      '&province_code=' + encodeURIComponent(province_code) +
      '&municipality_code=' + encodeURIComponent(municipality_code) +
      '&barangay_code=' + encodeURIComponent(barangay_code) +
      '&birthMonth=' + encodeURIComponent(birthMonth) +
      '&birthDay=' + encodeURIComponent(birthDay) +
      '&birthYear=' + encodeURIComponent(birthYear) +
      '&email=' + encodeURIComponent(email) + 
      '&password=' + encodeURIComponent(newPassword);

      $feedback.hide();
      console.log('Form data:', formData);
      
      $.ajax({
        url: 'php/insert-user-registration.php',
        type: 'POST',
        data: formData,
        success: function (response) {
          console.log('Server response:', response);

          // Show modal
          $("#registrationSuccessModal").modal("show");

          // After modal is closed, redirect to login page
          $("#registrationSuccessModal").off("hidden.bs.modal").on("hidden.bs.modal", function () {
            window.location.href = "log-in.php";
          });
          //or
          // Redirect when "Continue" button is clicked
          $("#goToLoginBtn").off("click").on("click", function () {
            window.location.href = "log-in.php";
          });

        },
        error: function (xhr, status, error) {
          console.error('AJAX Error:', error);
        }
      });
    }

    setTimeout(() => {
      $confirmInput.removeClass('shake');
    }, 500);
  });

});
