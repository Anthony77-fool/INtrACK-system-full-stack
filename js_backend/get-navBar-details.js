$(document).ready(function(){
  $.ajax({
    url: "php_ud/get-navBar.php",
    type: "GET",
    dataType: "json",
    success: function(response){
      if(response.status === "success"){
        let fullName = response.firstName + " " + response.lastName;
        $(".usrnme-footer-container h3").text(fullName);
      } else {
        console.error(response.message);
      }
    },
    error: function(xhr, status, error){
      console.error("AJAX Error:", error);
    }
  });
});
