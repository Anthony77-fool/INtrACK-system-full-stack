$(document).ready(function() {

  $.ajax({
    url: 'php/get-session.php',
    method: 'GET',
    success: function(response) {
      if (response.status === 'success') {
        console.log('Logged in as user:', response.user_id);
        // Do something with user_id
      } else {
        window.location.href = 'login.html';
      }
    }
  });

});