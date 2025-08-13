// Function to populate student form with data from the server
// This function is used for both viewing and editing student details
function populateStudentForm(studId, formId, isReadOnly = false) {
  const monthNames = [
    '', 'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
  ];

  $.ajax({
    url: 'php/get-Students.php',
    type: 'GET',
    dataType: 'json',
    success: function (students) {
      const student = students.find(s => s.student_id == studId);

      // Log the student ID being searched and all IDs from the backend
      console.log('Looking for student ID:', studId);
      console.log('Student IDs from backend:', students.map(s => s.student_id));

      if (!student) {
        alert('Student not found');
        return;
      }

      const $form = $(`#${formId}`);
      const setField = (selector, value) => {
        const $input = $form.find(selector);
        $input.val(value);
        if (isReadOnly) $input.prop('disabled', true);
      };

      //set fields for the viewing
      setField('input[placeholder="Marck Anthony"]', student.firstName);
      setField('input[placeholder="Licuan"]', student.middleName);
      setField('input[placeholder="Sabado"]', student.lastName);
      setField('input[placeholder="127283642"]', student.lrn);

      // Gender
      $form.find(`input[name="edit_Gender"][value="${student.gender}"]`).prop('checked', true);
      if (isReadOnly) {
        $form.find('input[name="gender"]').prop('disabled', true);
      }

      //Image URL
      $form.find('.photo-container img').attr('src', student.profile_img_src);

      // Address
      if (formId === 'editStudent_Form') {
        populateAddressFields($form, student);
      } else {
        fetchAndSetAddressField(formId, 'provinces', student.province_code, 'Ilocos Norte', isReadOnly);
        fetchAndSetAddressField(formId, 'cities-municipalities', student.municipality_code, 'Pasuquin', isReadOnly);
        fetchAndSetAddressField(formId, 'barangays', student.barangay_code, 'Susugaen', isReadOnly);
      }

      // Birthdate View Mode Only
      setField('input[placeholder="Month"]', monthNames[student.birthMonth] || '');
      setField('input[placeholder="11"]', student.birthDay || '');
      setField('input[placeholder="2005"]', student.birthYear || '');

      // Birthdate Edit Mode
      $('#edit_BirthMonth').val(student.birthMonth).trigger('change');
      $('#edit_BirthYear').val(student.birthYear).trigger('change');
      // Then wait and trigger day once the days are populated
      setTimeout(() => {
        $('#edit_BirthDay').val(student.birthDay);
      }, 100);

      //set fields for the viewing parentFname and Parent Email
      setField('input[placeholder="Parent De Example"]', student.parentFName);
      setField('input[placeholder="example@gmail.com"]', student.parent_email);

      // Show modal
      $form.modal('show');
    },
    error: function (xhr, status, error) {
      console.error('AJAX Error:', error, status, xhr);
    }
  });
}

// Function to populate address fields in the edit form
async function populateAddressFields(form, student) {
  const provinceCode = student.province_code;
  const municipalityCode = student.municipality_code;
  const barangayCode = student.barangay_code;

  // 1. Set province
  form.find('#edit_province').val(provinceCode).trigger('change');

  // 2. Wait for municipalities to be populated
  await fetchMunicipalities(provinceCode);
  form.find('#edit_municipality').val(municipalityCode).trigger('change');

  // 3. Wait for barangays to be populated
  await fetchBarangays(municipalityCode);
  form.find('#edit_barangay').val(barangayCode).trigger('change');
}

// Fetch municipalities and barangays based on selected province and municipality
function fetchMunicipalities(provinceCode) {
  return $.ajax({
    url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/municipalities`,
    method: 'GET'
  });
}

// Fetch barangays based on selected municipality
function fetchBarangays(municipalityCode) {
  return $.ajax({
    url: `https://psgc.gitlab.io/api/municipalities/${municipalityCode}/barangays`,
    method: 'GET'
  });
}


// View Student
$(document).on('click', '.btn-view-student', function () {
  const studId = $(this).data('student-id');
  populateStudentForm(studId, 'viewStudent_Form', true); // Read-only
});

// Edit Student
$(document).on('click', '.btn-edit-student', function () {
  console.log("Edit button clicked");
  const studId = $(this).data('student-id');
  populateStudentForm(studId, 'editStudent_Form', false); // Editable

  // store in modal for later use
  $('#editStudent_Form').data('student-id', studId);
});

// Fetch and set address field based on code and type
// This function is used to fetch address data from the PSGC API and set it in the form
function fetchAndSetAddressField(formId, apiType, code, placeholder, isReadOnly = false) {
  if (!code) return;

  fetch(`https://psgc.gitlab.io/api/${apiType}/${code}`)
    .then(res => res.json())
    .then(data => {
      const input = $(`#${formId} input[placeholder="${placeholder}"]`);
      input.val(data.name || '');
      if (isReadOnly) input.prop('disabled', true);
    })
    .catch(err => console.error(`Error fetching ${apiType} for ${code}:`, err));
}