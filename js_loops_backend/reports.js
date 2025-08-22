$(document).ready(function(){
  
  // Populate Class dropdown
  $.ajax({
    url: "php_reports/get-classes.php",
    method: "GET",
    dataType: "json",
    success: function (response) {

      let $classSelect = $("#classSelect");

      $classSelect.empty().append(`<option disabled selected>Select Class</option>`);
      response.forEach(cls => {
        $classSelect.append(`<option value="${cls.class_id}">${cls.section_name}</option>`);
      });

    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", status, error);
      console.log("Response Text:", xhr.responseText);
    }
  });

  // When attendance type is chosen
  $("#attendanceTypeSelect").on("change", function () {
    let classId = $("#classSelect").val();        // already selected
    let type = $(this).val();                     // In / Out

    console.log("ClassId: ", classId);

    if (!classId || !type) {
      alert("Please select a class first.");
      return;
    }

    $.ajax({
      url: "php_reports/get-session-dates.php",
      method: "POST",
      data: { class_id: classId, type: type },
      dataType: "json",
      success: function (response) {
        console.log("sessions:", response);

        // reset dropdowns
        $("#monthSelect").empty().append(`<option disabled selected>Select Month</option>`);
        $("#daySelect").empty().append(`<option disabled selected>Select Day</option>`);
        $("#yearSelect").empty().append(`<option disabled selected>Select Year</option>`);

        let months = new Set(), days = new Set(), years = new Set();

        response.forEach(sess => {
          let d = new Date(sess.date_created);
          months.add(d.toLocaleString('default', { month: 'long' }));
          days.add(d.getDate());
          years.add(d.getFullYear());
        });

        months.forEach(m => $("#monthSelect").append(`<option value="${m}">${m}</option>`));
        days.forEach(d => $("#daySelect").append(`<option value="${d}">${d}</option>`));
        years.forEach(y => $("#yearSelect").append(`<option value="${y}">${y}</option>`));
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response Text:", xhr.responseText);
      }
    });
  });

  // Render default notice (when no class is chosen yet)
  function renderDefaultNotice() {
    $("#attendanceSection")
      .html(`
        <div class="text-center text-muted py-5">
          <i class="fa-solid fa-circle-exclamation fs-1 mb-3"></i>
          <p class="fs-5 fw-bold">Please generate a report first</p>
        </div>
      `)
      .addClass("custom-shadow"); // ✅ add class here
  }

  // Render the attendance table
  function renderAttendanceTable(data) {
    // Build the table skeleton with headers
    let tableHtml = `
      <table class="table table-borderless">
        <thead>
          <tr>
            <th class="text-muted fs-5 text-center">#</th>
            <th class="text-muted fs-5 text-center">Name</th>
            <th class="text-muted fs-5 text-center">Present</th>
            <th class="text-muted fs-5 text-center">Absent</th>
            <th class="text-muted fs-5 text-center">Note</th>
          </tr>
        </thead>
        <tbody id="attendanceTableBody">
        </tbody>
      </table>
    `;

    // Inject the table into the page and add a shadow class for styling
    $("#attendanceSection").html(tableHtml).addClass("custom-shadow");

    let $tableBody = $("#attendanceTableBody");

    // Loop through all student data to build table rows
    data.forEach((student, index) => {
      // Determine the circle color for Present/Absent
      let presentIconClass = (student.status === "Present") ? "text-success" : "custom-color";
      let absentIconClass  = (student.status === "ABSENT")  ? "text-success" : "custom-color";

      // Append a new row for the student
      // The Note cell gets a temporary spinner while we check for remarks
      $tableBody.append(`
        <tr>
          <td class="text-black-50 fw-bolder fs-6 text-center">${index + 1}</td>
          <td class="text-black-50 fw-bolder fs-6 text-center">${student.firstName} ${student.lastName}</td>
          <td class="text-center">
            <i class="fa-solid fa-circle ${presentIconClass} border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i>
          </td>
          <td class="text-center">
            <i class="fa-solid fa-circle ${absentIconClass} border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i>
          </td>
          <td class="text-center" id="noteCell-${student.student_id}-${student.session_id}">
            <i class="fa-solid fa-spinner fa-spin fs-5 text-muted"></i> <!-- temporary spinner -->
          </td>
        </tr>
      `);

      // Call AJAX to check if a remark exists for this student/session
      checkRemark(student.student_id, student.session_id);
    });
  }

  // Check if a student has a remark and update the Note icon
  function checkRemark(studentId, sessionId) {
    $.ajax({
      url: "php_reports/check-remark.php", // Your server endpoint
      method: "POST",
      dataType: "json",
      data: { studentId, sessionId },
      success: function(res) {
        // Determine icon class based on whether a remark exists
        let iconClass = res.hasRemark ? "cstm-view-icon" : "custom-color";

        // Replace spinner with the correct comment icon
        $(`#noteCell-${studentId}-${sessionId}`).html(`
          <i class="fa-solid fa-comments ${iconClass} fs-4 cursor-pointer" 
            data-student-id="${studentId}" 
            data-session-id="${sessionId}"></i>
        `);
      },
      error: function() {
        // If AJAX fails, fallback to default gray icon
        $(`#noteCell-${studentId}-${sessionId}`).html(`
          <i class="fa-solid fa-comments custom-color fs-4 cursor-pointer" 
            data-student-id="${studentId}" 
            data-session-id="${sessionId}"></i>
        `);
      }
    });
  }

  // When "Generate Report" button is clicked
  $("#generateReport-btn").on("click", function () {
    let classId   = $("#classSelect").val();
    let type      = $("#attendanceTypeSelect").val();
    let month     = $("#monthSelect").val();
    let day       = $("#daySelect").val();
    let year      = $("#yearSelect").val();

    // Validation
    if (!classId || !type || !month || !day || !year) {
      alert("Please make sure all fields are selected before generating a report.");
      return;
    }

    // Debug log
    console.log("Generating report with values:");
    console.log("Class ID:", classId);
    console.log("Type:", type);
    console.log("Month:", month);
    console.log("Day:", day);
    console.log("Year:", year);

    // Example: AJAX call to fetch report
    $.ajax({
      url: "php_reports/generate-report.php",
      method: "POST",
      data: {
        class_id: classId,
        type: type,
        month: month,
        day: day,
        year: year
      },
      dataType: "json",
      success: function (response) {
        console.log("Report Data:", response);

        if (response.status === "error") {
          // Case: no session found
          renderDefaultNotice();
          return;
        }

        if (response.status === "success" && Array.isArray(response.students)) {
          if (response.students.length > 0) {
            renderAttendanceTable(response.students);
          } else {
            renderDefaultNotice(); // No students in this report
          }
        } else {
          renderDefaultNotice(); // Fallback if response format is unexpected
        }
        
      },
      error: function (xhr, status, error) {
         renderDefaultNotice(); // show "Please generate report first"
        console.error("AJAX Error:", status, error);
        console.log("Response Text:", xhr.responseText);
      }
    });
  });

});