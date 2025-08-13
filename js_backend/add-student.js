$(document).ready(function(){

  // Trigger file input when camera icon is clicked
  $('#photo_cameraUpload-student').on('click', function () {
    $('#profileImageInput-addStudent').click();
  });

  // Live image preview on file select
  $('#profileImageInput-addStudent').on('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#studentProfileImg-addStudent').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // Get the value of "class_id" from the URL
  const params_add = new URLSearchParams(window.location.search);
  const classId_add = params_add.get("class_id");

  //when the add student btn is click
  $('#addStudent').on('click', function(e){
    e.preventDefault(); // stop the form from submitting

    // 1. Your nice readable object
    const studentData = {
      first_name: $('#add_firstName').val(),
      middle_name: $('#add_middleName').val(),
      last_name: $('#add_lastName').val(),
      lrn: $('#add_lrn').val(),
      gender: $('input[name="gender"]:checked').val(),
      province_code: $('#province').val(),
      municipality_code: $('#municipality').val(),
      barangay_code: $('#barangay').val(),
      birth_month: $('#birthMonth').val(),
      birth_day: $('#birthDay').val(),
      birth_year: $('#birthYear').val(),
      parent_name: $('#add_parentsFName').val(),
      parent_email: $('#add_parent_email').val(),
      classId_add: classId_add
    };

    // 2. Convert it into a FormData object
    let formData = new FormData();
    for (let key in studentData) {
      formData.append(key, studentData[key]);
    }

    // 3. Append the file
    let file = $('#profileImageInput-addStudent')[0].files[0];
    if (file) {
      formData.append('profile_image', file);
    }

    //4. Send via AJAX
    $.ajax({
      type: 'POST',
      url: 'php/add-students.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        console.log('Server response:', response);
        $('#addStudent_Form').modal('hide');
        //fetchStudents(); // Refresh student table

        //$('#studentForm')[0].reset();
        //$('#studentProfileImg').attr('src', 'images/profileImg/default-profile-pic.png'); // Reset preview if needed
      },
      error: function(xhr, status, error) {
            
        console.error('Upload error:', status, error);
      }
    });
    
  });
  
  
  
});