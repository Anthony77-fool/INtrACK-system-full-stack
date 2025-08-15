$(document).ready(function () {
  let lastResult = '';
  let scanCount = 0; // Global count that persists
  let qrScannerInstance = null;
  //get the session_id passed at the search bar
  const urlParams = new URLSearchParams(window.location.search);
  const sessionId = urlParams.get("session_id");

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
                scanCount++;

                // ✅ Update scan count
                $('#scan-count').text(`${scanCount}`);

                // ✅ Send scan to backend
                $.ajax({
                    url: "php/insert-qr-reports.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        session_id: sessionId,
                        student_id: decodedText, // QR code contains student_id
                        date_created: new Date().toISOString().slice(0, 19).replace('T', ' ') // Format: YYYY-MM-DD HH:MM:SS
                    },
                    success: function (response) {
                        //this is also where the email gonna be sent to the parent email
                        console.log("response: ", response);

                        if (response.status === "success") {
                            console.log("Scan saved successfully.");

                            // ✅ Show student's name
                            $('#qr-modal-content').html(`
                                <p>Successfully recorded attendance for <strong>${response.fullname}</strong></p>
                            `);
                            new bootstrap.Modal(document.getElementById('qrResultModal')).show();

                        } else {
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