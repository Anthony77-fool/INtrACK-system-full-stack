$(document).ready(function() {

  // Function to fetch and display classes
  function loadClasses(classId) {

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

          // Find the class with the matching class_id
          const selectedClass = classes.find(c => c.class_id == classId);
          
          //check if selectedClass is found
          if (selectedClass) {

              $('#main_sectionHeader').html(`
              <!-- Class Header -->
              <header class="d-flex flex-row align-items-center custom-header-fs custom-color fw-bold">
                <!-- Go back to class management -->
                <a href="class-management.php" class="btn cstm-icon-clr" id="link_classManagement" aria-label="Back to Class Management Page" title="Go back to Class Management">
                  <i class="bi bi-arrow-return-left fs-2 icon-boldish"></i>
                </a>
                <h3 class="me-2">Class</h3>
                <h3>${selectedClass.grade_level} – ${selectedClass.section_name}</h3> <!-- Combine grade & section -->
              </header>

              <!-- TEXT Secondary -->
              <div class="d-flex flex-row align-items-center custom-color ms-1">
                <h4 class="fs-6 me-2">S.Y. ${selectedClass.school_year}</h4>
                <h4 class="fs-6">${selectedClass.strand}</h4>
              </div>
            `);
            
          }
          
        } else {
          console.log('Error:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching classes:', error); 
      }
    });

  }

  // Get the value of "class_id" from the URL
  const params = new URLSearchParams(window.location.search);
  const classId = params.get("class_id");

  console.log("Class ID:", classId);

  // Initial load of classes
  loadClasses(classId);

});