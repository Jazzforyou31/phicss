$(document).ready(function () {
    // Current search value
    var currentSearchTerm = '';
    var searchTimer;
    
    // Handle search input
    $("#officersSearchInput").on("input", function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            currentSearchTerm = $("#officersSearchInput").val().trim();
            loadOfficersWithSearch(currentSearchTerm);
        }, 500); // 500ms debounce delay
    });
    
    // Handle search button click
    $("#officersSearchBtn").on("click", function() {
        currentSearchTerm = $("#officersSearchInput").val().trim();
        loadOfficersWithSearch(currentSearchTerm);
    });
    
    // Open the modal when the "Add Officer" button is clicked
    $("#addOfficerButton").click(function () {
        loadModal();
    });

    // Function to load the modal HTML via AJAX
    function loadModal() {
        $.ajax({
            url: "../../views/adminModals/addOfficerModal.html",
            type: "GET",
            success: function (response) {
                // Remove any existing modal
                $("#officerModal").remove();
                
                // Inject the fetched modal HTML into the page
                $("body").append(response);

                // After the modal is injected, open it using Bootstrap Modal
                openModal();
                
                // Add click handler for save button
                $("#saveOfficerBtn").on("click", function() {
                    submitOfficerForm();
                });
            },
            error: function () {
                showAlert("danger", "Failed to load the modal. Please try again.");
            }
        });
    }

    // Function to open the modal
    function openModal() {
        const modal = new bootstrap.Modal(document.getElementById('officerModal'));
        modal.show();
    }

    // Close the modal when the close button is clicked
    $("body").on("click", ".btn-close, .btn-secondary", function () {
        closeModal();
    });

    // Function to close the modal
    function closeModal() {
        const modalElement = document.getElementById('officerModal');
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
                
                // Remove the modal from the DOM after it is closed
                setTimeout(function() {
                    $("#officerModal").remove();
                }, 300);
            } else {
                $("#officerModal").remove();
            }
        }
    }

    // Show form message
    function showFormMessage(type, message) {
        const formMessage = $("#formMessage");
        formMessage.removeClass("d-none alert-success alert-danger")
            .addClass("alert-" + type)
            .html('<i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + message);
    }

    // Function to submit the officer form
    function submitOfficerForm() {
        // Get the form element
        var form = document.getElementById('addOfficerForm');
        
        // Basic form validation
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Validate image file type
        var imageInput = document.getElementById('image');
        if (imageInput.files.length > 0) {
            var file = imageInput.files[0];
            var fileType = file.type;
            var validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            
            if (validImageTypes.indexOf(fileType) === -1) {
                showFormMessage("danger", "Invalid file type. Please upload a valid image (JPEG, PNG, or GIF).");
                return;
            }
            
            // Check file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                showFormMessage("danger", "File size too large. Maximum allowed size is 5MB.");
                return;
            }
        } else {
            showFormMessage("danger", "Please select an image file.");
            return;
        }
        
        // Show loading state on submit button
        var submitBtn = $('#saveOfficerBtn');
        var originalText = submitBtn.text();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        var formData = new FormData(form);
        
        $.ajax({
            url: "../../views/adminModals/addOfficer.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                try {
                    if (response.status === "success") {
                        showFormMessage("success", "Officer successfully added!");
                        
                        // Reload the page after 1.5 seconds to reflect changes
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showFormMessage("danger", response.message || "Failed to add officer. Please try again.");
                        submitBtn.prop('disabled', false).text(originalText);
                    }
                } catch (e) {
                    showFormMessage("danger", "Invalid server response. Please try again.");
                    submitBtn.prop('disabled', false).text(originalText);
                }
            },
            error: function (xhr, status, error) {
                showFormMessage("danger", "Error: " + error);
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    }

    // Show alert - globally accessible
    window.showAlert = function(type, message) {
        // Remove any existing alerts
        $(".alert-floating").remove();
        
        // Create a new alert
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show alert-floating" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Append the alert to the body
        $("body").append(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $(".alert-floating").alert('close');
        }, 5000);
    };

    // Add custom styling for floating alerts
    const style = `
        <style>
            .alert-floating {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
            .alert-floating .fas {
                margin-right: 8px;
            }
        </style>
    `;
    $('head').append(style);

    // Make global functions available
    window.editOfficer = editOfficer;
    window.deleteOfficer = deleteOfficer;
});

// Function to load officers with search filter
function loadOfficersWithSearch(query) {
    // Show loading indicator
    $(".officers-container").html(`
        <div class="text-center p-4">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Searching officers...</p>
        </div>
    `);
    
    // Make AJAX request to search officers
    $.ajax({
        url: "../../views/adminModals/searchOfficers.php",
        type: "GET",
        data: { query: query },
        success: function(response) {
            $(".officers-container").html(response);
        },
        error: function(xhr, status, error) {
            $(".officers-container").html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> An error occurred while searching. Please try again.
                </div>
            `);
        }
    });
}

// Edit officer function - globally available
function editOfficer(id) {
    alert("Edit officer functionality is under development");
    // This will be implemented in the future
}

// Delete officer function - globally available
function deleteOfficer(id) {
    if (confirm("Are you sure you want to delete this officer?")) {
        // Show loading on the button
        var deleteBtn = document.querySelector(`.delete-btn[data-id="${id}"]`);
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        deleteBtn.disabled = true;
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../views/adminModals/deleteOfficer.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var result = JSON.parse(xhr.responseText);
                    if (result.status === 'success') {
                        // Remove the officer item from DOM
                        var officerCard = deleteBtn.closest('.officer-card');
                        if (officerCard) {
                            officerCard.remove();
                            alert("Officer deleted successfully!");
                        } else {
                            // If can't find the card, just reload the page
                            window.location.reload();
                        }
                    } else {
                        alert("Failed to delete officer: " + (result.message || "Unknown error"));
                        // Reset button
                        deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                        deleteBtn.disabled = false;
                    }
                } catch (e) {
                    alert("Invalid server response");
                    // Reset button
                    deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    deleteBtn.disabled = false;
                }
            } else {
                alert("Server error: " + xhr.status);
                // Reset button
                deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                deleteBtn.disabled = false;
            }
        };
        
        xhr.onerror = function() {
            alert("Network error occurred");
            // Reset button
            deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
            deleteBtn.disabled = false;
        };
        
        xhr.send('officer_id=' + id);
    }
} 