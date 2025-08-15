$(document).ready(function () {

  // Works for all your radio-label pairs with this structure:
  // <input type="radio"> <label class="form-check-label">Text</label>
  $(document).on('click', 'label.form-check-label', function (e) {
    e.preventDefault();             // avoid any default scroll/focus quirks
    e.stopPropagation();            // avoid parent handlers undoing it
    const $radio = $(this).siblings('input[type="radio"]').first();
    if ($radio.length && !$radio.prop('disabled')) {
      // Use the native .click() to mimic a real user click
      $radio[0].click();
      $radio.trigger('change');     // if you have listeners
    }
  });

  // Trigger file input when camera icon is clicked
  $('#update_Editing-Photo').on('click', function () {
    $('#update_profileImageInput').click();
  });

  // Live image preview on file select
  $('#update_profileImageInput').on('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#update_studentProfileImg').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // Initialize the modal for editing student
  $('#openConfirmUpdate').on('click', function () {
    console.log("Confirm Update button clicked");
    const $form = $('#editStudent_Form');
    const studentId = $form.data('student-id');

    // Create FormData object
    const formData = new FormData();
    formData.append('student_id', studentId);
    formData.append('first_name', $('[name="edit_firstName"]').val());
    formData.append('middle_name', $('[name="edit_middleName"]').val());
    formData.append('last_name', $('[name="edit_lastName"]').val());
    formData.append('lrn', $('[name="edit_lrn"]').val());
    formData.append('gender', $('[name="edit_Gender"]:checked').val());
    formData.append('birth_month', $('#edit_BirthMonth').val());
    formData.append('birth_day', $('#edit_BirthDay').val());
    formData.append('birth_year', $('#edit_BirthYear').val());
    formData.append('province_code', $('#edit_province').val());
    formData.append('municipality_code', $('#edit_municipality').val());
    formData.append('barangay_code', $('#edit_barangay').val());
    formData.append('parent_FName', $('[name="parent_FName"]').val());
    formData.append('parent_email', $('[name="parent_email"]').val());

    // Append file if selected (FIXED ID)
    const file = $('#update_profileImageInput')[0].files[0];
    if (file) {
      formData.append('profile_image', file);
    }

    for (let [key, value] of formData.entries()) {
      if (key === 'profile_image' && value instanceof File) {
        console.log(key, value.name); // Show file name for file input
      } else {
        console.log(key, value);
      }
    }

    $.ajax({
      url: 'php/update-student.php',
      method: 'POST',
      data: formData,
      processData: false,     // Important for file upload
      contentType: false,     // Important for file upload
      success: function (response) {
        console.log('Update response:', response);
        $('#editStudent_Form').modal('hide');
        
        fetchStudents(); // Refresh student table

        //refresh and remove search input
        $("#searchInput-students").val('');

        // Set message
        $('#notification_Toast .toast-body').text('Student updated successfully!');
        
        // Change color to green
        $('#notification_Toast')
            .removeClass('text-bg-danger text-bg-warning text-bg-info')
            .addClass('text-bg-success');
        
        // Show toast
        new bootstrap.Toast(document.getElementById('notification_Toast'), { delay: 2000 }).show();
        
      },
      error: function () {
        alert('Update failed!');
      }

    });
    
  });

});

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
              <i class="bi bi-trash-fill text-danger cursor-pointer delete-student" title="Delete Student" data-student-id="${student.stud_id}"></i>
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
