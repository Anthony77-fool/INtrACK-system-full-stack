$(document).ready(function(){

  //this one added students comments

  $(document).on("click", ".fa-comments", function () {
    let studentName = $(this).closest("tr").find("td:nth-child(2)").text().trim();
    let studentId = $(this).data("student-id");
    let sessionId = $(this).data("session-id");

    // Fill student name
    $("#commentUser").val(studentName);

    // ✅ store IDs in hidden fields for later use when saving
    $("#commentStudentId").val(studentId);
    $("#commentSessionId").val(sessionId);

    // Clear previous remark initially
    $("#commentText").val("");

    // ✅ AJAX call to get existing remark
    $.ajax({
        url: "php_reports/check-remark.php",
        method: "POST",
        data: {
            studentId: studentId,
            sessionId: sessionId
        },
        dataType: "json",
        success: function (res) {
            if (res.status === "success" && res.hasRemark) {
                // Pre-fill textarea with existing remark
                $("#commentText").val(res.remark);
            }
            // else leave it blank
        },
        error: function (err) {
            console.error("Error fetching remark:", err);
        }
    });

    // Show the modal
    new bootstrap.Modal(document.getElementById("commentModal")).show();
  });


  // Handle form submission for adding/editing a remark
  $("#commentForm").on("submit", function (e) {
      e.preventDefault(); // Prevent the default form submission (page reload)

      // ✅ Get IDs and remark text from hidden fields & textarea
      let studentId = $("#commentStudentId").val();
      let sessionId = $("#commentSessionId").val();
      let remark = $("#commentText").val();

      // ✅ Send AJAX request to save or update the remark
      $.ajax({
          url: "php_reports/save-remarks.php", // PHP endpoint
          method: "POST",
          data: {
              sessionId: sessionId,
              studentId: studentId, 
              remark: remark
          },
          success: function(response) {
              // Response is already a parsed JSON object
              let res = response;

              if (res.status === "success") {
                  // ✅ Close the modal
                  $("#commentModal").modal("hide");

                  // ✅ Update the comment icon to indicate active remark
                  let icon = $(`.fa-comments[data-student-id="${res.studentId}"][data-session-id="${res.sessionId}"]`);
                  icon.removeClass("custom-color cstm-view-icon")
                      .addClass("cstm-view-icon");

                  // ✅ Show a Bootstrap toast notification
                  showToast("Remark successfully saved");
              } else {
                  // ❌ Show alert if error occurs
                  alert("Error: " + res.message);
              }
          },
          error: function(error){
              console.error("AJAX Error:", error);
          }
      });
  });

  // ------------------------
  // Function to show a Bootstrap toast
  // ------------------------
  function showToast(message) {
      // Create toast HTML if it doesn't exist
      if ($("#liveToast").length === 0) {
          $("body").append(`
              <div class="position-fixed top-0 start-50 translate-middle-x py-3 px-3" style="z-index: 1080;">
                  <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                      <div class="d-flex-center">
                          <div class="toast-body fs-5"></div>
                      </div>
                  </div>
              </div>
          `);
      }

      // Set the message
      $("#liveToast .toast-body").text(message);

      // Initialize and show the toast
      let toastEl = document.getElementById('liveToast');
      let bsToast = new bootstrap.Toast(toastEl);
      bsToast.show();
  }

});