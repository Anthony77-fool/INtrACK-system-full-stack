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

    const newPassword = $('#new-password').val().trim();
    const confirmPassword = $('#confirm-password').val().trim();
    const $feedback = $('#password-feedback');
    const $confirmInput = $('#confirm-password');

    // Get email from URL
    const params = new URLSearchParams(window.location.search);
    const email = params.get('email');

    // Get first and last name
    const firstName = $('#first-name').val().trim();
    const lastName = $('#last-name').val().trim();
    // Serialize form data
    const formData = $(this).serialize() + '&email=' + encodeURIComponent(email);

    // Validate
    if (newPassword === '' || confirmPassword === '') {
      $feedback.text('Please fill in both password fields.').show();
      $confirmInput.addClass('shake error');
    } else if (newPassword !== confirmPassword) {
      $feedback.text('Passwords do not match.').show();
      $confirmInput.addClass('shake error');
    } else {
      $feedback.hide();
      console.log('Form data:', formData);
      $.ajax({
        url: 'your-php-script.php',
        type: 'POST',
        data: formData,
        success: function (response) {
          console.log('Server response:', response);
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
