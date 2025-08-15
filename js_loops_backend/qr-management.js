$(document).ready(function() {

	$.ajax({
			url: "php/get-classes.php", // Adjust path if needed
			type: "GET",
			dataType: "json",
			success: function(response) {
					if (response.status === "success") {
							let $classSelect = $("#classSelect");
							$classSelect.empty(); // clear any existing options
							$classSelect.append('<option selected disabled>Select Class</option>');
							
							// Append fetched classes
							response.classes.forEach(function(cls) {
									let optionText = `${cls.grade_level} - ${cls.section_name} (${cls.strand}, SY: ${cls.school_year})`;
									$classSelect.append(
											`<option value="${cls.class_id}">${optionText}</option>`
									);
							});
					} else {
							alert("Error: " + response.message);
					}
			},
			error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
			}
	});

	// Handle "Generate Session" click
	$("#generateSessionBtn").click(function () {
			const class_id = $("#classSelect").val();
			const attendance_type = $("#attendanceTypeSelect").val();

			if (!class_id || !attendance_type) {
					alert("Please select both class and attendance type.");
					return;
			}

			// Get laptop date & time
			const now = new Date();
			const date_created = now.toISOString().split("T")[0]; // YYYY-MM-DD
			const time_created = now.toTimeString().split(" ")[0]; // HH:MM:SS

			$.ajax({
					url: "php/create-session.php",
					type: "POST",
					dataType: "json",
					data: {
							class_id: class_id,
							attendance_type: attendance_type,
							date_created: date_created,
							time_created: time_created
					},
					success: function(response) {
							if (response.status === "success") {
									let sessionId = response.session_id; // Now you have the ID

									let modal = new bootstrap.Modal(document.getElementById("sessionSuccessModal"));
									modal.show();

									// Redirect after modal is closed, passed also session id
									document.getElementById("sessionSuccessModal").addEventListener("hidden.bs.modal", function () {
											window.location.href = "qrCodeScanner.php?session_id=" + sessionId;
									});
							} else {
									alert("Error: " + response.message);
							}
					},
					error: function(xhr, status, error) {
							console.error("AJAX Error:", status, error);
							alert("An unexpected error occurred. Please try again.");
					}
			});

	});

});
