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
        
        // Confirm deletion
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            // Make AJAX request to delete user
            $.ajax({
                url: '../../views/adminModals/deleteUser.php',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Show success message
                        alert(response.message);
                        
                        // Reload users with current filters
                        loadUsers(currentSearchTerm, currentRole);
                    } else {
                        // Show error message
                        alert(response.message || 'An error occurred while deleting the user.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while processing your request.');
                }
            });
        }
    });
});
