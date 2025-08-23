$(document).ready(function(){

  //this is for getting the values for navbar
  $.ajax({
    url: "php_ud/get-navBar.php",
    type: "GET",
    dataType: "json",
    success: function(response){

      if(response.status === "success"){
        //set username
        let fullName = response.firstName + " " + response.lastName;
        $(".usrnme-footer-container h3").text(fullName);

        //set profileIMG
        $('#user-hm-img').attr('src' , response.profile_image_url);

      } else {
        console.error(response.message);
      }

    },
    error: function(xhr, status, error){
      console.error("AJAX Error:", error);
    }
  });

});
