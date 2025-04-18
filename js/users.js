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

$(document).ready(function() {
    // Global variables for search and filter
    var currentSearchTerm = '';
    var currentRole = '';
    var searchTimer;

    // Initialize by loading all users
    loadUsers();

    // Search input handling with debounce
    $(document).on('input', '#searchInput', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            currentSearchTerm = $('#searchInput').val().trim();
            loadUsers(currentSearchTerm, currentRole);
        }, 500); // Wait for 500ms after typing stops
    });

    // Apply filters button click
    $(document).on('click', '#applyFilters', function() {
        currentRole = $('#roleFilter').val();
        loadUsers(currentSearchTerm, currentRole);
    });

    // Clear filters button click
    $(document).on('click', '#clearFilters', function() {
        $('#searchInput').val('');
        $('#roleFilter').val('');
        currentSearchTerm = '';
        currentRole = '';
        loadUsers();
        
        // Close the modal if it's open
        var filterModal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
        if (filterModal) {
            filterModal.hide();
        }
    });

    // Handle Add New User button click
    $("#addNewUserBtn").click(function() {
        // Load modal via AJAX
        $.ajax({
            url: '../../views/adminModals/addUserModal.html',
            type: 'GET',
            success: function(data) {
                // Remove any existing modal to prevent duplicates
                $('#addUserModal').remove();
                
                // Append the modal HTML to the body
                $('body').append(data);
                
                // Initialize and show the modal
                var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
                addUserModal.show();
                
                // Add click event listener for the submit button
                $(document).off('click', '#submitUserBtn').on('click', '#submitUserBtn', function() {
                    // Validate the form
                    var form = $('#addUserForm')[0];
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }
                    
                    // Check if passwords match
                    var password = $('#password').val();
                    var confirmPassword = $('#confirm_password').val();
                    
                    if (password !== confirmPassword) {
                        alert('Passwords do not match. Please try again.');
                        return;
                    }
                    
                    // Get form data
                    var formData = $('#addUserForm').serialize();
                    
                    // Submit form via AJAX
                    $.ajax({
                        url: '../../views/adminModals/addUser.php',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Close the modal
                                addUserModal.hide();
                                
                                // Show success message
                                alert(response.message);
                                
                                // Reload users with current filters
                                loadUsers(currentSearchTerm, currentRole);
                            } else {
                                // Show error message
                                alert(response.message || 'An error occurred while adding the user.');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred while processing your request.');
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                alert('Failed to load the Add User modal.');
            }
        });
    });

    // Load users from server with optional search and filter parameters
    function loadUsers(search = '', role = '') {
        // Show loading indicator
        $('#userTable').html('<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        // Make AJAX request to get filtered users
        $.ajax({
            url: '../../views/adminModals/searchUsers.php',
            type: 'GET',
            data: {
                search: search,
                role: role
            },
            dataType: 'html',
            success: function(data) {
                $('#userTable').html(data);
            },
            error: function(xhr, status, error) {
                $('#userTable').html('<div class="no-data">Error loading users. Please try again.</div>');
            }
        });
    }

    // Handle Edit User button click
    $(document).on('click', '.edit-btn', function() {
        var userId = $(this).data('id');
        
        // Load user data via AJAX
        $.ajax({
            url: '../../views/adminModals/getUser.php',
            type: 'GET',
            data: { user_id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Load edit modal via AJAX
                    $.ajax({
                        url: '../../views/adminModals/editUserModal.html',
                        type: 'GET',
                        success: function(data) {
                            // Remove any existing modal to prevent duplicates
                            $('#editUserModal').remove();
                            
                            // Append the modal HTML to the body
                            $('body').append(data);
                            
                            // Populate the form with user data
                            $('#edit_user_id').val(response.user.user_id);
                            $('#edit_username').val(response.user.username);
                            $('#edit_first_name').val(response.user.first_name);
                            $('#edit_middle_name').val(response.user.middle_name);
                            $('#edit_last_name').val(response.user.last_name);
                            $('#edit_email').val(response.user.email);
                            $('#edit_role').val(response.user.role);
                            
                            // Initialize and show the modal
                            var editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                            editUserModal.show();
                            
                            // Add click event listener for the update button
                            $(document).off('click', '#updateUserBtn').on('click', '#updateUserBtn', function() {
                                // Validate the form
                                var form = $('#editUserForm')[0];
                                if (!form.checkValidity()) {
                                    form.reportValidity();
                                    return;
                                }
                                
                                // Get form data
                                var formData = $('#editUserForm').serialize();
                                
                                // Submit form via AJAX
                                $.ajax({
                                    url: '../../views/adminModals/updateUser.php',
                                    type: 'POST',
                                    data: formData,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            // Close the modal
                                            editUserModal.hide();
                                            
                                            // Show success message
                                            alert(response.message);
                                            
                                            // Reload users with current filters
                                            loadUsers(currentSearchTerm, currentRole);
                                        } else {
                                            // Show error message
                                            alert(response.message || 'An error occurred while updating the user.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        alert('An error occurred while processing your request.');
                                    }
                                });
                            });
                        },
                        error: function(xhr, status, error) {
                            alert('Failed to load the Edit User modal.');
                        }
                    });
                } else {
                    // Show error message
                    alert(response.message || 'An error occurred while retrieving user data.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred while retrieving user data.');
            }
        });
    });

    // Handle Delete User button click
    $(document).on('click', '.delete-btn', function() {
        var userId = $(this).data('id');
        
        // Show loading on the button
        const deleteBtn = $(this);
        deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');
        deleteBtn.prop('disabled', true);
        
        // Load the delete modal
        $.ajax({
            url: '../../views/adminModals/deleteUserModal.html',
            type: 'GET',
            success: function(response) {
                // Remove any existing modal
                $("#deleteUserModal").remove();
                
                // Add the modal to the page
                $("body").append(response);
                
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
                modal.show();
                
                // Reset the delete button
                deleteBtn.html('<i class="fas fa-trash"></i>');
                deleteBtn.prop('disabled', false);
                
                // Handle confirm delete button click
                $("#confirmDeleteBtn").off('click').on('click', function() {
                    // Show loading state
                    $(this).html('<i class="fas fa-spinner fa-spin me-2"></i>Deleting...');
                    $(this).prop('disabled', true);
                    
                    // Send delete request
                    $.ajax({
                        url: '../../views/adminModals/deleteUser.php',
                        type: 'POST',
                        data: { user_id: userId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Close the modal
                                modal.hide();
                                
                                // Remove the user row from the table
                                deleteBtn.closest('tr').fadeOut(300, function() {
                                    $(this).remove();
                                });
                                
                                // Show success message
                                showAlert('success', 'User deleted successfully!');
                                
                                // Reload users with current filters
                                loadUsers(currentSearchTerm, currentRole);
                            } else {
                                showAlert('danger', response.message || 'Failed to delete user');
                            }
                        },
                        error: function() {
                            showAlert('danger', 'An error occurred while deleting the user');
                        }
                    });
                });
            },
            error: function() {
                // Reset the delete button
                deleteBtn.html('<i class="fas fa-trash"></i>');
                deleteBtn.prop('disabled', false);
                showAlert('danger', 'Failed to load delete confirmation');
            }
        });
    });
});
