//this is for viewing students and editing/updating


// Function to populate student form with data from the server
// This function is used for both viewing and editing student details
function populateStudentForm(studId, formId, isReadOnly = false) {
  const monthNames = [
    '', 'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
  ];

  // Get the value of "class_id" from the URL
  const params_add = new URLSearchParams(window.location.search);
  const classId_add = params_add.get("class_id");

  $.ajax({
    url: 'php/get-Students.php',
    type: 'POST',
    data: {class_id: classId_add},
    dataType: 'json',
    success: function (students) {
      
      const student = students.find(s => s.student_id == studId);

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

      //set fields for the viewing and editing
      setField('input[placeholder="Marck Anthony"]', student.firstName);
      setField('input[placeholder="Licuan"]', student.middleName);
      setField('input[placeholder="Sabado"]', student.lastName);
      setField('input[placeholder="127283642"]', student.lrn);

      // Gender
      $form.find(`input[name="edit_Gender"][value="${student.gender}"]`).prop('checked', true);
      if (isReadOnly) {
        $form.find('input[name="gender"]').prop('disabled', true);
      }

      //Image URL, display Student IMG
      $form.find('.student-image-container img').attr('src', student.image_url);

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
      (async () => {
        await populateMonths();
        $('#edit_BirthMonth').val(student.birthMonth).trigger('change');

        await populateYears();
        $('#edit_BirthYear').val(student.birthYear).trigger('change');

        await populateDays(student.birthMonth, student.birthYear);
        $('#edit_BirthDay').val(student.birthDay).trigger('change');
      })();

      //set fields for the viewing parentFname and Parent Email
      setField('input[placeholder="Parent De Example"]', student.parentFName);
      setField('input[placeholder="example@gmail.com"]', student.parent_email);

      //Image URL, display Student QR CODE
      $form.find('.qr-code-container img').attr('src', student.qr_code_img_url);
      // Save student name for download
      $('#download_QR_Icon').data('filename', `${student.firstName}_${student.lastName}_QR.png`);

      // Show modal
      $form.modal('show');
    },
    error: function (xhr, status, error) {
      console.error('AJAX Error:', error, status, xhr);
    }
  });
}

// Populate all address dropdowns in the edit form using student's saved codes
async function populateAddressFields(form, student) {
  const provinceCode = student.province_code;      // Saved province code from DB
  const municipalityCode = student.municipality_code; // Saved municipality code
  const barangayCode = student.barangay_code;      // Saved barangay code

  // --- Step 1: Load provinces into the dropdown ---
  // Wait until provinces are fetched and appended before continuing
  await fetchProvinces();
  // Set the dropdown to student's saved province and trigger 'change' event
  form.find('#edit_province').val(provinceCode).trigger('change');

  // --- Step 2: Load municipalities for the selected province ---
  await fetchMunicipalities(provinceCode);
  // Set the dropdown to student's saved municipality
  form.find('#edit_municipality').val(municipalityCode).trigger('change');

  // --- Step 3: Load barangays for the selected municipality ---
  await fetchBarangays(municipalityCode);
  // Set the dropdown to student's saved barangay
  form.find('#edit_barangay').val(barangayCode).trigger('change');
}

/**
 * Fetch the list of provinces from PSGC API
 * and populate the #edit_province dropdown.
 */
function fetchProvinces() {
  return $.ajax({
    url: 'https://psgc.gitlab.io/api/provinces.json', // Always request JSON
    method: 'GET',
    dataType: 'json'
  }).then(response => {
    // Validate: Ensure API returned an array
    if (!Array.isArray(response)) {
      console.error('Unexpected provinces API response:', response);
      return [];
    }

    const $province = $('#edit_province');
    // Clear existing options and add default placeholder
    $province.empty().append('<option disabled>Select Province</option>');

    // Append each province as an <option>
    response.forEach(p => {
      $province.append(`<option value="${p.code}">${p.name}</option>`);
    });

    return response; // Return array for further chaining if needed
  });
}

/**
 * Fetch the list of municipalities for a given province code
 * and populate the #edit_municipality dropdown.
 */
function fetchMunicipalities(provinceCode) {
  return $.ajax({
    url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/municipalities.json`,
    method: 'GET',
    dataType: 'json'
  }).then(response => {
    // Validate: Ensure API returned an array
    if (!Array.isArray(response)) {
      console.error('Unexpected municipalities API response:', response);
      return [];
    }

    const $municipality = $('#edit_municipality');
    // Clear existing options and add default placeholder
    $municipality.empty().append('<option disabled>Select Municipality</option>');

    // Append each municipality as an <option>
    response.forEach(m => {
      $municipality.append(`<option value="${m.code}">${m.name}</option>`);
    });

    return response;
  });
}

/**
 * Fetch the list of barangays for a given municipality code
 * and populate the #edit_barangay dropdown.
 */
function fetchBarangays(municipalityCode) {
  return $.ajax({
    url: `https://psgc.gitlab.io/api/municipalities/${municipalityCode}/barangays.json`,
    method: 'GET',
    dataType: 'json'
  }).then(response => {
    // Validate: Ensure API returned an array
    if (!Array.isArray(response)) {
      console.error('Unexpected barangays API response:', response);
      return [];
    }

    const $barangay = $('#edit_barangay');
    // Clear existing options and add default placeholder
    $barangay.empty().append('<option disabled>Select Barangay</option>');

    // Append each barangay as an <option>
    response.forEach(b => {
      $barangay.append(`<option value="${b.code}">${b.name}</option>`);
    });

    return response;
  });
}

// Populate months dropdown (1-12)
function populateMonths() {
  return new Promise(resolve => {
    const $month = $('#edit_BirthMonth');
    $month.empty().append('<option disabled>Select Month</option>');
    
    const monthNames = [
      '', 'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];
    
    for (let i = 1; i <= 12; i++) {
      $month.append(`<option value="${i}">${monthNames[i]}</option>`);
    }
    resolve();
  });
}

// Populate years dropdown (example: 1900–current year)
function populateYears() {
  return new Promise(resolve => {
    const $year = $('#edit_BirthYear');
    $year.empty().append('<option disabled>Select Year</option>');
    
    const currentYear = new Date().getFullYear();
    for (let y = currentYear; y >= 1900; y--) {
      $year.append(`<option value="${y}">${y}</option>`);
    }
    resolve();
  });
}

// Populate days dropdown based on selected month/year
function populateDays(month, year) {
  return new Promise(resolve => {
    const $day = $('#edit_BirthDay');
    $day.empty().append('<option disabled>Select Day</option>');

    if (!month || !year) {
      resolve();
      return;
    }

    // Get correct number of days in month/year
    const daysInMonth = new Date(year, month, 0).getDate();
    for (let d = 1; d <= daysInMonth; d++) {
      $day.append(`<option value="${d}">${d}</option>`);
    }
    resolve();
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