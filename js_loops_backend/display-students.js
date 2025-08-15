$(document).ready(function(){

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

  // Function to trigger search and update the table
  function triggerSearch(sortBy = '') {
      const query = $("#searchInput-students").val();

      // Get the value of "class_id" from the URL
      const params_add = new URLSearchParams(window.location.search);
      const classId_add = params_add.get("class_id");

      // Send search + sort + class_id to PHP
      $.post("includes_php/search-Students.php", {
          search: query,
          sort: sortBy,
          class_id: classId_add
      }, function (students) {
          const $tbody = $("table tbody");
          $tbody.empty();

          students.forEach((student, index) => {
              const isEven = index % 2 === 0;
              const rowClass = isEven ? '' : 'table-secondary';

              const $row = $(`
                  <tr class="inner-shadow ${rowClass}" data-student-id="${student.student_id}">
                      <td class="text-muted">${index + 1}</td>
                      <td>${student.lastName}</td>
                      <td>${student.firstName}</td>
                      <td>${student.middleName}</td>
                      <td class="d-flex flex-row align-items-center justify-content-evenly">
                          <i class="fa-solid fa-eye cstm-view-icon cursor-pointer btn-view-student"
                            data-bs-toggle="modal" data-bs-target="#viewStudent_Form"
                            title="View Student" data-student-id="${student.student_id}"></i>
                          <i class="bi bi-box-arrow-up-right text-success cursor-pointer btn-edit-student"
                            data-bs-toggle="modal" data-bs-target="#editStudent_Form"
                            title="Edit Student" data-student-id="${student.student_id}"></i>
                          <i class="bi bi-trash-fill text-danger cursor-pointer delete-student"
                            data-student-id="${student.student_id}" title="Delete Student"></i>
                      </td>
                  </tr>
              `);

              $tbody.append($row);
          });
      }, 'json');
  }


  // Call fetch on load
  fetchStudents();

  // When ENTER is pressed inside the search input
  $("#searchInput-students").on("keypress", function (e) {
    if (e.which === 13) { // 13 is Enter key
      e.preventDefault();
      triggerSearch();
    }
  });

  // When magnifying glass is clicked
  $(".fa-magnifying-glass").on("click", function () {
    triggerSearch();
  });

  // When sort options are clicked
  $(".sort-option").on("click", function (e) {
    e.preventDefault();
    const sortType = $(this).data("sort");
    triggerSearch(sortType);
  });

});