$(document).ready(function () {

  // Shared selectors for both HTMLs
  $('.toggle-password').on('click', function () {
    const targetInput = $($(this).data('target'));
    const type = targetInput.attr('type') === 'password' ? 'text' : 'password';
    targetInput.attr('type', type);

    // Toggle icon class
    $(this).toggleClass('fa-eye fa-eye-slash');
  });

  // Handle password match check on "Change Password" button click
  $('#change-pass-btn').on('click', function () {
    const newPassword = $('#new-password').val().trim();
    const confirmPassword = $('#confirm-password').val().trim();

    //if 2 password is !not equal
    if (newPassword !== confirmPassword || newPassword === "") {
      $('#password-feedback').show();
      $('#confirm-password').addClass('is-invalid shake');

      // Remove shake class after 500ms to allow retriggering
      setTimeout(() => {
        $('#confirm-password').removeClass('shake');
      }, 500);

    } else {
      //else both are true
      $('#password-feedback').hide();
      $('#confirm-password').removeClass('is-invalid').addClass('is-valid');

      //AJAX for setting new password
      $.ajax({
        url: "php/setNew-password.php",
        method: "POST",
        data: {
          email: $("#change-pass-email-input").val(),
          newPassword: $("#new-password").val()
        },
        success: function(response) {

          if (response.status === "success") {
            // Show the modal
            $("#passwordChangedModal").modal("show");

            // Reset fields
            $("#new-password, #confirm-password").val("").removeClass("is-valid is-invalid");

            // Redirect to login.php when modal is closed
            $("#passwordChangedModal").on("hidden.bs.modal", function () {
              window.location.href = "log-in.php";
            });

            // Also redirect if user clicks Proceed button
            $("#proceed-btn").on("click", function () {
              window.location.href = "log-in.php";
            });

          } else {
            alert("Error: " + response.message);
          }

        },
        error: function(xhr, status, error) {
          console.error("AJAX Error:", xhr.responseText);
        }
      });

    }
  });

});
