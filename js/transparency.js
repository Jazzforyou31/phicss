$(document).ready(function () {
    // Handle Add Transparency Form Submission
    $("body").on("submit", "#addTransparencyForm", function (e) {
        e.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "../../views/adminModals/transparencyAdd.php", // Backend script to handle the form
            type: "POST",
            data: formData,
            dataType: "json", // Expect JSON response
            success: function (response) {
                if (response.status === "success") {
                    alert(response.message); // Display success message
                    $("#addTransparencyModal").modal("hide"); // Close the modal
                    location.reload(); // Reload the page to display changes
                } else {
                    alert("Error: " + response.message); // Display error message
                }
            },
            error: function () {
                alert("An unexpected error occurred while adding the transparency section."); // Handle general AJAX errors
            }
        });
    });
});