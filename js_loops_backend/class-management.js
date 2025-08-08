$(document).ready(function() {

  // Function to fetch and display classes
  function loadClasses() {

    // 1️⃣ Dispose existing tooltips before changing HTML
    $('[data-bs-toggle="tooltip"], [title]').tooltip('dispose');

    $.ajax({
      url: 'php/get-classes.php',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        // Check if the response is successful
        if (data.status === 'success') {
          //get classes from the response
          const classes = data.classes;
          // Generate HTML for each class
          let classHtml = '<div class="row gy-4">';

          classes.forEach(function(classObj) {
            classHtml += `
              <article class="col-6 ps-0" data-class-id="${classObj.class_id}">
                <div class="inner-container custom-shadow cstm-box-bg-clr p-4">
                  <header class="d-flex flex-row text-white border-bottom border-2 pb-2">
                    <h3 class="fw-bold me-2">Class</h3>
                    <h3 class="fw-bold">${classObj.grade_level} – ${classObj.section_name}</h3>
                  </header>
                  <div class="d-flex justify-content-between text-white pt-2">
                    <div class="info-labels fw-medium fs-5">
                      <p class="mb-1">Grade Level:</p>
                      <p class="mb-1">School Year:</p>
                      <p class="mb-1">Strand:</p>
                    </div>
                    <div class="info-data text-end fw-medium fs-5">
                      <p class="mb-1">${classObj.grade_level}</p>
                      <p class="mb-1">${classObj.school_year}</p>
                      <p class="mb-1">${classObj.strand}</p>
                    </div>
                  </div>
                  <footer class="mt-3 d-flex flex-row">
                    <a href="class-details.html" class="btn bg-white fs-5 d-flex justify-content-evenly text-success fw-bold cursor-pointer cstm-btn-w"
                      title="View Class Details" data-class-id="${classObj.class_id}">
                      View <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                    <button class="btn btn-danger cstm-btn-w fw-semibold cursor-pointer cstm-btn-w fs-5 ms-3" data-class-id="${classObj.class_id}" title="Delete Class">
                      Delete <i class="bi bi-trash-fill"></i>
                    </button>
                  </footer>
                </div>
              </article>
            `;
          });
          classHtml += '</div>';
          $('#createdClassSection').html(classHtml);

          // Clear the form fields
          $("#section-name").val('');
          $("#grade-level").val('');
          $("#schoolYearSelect").val('');
          $("#strand").val('');
        } else {
          console.log('Error:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching classes:', error); 
      }
    });
  }

  // Initial load of classes
  loadClasses();

  // Event listener for creating a new class
  $("#create-class_BTN").on("click", function(e) {
    e.preventDefault();
    
    // Immediately dispose tooltip so it doesn’t stay stuck
    const $btn = $(this); // ✅ define $btn here
    $btn.tooltip('dispose');

    // Get field values
    const sectionName = $("#section-name").val().trim();
    const gradeLevel = $("#grade-level").val().trim();
    const schoolYear = $("#schoolYearSelect").val();
    const strand = $("#strand").val().trim();

    // Validation
    if (!sectionName || !gradeLevel || !schoolYear) {
      const noticeModal = new bootstrap.Modal(document.getElementById('noticeModal'));
      noticeModal.show();
      return;
    }

    $.ajax({
      url: 'php/insert-class.php',
      method: 'POST',
      data: {
        section_name: sectionName,
        grade_level: gradeLevel,
        school_year: schoolYear,
        strand: strand
      },
      success: function(data) {
        // After successful insert, reload the classes smoothly
        loadClasses();
      },
      error: function(xhr, status, error) {
        console.error('Error inserting class:', error);
      }
    });

  });

  // Event listener for deleting a class
  $(document).on('click', '.btn-danger', function() {
    const classId = $(this).data('class-id');
    console.log('Deleting class with ID:', classId);

    // Immediately dispose tooltip so it doesn’t stay stuck
    const $btn = $(this); // ✅ define $btn here
    $btn.tooltip('dispose');

    $.ajax({
      url: 'php_ud/delete-class.php',
      method: 'POST',
      data: { class_id: classId },
      success: function(data) {
        // After successful delete, reload the classes smoothly
        console.log('Class deleted successfully');
        loadClasses();
      },
      error: function(xhr, status, error) {
        console.error('Error deleting class:', error);
      }
    });

  });

});