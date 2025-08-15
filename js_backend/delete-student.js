 //function for fetching students in studentlist
function fetchStudents() {
  
  // Get the value of "class_id" from the URL
  const params_add = new URLSearchParams(window.location.search);
  const classId_add = params_add.get("class_id");

  const $tbody = $("table tbody");
  $tbody.empty(); // Clear existing rows

  $.ajax({
    url: 'php/get-Students.php',
    method: 'POST',
    data: {class_id: classId_add},
    dataType: 'json',
    success: function (students) {
      console.log("Fetched students:", students);

      students.forEach((student, index) => {
        const isEven = index % 2 === 1;
        const rowClass = isEven ? 'table-secondary' : '';

        const $row = $(`
          <tr class="inner-shadow ${rowClass}" data-student-id="${student.student_id}">
            <td class="text-muted">${index + 1}</td>
            <td>${student.lastName}</td>
            <td>${student.firstName}</td>
            <td>${student.middleName}</td>
            <td class="d-flex flex-row align-items-center justify-content-evenly">
              <i class="fa-solid fa-eye cstm-view-icon cursor-pointer btn-view-student" data-bs-toggle="modal" data-bs-target="#viewStudent_Form" title="View Student" data-student-id="${student.student_id}"></i>
              <i class="bi bi-box-arrow-up-right text-success cursor-pointer btn-edit-student" data-bs-toggle="modal" data-bs-target="#editStudent_Form" title="Edit Student" data-student-id="${student.student_id}"></i>
              <i class="bi bi-trash-fill text-danger cursor-pointer delete-student" title="Delete Student" data-student-id="${student.student_id}"></i>
            </td>
          </tr>
        `);

        $tbody.append($row);
      });
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", status, error);
    }
  });

}

let studentIdToDelete = null;
// Handle delete student button click
// This will show a confirmation modal before deletion
$(document).on('click', '.delete-student', function () {
  studentIdToDelete = $(this).data('student-id');

  console.log("Delete student ID:", studentIdToDelete);

  $('#confirmDeleteModal').modal('show');
});

// Handle confirmation of deletion
// This will send an AJAX request to delete the student
$('#confirmDeleteBtn').on('click', function () {
  if (studentIdToDelete) {
    $.ajax({
      url: `php/delete-student.php`, // Or your API endpoint
      type: 'POST',              // PHP usually uses POST
      data: { student_id: studentIdToDelete },
      success: function (response) {
        $('#confirmDeleteModal').modal('hide');
        // Optionally reload or update the UI
        fetchStudents();

        //refresh and remove search input
        $("#searchInput-students").val('');

        // Set message
        $('#notification_Toast .toast-body').text('Student removed successfully!');
        
        // Change color to green
        $('#notification_Toast')
            .removeClass('text-bg-danger text-bg-success text-bg-info')
            .addClass('text-bg-warning');
        
        // Show toast
        new bootstrap.Toast(document.getElementById('notification_Toast'), { delay: 2000 }).show();

      },
      error: function () {
        alert('Failed to delete student.');
      }
    });
  }
});
