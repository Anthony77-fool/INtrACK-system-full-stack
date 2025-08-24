$(document).ready(function () {
  let lastResult = '';
  let scanCount = 0; // Global count that persists
  let qrScannerInstance = null;
  //get the session & class id passed at the search bar
  const urlParams = new URLSearchParams(window.location.search);
  const sessionId = urlParams.get("session_id");
  const classId = urlParams.get("class_id");

  // Start the QR scanner
  function startScanner() {
    $('#my-qr-reader').show(); // Show the scanner div
    lastResult = '';           // Reset last scanned text

    qrScannerInstance = new Html5Qrcode("my-qr-reader");

    qrScannerInstance.start(
        { facingMode: "environment" }, // Use rear camera
        { fps: 10, qrbox: 250 },
        function (decodedText, decodedResult) {
					// Only handle new scans
					if (decodedText !== lastResult) {
							lastResult = decodedText;

							// ✅ Send scan to backend, also get student name & parent email
							$.ajax({
									url: "php/insert-qr-reports.php",
									type: "POST",
									dataType: "json",
									data: {
											session_id: sessionId,
                      class_id: classId,
											student_id: decodedText, // QR code contains student_id
											date_created: new Date().toISOString().slice(0, 19).replace('T', ' ') // Format: YYYY-MM-DD HH:MM:SS
									},
									success: function (response) {
											//this is also where the email gonna be sent to the parent email
											console.log("response: ", response);

											if (response.status === "success") {
													console.log("Scan saved successfully.");
													console.log("Student parent email: ", response.parent_email);

													//increment scan Count
													scanCount++;

													// ✅ Update scan count
													$('#scan-count').text(`${scanCount}`);

													// ✅ Show student's name
													$('#qr-modal-content').html(`
															<p>Successfully recorded attendance for <strong>${response.fullname}</strong></p>
													`);
													new bootstrap.Modal(document.getElementById('qrResultModal')).show();

													// ✅ Call email function
													sendAttendanceEmail(response.fullname, response.parent_email, response.attendance_type); // or "OUT" depending on your logic

											} else if (response.status === "duplicate") {
													$('#qr-modal-content').html(`
															<p><strong>${response.fullname}</strong> is already recorded for this attendance.</p>
													`);
													new bootstrap.Modal(document.getElementById('qrResultModal')).show();

											}
											else {
                          //if student does not belong to this class
                          // Inject message into modal
                          $("#errorModalMessage").text(response.message);
                          $("#errorModal").modal("show");
													console.error("Error:", response.message);
											}
									},
									error: function (xhr, status, error) {
											console.error("AJAX Error:", status, error);
											console.log(xhr.responseText); // Logs full HTML/PHP error message
									}

							});

					}
        },
        function (errorMessage) {
            // Optional: Handle camera scan errors
        }
    ).catch(err => {
        console.error("Scanner start failed:", err);
        new bootstrap.Modal(document.getElementById('permissionModal')).show();
    });
  }

	// function to send attendance email to parent
	function sendAttendanceEmail(studentName, parentEmail, inOutStatus) {
		const currentDate = new Date();
		const date = currentDate.toLocaleDateString();
		const time = currentDate.toLocaleTimeString();
		
		emailjs.send("service_xs6nj8f", "template_utmfizu", {
			student_fullname: studentName,
			parent_email: parentEmail,
			current_date: date,
			current_time: time,
			in_out: inOutStatus
		})
		.then((response) => {
				console.log("✅ Attendance email sent!", response.status, response.text);
		})
		.catch((error) => {
				console.error("❌ Failed to send email:", error);
		});
		
	}

  // Stop the QR scanner
  function stopScanner() {
    if (qrScannerInstance) {
      qrScannerInstance.stop().then(() => {
        $('#my-qr-reader').hide(); // Hide scanner UI
        qrScannerInstance.clear(); // Clear canvas and internals
        qrScannerInstance = null;  // Reset instance
      }).catch(err => {
        console.error("Failed to stop scanner:", err);
      });
    } else {
      $('#my-qr-reader').hide(); // Just hide in fallback
    }
  }

  // When "Scan" button is clicked
  $('#scan-btn').click(function () {
    stopScanner();   // Always stop first (if previously open)
    startScanner();  // Start fresh
  });

  // When "Okay" button in result modal is clicked
  $('#qr-ok-btn').on('click', function () {
    stopScanner();                   // Stop scanner
    $('#qr-modal-content').empty(); // Clear result display
  });

  //get the session details, populate the needed
  if (sessionId) {
      $.ajax({
          url: "php/get-session-details.php",
          type: "GET",
          dataType: "json",
          data: { session_id: sessionId },
          success: function(response) {
              if (response.status === "success") {
                  let data = response.data;

                  // Populate header
                  $("header h2:eq(1)").text(`${data.grade_level} – ${data.section_name}`);
                  $("header h5:eq(1)").text(data.date);
                  $("header h5:eq(3)").text(data.time);

                  // Optional: scan count fetching can be separate
                  $("#scan-count").text("0"); 
              } else {
                  alert("Error: " + response.message);
              }
          },
          error: function(xhr, status, error) {
              console.error("AJAX Error:", status, error);
          }
      });
  }

});