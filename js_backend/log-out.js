$(document).ready(function() {
  $('#logoutBtn').click(function(e) {
    e.preventDefault();

    $.ajax({
      url: 'php/log-out.php',
      method: 'POST',
      data: { action: 'logout' },
      success: function(response) {
        // Optionally handle server response
        if (response.trim() === 'success') {
          window.location.href = 'log-in.php';
        } else {
          alert('Logout failed. Please try again.');
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', error);
        alert('An error occurred during logout.');
      }
    });
  });
});
