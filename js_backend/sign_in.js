$(document).ready(function() {

  $("#show-password").on("change", function () {
    const passwordInput = $("#password");
    const isChecked = $(this).is(":checked");
    passwordInput.attr("type", isChecked ? "text" : "password");
  });

  $("#signInBtn").on("click", function (e) {
    e.preventDefault(); // prevent default form submission

    let email = $("#email-input").val().trim();
    let password = $("#password").val().trim();
    let valid = true;

    // Reset
    $("#email-input, #password").removeClass("is-valid is-invalid");

    // Check email
    if (!email || !email.includes("@")) {
      $("#email-input").addClass("is-invalid");
      valid = false;
    } else {
      $("#email-input").addClass("is-valid");
    }

    // Check password
    if (!password) {
      $("#password").addClass("is-invalid");
      $("#password-feedback").text("Password cannot be empty.");
      valid = false;
    } else {
      $("#password").addClass("is-valid");
    }

    // If both fields are valid, proceed with login
    if (valid) {
      
      // Prepare data for AJAX request
      $.ajax({
        url: 'php/sign_in.php',
        type: 'POST',
        data: { email: email, password: password },
        success: function (response) {
          console.log('Server response:', response);
          
          if (response.status === 'success') {//successful login
            // Redirect to dashboard
            window.location.href = 'settings.php'; // or wherever you want to go

          } else {
            //accont does not exist
            //show the error notifications
            $("#loginToast").toast("show");
            // Remove is-valid and add is-invalid to email and password
            $("#email-input")
              .removeClass("is-valid")
              .addClass("is-invalid");

            $("#password")
              .removeClass("is-valid")
              .addClass("is-invalid");

            // Show feedback message
            $('#email-feedback').text(response.message).show();
            $('#password-feedback').text(response.message).show();
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error:', error);
        }
      });

    }
  });

});