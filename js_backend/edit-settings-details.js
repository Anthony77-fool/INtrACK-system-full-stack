$(document).ready(function(){

  // Show modal when clicking camera icon
  $(document).on("click", "#photo_cameraEdit", function () {
    new bootstrap.Modal(document.getElementById("uploadProfilePicModal")).show();
  });

  // Preview selected image before upload
  $("#profilePicInput").on("change", function (e) {
    let file = e.target.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function (event) {
        $("#previewImage").attr("src", event.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // Handle Save button
  $("#saveProfilePic").on("click", function () {
    let file = $("#profilePicInput")[0].files[0];
    if (!file) {
      alert("Please select an image.");
      return;
    }

    let formData = new FormData();
    formData.append("profilePic", file);

    $.ajax({
      url: "php/upload-user-profileImg.php", // adjust path if needed
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.status === "success") {
          // Update preview everywhere
          $(".photo-container img").attr("src", res.imageUrl);
          $("#uploadProfilePicModal").modal("hide");
        } else {
          alert("Error: " + res.message);
        }
      },
      error: function (xhr, status, error) {
        console.group("Upload Error Debug");
        console.error("Status Code:", xhr.status);          // e.g. 500, 404
        console.error("Status Text:", xhr.statusText);      // e.g. Internal Server Error
        console.error("AJAX Status:", status);              // e.g. "error", "timeout"
        console.error("Thrown Error:", error);              // JS error message
        console.error("Response Text:", xhr.responseText);  // Raw PHP output
        console.groupEnd();
      }
    });
  });

});
