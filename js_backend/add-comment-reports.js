$(document).ready(function(){

  //this one added students comments

  // Handle click on Note icon
  $(document).on("click", ".fa-comments", function () {
    // Get the student name from the row
    let studentName = $(this).closest("tr").find("td:nth-child(2)").text().trim();
    let studentId = $(this).data("student-id");

    // Fill modal input
    $("#commentUser").val(studentName);
    $("#commentText").val(""); // clear previous

    // Show modal
    let modal = new bootstrap.Modal(document.getElementById("commentModal"));
    modal.show();
  });

  // Handle form submit
  $("#commentForm").on("submit", function (e) {
    e.preventDefault();

    let student = $("#commentUser").val();
    let remark = $("#commentText").val();

    if (!remark.trim()) {
      alert("Please enter a remark before saving.");
      return;
    }

    // Example: send to server
    $.post("php_reports/save-remark.php", { studentId: studentId, remark: remark }, function (res) {
      console.log("Saved:", res);
      alert("Remark saved for " + student);

      // Close modal
      $("#commentModal").modal("hide");
    });
  });


});