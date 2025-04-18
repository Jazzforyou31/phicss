$(document).ready(function () {
    // Debug message on page load
    console.log("News page loaded");
    
    // Current search value
    var currentSearchTerm = '';
    var searchTimer;
    
    // Handle search input
    $("#newsSearchInput").on("input", function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            currentSearchTerm = $("#newsSearchInput").val().trim();
            loadNewsWithSearch(currentSearchTerm);
        }, 500); // 500ms debounce delay
    });
    
    // Handle search button click
    $("#newsSearchBtn").on("click", function() {
        currentSearchTerm = $("#newsSearchInput").val().trim();
        loadNewsWithSearch(currentSearchTerm);
    });
    
    // Function to load news with search filter
    function loadNewsWithSearch(query) {
        console.log("Searching news with query:", query);
        
        // Show loading indicator
        $(".news-container").html(`
            <div class="text-center p-4">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Searching news...</p>
            </div>
        `);
        
        // Make AJAX request to search news
        $.ajax({
            url: "../../views/adminModals/searchNews.php",
            type: "GET",
            data: { query: query },
            success: function(response) {
                $(".news-container").html(response);
                console.log("Search results loaded");
            },
            error: function(xhr, status, error) {
                console.error("Error searching news:", error);
                $(".news-container").html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> An error occurred while searching. Please try again.
                    </div>
                `);
            }
        });
    }
    
    // Function to reload news content without refreshing the page
    function loadNewsContent() {
        console.log("Loading news content dynamically");
        
        // Show loading indicator
        const loadingHtml = `
            <div class="text-center p-4">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading news...</p>
            </div>
        `;
        $(".news-container").html(loadingHtml);
        
        // If there's a current search term, use the search endpoint
        if (currentSearchTerm) {
            loadNewsWithSearch(currentSearchTerm);
            return;
        }
        
        // Fetch updated news content
        $.ajax({
            url: "../../views/adminModals/getNews.php", 
            type: "GET",
            success: function (response) {
                // Replace the content in the news container
                $(".news-container").html(response);
                console.log("News content refreshed successfully");
            },
            error: function (xhr, status, error) {
                console.error("Error refreshing news content:", error);
                $(".news-container").html('<div class="alert alert-danger">Failed to load news. Please refresh the page.</div>');
            }
        });
    }
    
    // Open the modal when the "Add News" button is clicked
    $("#addNewsButton").click(function () {
        loadModal();
    });

    // Function to load the modal HTML via AJAX
    function loadModal() {
        // Add debug log to track how many times this is called
        console.log("loadModal called");
        
        $.ajax({
            url: "../../views/adminModals/addNewsModal.html", // Path to the modal HTML
            type: "GET",
            success: function (response) {
                // Remove any existing modal
                $("#newsModal").remove();
                
                // Inject the fetched modal HTML into the page
                $("body").append(response);

                // Set current date as default
                var today = new Date().toISOString().split('T')[0];
                $("#news_date").val(today);

                // After the modal is injected, open it using Bootstrap Modal
                openModal();
            },
            error: function () {
                showAlert("danger", "Failed to load the modal. Please try again.");
            }
        });
    }

    // Function to open the modal
    function openModal() {
        const modal = new bootstrap.Modal(document.getElementById('newsModal'));
        modal.show();
    }

    // Close the modal when the close button is clicked
    $("body").on("click", ".close", function () {
        closeModal();
    });

    // Function to close the modal
    function closeModal() {
        const modalElement = document.getElementById('newsModal');
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
                
                // Remove the modal from the DOM after it is closed
                setTimeout(function() {
                    $("#newsModal").remove();
                }, 300);
            } else {
                $("#newsModal").remove();
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

    // Function to show alert messages
    function showAlert(type, message) {
        // Remove any existing alerts
        $('.alert-container').remove();
        
        // Create alert container
        const alertContainer = $('<div class="alert-container" style="position: fixed; top: 20px; right: 20px; max-width: 350px; z-index: 10000;"></div>');
        
        // Create alert element
        const alert = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
        
        // Add to container and append to body
        alertContainer.append(alert);
        $('body').append(alertContainer);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            alert.alert('close');
        }, 5000);
    }

    // Handle form submission
    $("body").on("submit", "#addNewsForm", function (e) {
        e.preventDefault(); // Prevent normal form submission

        // Basic form validation
        var form = this;
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
        }

        // Show loading state on submit button
        var submitBtn = $('button[type="submit"][form="addNewsForm"]');
        var originalText = submitBtn.text();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        var formData = new FormData(form); // Get the form data

        $.ajax({
            url: "../../views/adminModals/addNews.php", // The PHP file to handle the form data
            type: "POST",
            data: formData,
            processData: false, // Don't process the data
            contentType: false, // Don't set content type header
            success: function (response) {
                try {
                    var result = JSON.parse(response); // Assuming JSON response
                    if (result.status === "success") {
                        showFormMessage("success", "News article successfully saved!");
                        
                        // Reload the page after 1.5 seconds to reflect changes
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showFormMessage("danger", "Failed to add news article. Please try again.");
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
    });

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

    // Count edit and delete buttons on page load
    var editButtons = document.querySelectorAll('.edit-btn');
    var deleteButtons = document.querySelectorAll('.delete-btn');
    
    console.log("Edit buttons found: " + editButtons.length);
    console.log("Delete buttons found: " + deleteButtons.length);

    // Make global functions available
    window.editNews = editNews;
    window.deleteNews = deleteNews;
    window.submitEditForm = submitEditForm;
});

// Edit news function - globally available
function editNews(id) {
    console.log("Edit function called for ID: " + id);
    
    // Show loading state on the button
    document.querySelector(`.edit-btn[data-id="${id}"]`).innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    // First, let's load the modal HTML
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../../views/adminModals/editNewsModal.html', true);
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Remove any existing modal
            var existingModal = document.getElementById('editNewsModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add the modal HTML to the page
            document.body.insertAdjacentHTML('beforeend', xhr.responseText);
            
            // Now get the news details to populate the form
            var detailsXhr = new XMLHttpRequest();
            detailsXhr.open('GET', '../../views/adminModals/editNews.php?news_id=' + id, true);
            
            detailsXhr.onload = function() {
                // Reset the edit button
                document.querySelector(`.edit-btn[data-id="${id}"]`).innerHTML = '<i class="fas fa-pencil-alt"></i>';
                
                if (detailsXhr.status === 200) {
                    try {
                        var result = JSON.parse(detailsXhr.responseText);
                        
                        if (result.status === 'error') {
                            // Check for authentication errors
                            if (result.message === 'Authentication required') {
                                alert("Your session has expired. Please log in again.");
                                window.location.href = "../../accounts/login.php";
                                return;
                            } else if (result.message === 'Insufficient permissions') {
                                alert("You don't have permission to edit news articles.");
                                return;
                            }
                        }
                        
                        if (result.status === 'success') {
                            var news = result.data;
                            
                            // Populate form fields
                            document.getElementById('edit_news_id').value = news.news_id;
                            document.getElementById('edit_news_title').value = news.news_title;
                            document.getElementById('edit_news_description').value = news.news_description;
                            document.getElementById('edit_message').value = news.message || '';
                            document.getElementById('edit_category').value = news.category || '';
                            document.getElementById('edit_author').value = news.author;
                            document.getElementById('edit_news_date').value = news.news_date;
                            document.getElementById('current_image').value = news.image || '';
                            
                            // Show image preview
                            var previewImg = document.getElementById('current_image_preview');
                            previewImg.src = "../../assets/images/" + news.image;
                            
                            // Show the modal
                            var modal = new bootstrap.Modal(document.getElementById('editNewsModal'));
                            modal.show();

                            // Add form submission handler with debugging
                            var editForm = document.getElementById('editNewsForm');
                            console.log("Edit form found:", editForm);
                            if (editForm) {
                                // Remove any existing handlers first to prevent duplicates
                                var newEditForm = editForm.cloneNode(true);
                                editForm.parentNode.replaceChild(newEditForm, editForm);
                                editForm = newEditForm;
                                
                                // Toggle image input based on checkbox
                                var keepImageCheckbox = document.getElementById('keep_current_image');
                                if (keepImageCheckbox) {
                                    keepImageCheckbox.addEventListener('change', function() {
                                        document.getElementById('edit_image').disabled = this.checked;
                                    });
                                }
                                
                                editForm.addEventListener('submit', function(e) {
                                    console.log("Form submit event triggered");
                                    e.preventDefault();
                                    submitEditForm(this);
                                });
                                
                                // Also add direct handler to submit button as backup
                                var saveButton = document.getElementById('saveChangesBtn');
                                if (saveButton) {
                                    console.log("Save button found:", saveButton);
                                    saveButton.addEventListener('click', function(e) {
                                        console.log("Save button clicked directly");
                                        e.preventDefault();
                                        if (editForm) {
                                            submitEditForm(editForm);
                                        }
                                    });
                                } else {
                                    console.error("Save button not found in modal");
                                }
                            } else {
                                console.error("Edit form not found in the DOM");
                            }
                        } else {
                            alert("Failed to load news details: " + (result.message || "Unknown error"));
                        }
                    } catch (e) {
                        alert("Invalid server response");
                        console.error("Error parsing response:", e, detailsXhr.responseText);
                    }
                } else {
                    alert("Server error while loading news details: " + detailsXhr.status);
                }
            };
            
            detailsXhr.onerror = function() {
                alert("Network error occurred while loading news details");
                document.querySelector(`.edit-btn[data-id="${id}"]`).innerHTML = '<i class="fas fa-pencil-alt"></i>';
            };
            
            detailsXhr.send();
        } else {
            alert("Failed to load edit form: " + xhr.status);
            document.querySelector(`.edit-btn[data-id="${id}"]`).innerHTML = '<i class="fas fa-pencil-alt"></i>';
        }
    };
    
    xhr.onerror = function() {
        alert("Network error occurred while loading form");
        document.querySelector(`.edit-btn[data-id="${id}"]`).innerHTML = '<i class="fas fa-pencil-alt"></i>';
    };
    
    xhr.send();
}

// Submit edit form function - globally available
function submitEditForm(form) {
    console.log("Form submission started");
    
    // Basic validation
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Find the submit button
    var submitBtn = document.querySelector('button#saveChangesBtn');
    if (!submitBtn) {
        console.error("Submit button not found!");
    } else {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    }
    
    // Create form data from the form
    var formData = new FormData(form);
    console.log("Form data created");
    
    // Debug form fields
    for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + (pair[1] instanceof File ? pair[1].name : pair[1]));
    }
    
    // Send AJAX request - using fetch API for better handling
    fetch('../../views/adminModals/editNews.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log("Response status:", response.status);
        return response.json();
    })
    .then(data => {
        console.log("Response data:", data);
        
        if (data.status === 'error') {
            // Check for authentication errors
            if (data.message === 'Authentication required') {
                alert("Your session has expired. Please log in again.");
                window.location.href = "../../accounts/login.php";
                return;
            } else if (data.message === 'Insufficient permissions') {
                alert("You don't have permission to update news articles.");
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Changes';
                }
                return;
            }
        }
        
        if (data.status === 'success') {
            alert("News article updated successfully!");
            window.location.reload();
        } else {
            alert("Failed to update news: " + (data.message || "Unknown error"));
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Save Changes';
            }
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error: " + error.message);
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Save Changes';
        }
    });
}

// Delete news function
function deleteNews(id) {
    // Show loading on the button
    const deleteBtn = document.querySelector(`.delete-btn[data-id="${id}"]`);
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    deleteBtn.disabled = true;
    
    // Load the delete modal
    $.ajax({
        url: "../../views/adminModals/deleteNews.html",
        type: "GET",
        success: function(response) {
            // Remove any existing modal
            $("#deleteNewsModal").remove();
            
            // Add the modal to the page
            $("body").append(response);
            
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('deleteNewsModal'));
            modal.show();
            
            // Reset the delete button
            deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
            deleteBtn.disabled = false;
            
            // Handle confirm delete button click
            $("#confirmDeleteBtn").off('click').on('click', function() {
                // Show loading state
                $(this).html('<i class="fas fa-spinner fa-spin me-2"></i>Deleting...');
                $(this).prop('disabled', true);
                
                // Send delete request
                $.ajax({
                    url: "../../views/adminModals/deleteNews.php",
                    type: "POST",
                    data: { news_id: id },
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.status === 'success') {
                                // Close the modal
                                modal.hide();
                                
                                // Remove the news item from DOM
                                const newsCard = deleteBtn.closest('.news-card');
                                if (newsCard) {
                                    newsCard.remove();
                                } else {
                                    // If can't find the card, reload the page
                                    window.location.reload();
                                }
                                
                                // Show success message
                                showAlert('success', 'News article deleted successfully!');
                            } else {
                                showAlert('danger', result.message || 'Failed to delete news article');
                            }
                        } catch (e) {
                            showAlert('danger', 'Invalid server response');
                        }
                    },
                    error: function() {
                        showAlert('danger', 'An error occurred while deleting the news article');
                    }
                });
            });
        },
        error: function() {
            // Reset the delete button
            deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
            deleteBtn.disabled = false;
            showAlert('danger', 'Failed to load delete confirmation');
        }
    });
}

