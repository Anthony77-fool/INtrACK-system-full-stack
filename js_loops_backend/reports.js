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
    $("#attendanceSection").html(`
      <div class="text-center text-muted py-5">
        <i class="fa-solid fa-circle-exclamation fs-1 mb-3"></i>
        <p class="fs-5 fw-bold">Please generate a report first</p>
      </div>
    `);
  }

  // Render attendance table
  function renderAttendanceTable(data) {
    // Build table wrapper + tbody
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
          <!-- Rows will be inserted -->
        </tbody>
      </table>
    `;

    // Inject the table into the section
    $("#attendanceSection").html(tableHtml);

    // Populate tbody
    let $tableBody = $("#attendanceTableBody");
    data.forEach((student, index) => {
      // Check note_status
      let commentClass = (student.note_status === "ACTIVE") 
          ? "cstm-view-icon"   // Active → styled class
          : "custom-color";    // Inactive → fallback color

      $tableBody.append(`
        <tr>
          <td class="text-black-50 fw-bolder fs-6 text-center">${index + 1}</td>
          <td class="text-black-50 fw-bolder fs-6 text-center">${student.firstName} ${student.lastName}</td>
          <td class="text-center">
            <i class="fa-solid fa-circle text-success border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i>
          </td>
          <td class="text-center">
            <i class="fa-solid fa-circle custom-color border border-2 p-1 rounded-circle fs-5 cursor-pointer"></i>
          </td>
          <td class="text-center">
            <i class="fa-solid fa-comments ${commentClass} fs-4 cursor-pointer"></i>
          </td>
        </tr>
      `);
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