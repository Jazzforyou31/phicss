$(document).ready(function() {
    // Global variables for search and filter
    var currentSearchTerm = '';
    var currentRole = '';
    var searchTimer;

    // Initialize by loading all users
    loadUsers();
    console.log("Document ready, users loaded");

    // Search input handling with debounce
    $(document).on('input', '#searchInput', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            currentSearchTerm = $('#searchInput').val().trim();
            console.log('Searching for:', currentSearchTerm);
            loadUsers(currentSearchTerm, currentRole);
        }, 500); // Wait for 500ms after typing stops
    });

    // Apply filters button click
    $(document).on('click', '#applyFilters', function() {
        currentRole = $('#roleFilter').val();
        console.log('Filtering by role:', currentRole);
        loadUsers(currentSearchTerm, currentRole);
    });

    // Clear filters button click
    $(document).on('click', '#clearFilters', function() {
        $('#searchInput').val('');
        $('#roleFilter').val('');
        currentSearchTerm = '';
        currentRole = '';
        loadUsers();
        console.log('Filters cleared');
        
        // Close the modal if it's open
        var filterModal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
        if (filterModal) {
            filterModal.hide();
        }
    });

    // Handle Add New User button click
    $("#addNewUserBtn").click(function() {
        console.log("Add New User button clicked");
        // Load modal via AJAX
        $.ajax({
            url: '../../views/adminModals/addUserModal.html',
            type: 'GET',
            success: function(data) {
                console.log("Modal HTML loaded successfully");
                // Remove any existing modal to prevent duplicates
                $('#addUserModal').remove();
                
                // Append the modal HTML to the body
                $('body').append(data);
                console.log("Modal HTML appended to body");
                
                // Initialize and show the modal
                var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
                addUserModal.show();
                console.log("Modal shown");
                
                // Add click event listener for the submit button
                $(document).off('click', '#submitUserBtn').on('click', '#submitUserBtn', function() {
                    console.log('Submit button clicked');
                    
                    // Validate the form
                    var form = $('#addUserForm')[0];
                    if (!form.checkValidity()) {
                        console.log("Form validation failed");
                        form.reportValidity();
                        return;
                    }
                    console.log("Form validation passed");
                    
                    // Check if passwords match
                    var password = $('#password').val();
                    var confirmPassword = $('#confirm_password').val();
                    
                    if (password !== confirmPassword) {
                        console.log("Password mismatch");
                        alert('Passwords do not match. Please try again.');
                        return;
                    }
                    console.log("Passwords match");
                    
                    // Get form data
                    var formData = $('#addUserForm').serialize();
                    console.log('Form data serialized:', formData);
                    
                    // Log form fields individually for debugging
                    console.log('Username:', $('#username').val());
                    console.log('First Name:', $('#first_name').val());
                    console.log('Last Name:', $('#last_name').val());
                    console.log('Email:', $('#email').val());
                    console.log('Role:', $('#role').val());
                    console.log('Password length:', $('#password').val().length);
                    
                    // Submit form via AJAX
                    $.ajax({
                        url: '../../views/adminModals/addUser.php',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            console.log('Response received:', response);
                            if (response.status === 'success') {
                                // Close the modal
                                addUserModal.hide();
                                
                                // Show success message
                                alert(response.message);
                                console.log('User added successfully');
                                
                                // Reload users with current filters
                                loadUsers(currentSearchTerm, currentRole);
                            } else {
                                // Show error message
                                console.error('Error response:', response.message);
                                alert(response.message || 'An error occurred while adding the user.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                            console.log('Response Text:', xhr.responseText);
                            console.log('Status Code:', xhr.status);
                            
                            try {
                                var errorData = JSON.parse(xhr.responseText);
                                console.log('Parsed Error Data:', errorData);
                            } catch (e) {
                                console.log('Error parsing response as JSON');
                            }
                            
                            alert('An error occurred while processing your request. Please check the console for details.');
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading modal:', status, error);
                console.log('Response Text:', xhr.responseText);
                alert('Failed to load the Add User modal.');
            }
        });
    });

    // Load users from server with optional search and filter parameters
    function loadUsers(search = '', role = '') {
        console.log("Loading users with search:", search, "and role:", role);
        
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
                console.log("Users loaded successfully");
            },
            error: function(xhr, status, error) {
                console.error("Error loading users:", error);
                $('#userTable').html('<div class="no-data">Error loading users. Please try again.</div>');
            }
        });
    }

    // Handle Edit User button click
    $(document).on('click', '.edit-btn', function() {
        var userId = $(this).data('id');
        console.log("Edit button clicked for user ID:", userId);
        
        // Load user data via AJAX
        $.ajax({
            url: '../../views/adminModals/getUser.php',
            type: 'GET',
            data: { user_id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    console.log("User data retrieved:", response.user);
                    
                    // Load edit modal via AJAX
                    $.ajax({
                        url: '../../views/adminModals/editUserModal.html',
                        type: 'GET',
                        success: function(data) {
                            // Remove any existing modal to prevent duplicates
                            $('#editUserModal').remove();
                            
                            // Append the modal HTML to the body
                            $('body').append(data);
                            console.log("Edit modal HTML appended to body");
                            
                            // Populate the form with user data
                            $('#edit_user_id').val(response.user.user_id);
                            $('#edit_username').val(response.user.username);
                            $('#edit_first_name').val(response.user.first_name);
                            $('#edit_middle_name').val(response.user.middle_name);
                            $('#edit_last_name').val(response.user.last_name);
                            $('#edit_email').val(response.user.email);
                            $('#edit_role').val(response.user.role);
                            
                            console.log("Form populated with user data");
                            
                            // Initialize and show the modal
                            var editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                            editUserModal.show();
                            console.log("Edit modal shown");
                            
                            // Add click event listener for the update button
                            $(document).off('click', '#updateUserBtn').on('click', '#updateUserBtn', function() {
                                console.log('Update button clicked');
                                
                                // Validate the form
                                var form = $('#editUserForm')[0];
                                if (!form.checkValidity()) {
                                    console.log("Form validation failed");
                                    form.reportValidity();
                                    return;
                                }
                                console.log("Form validation passed");
                                
                                // Get form data
                                var formData = $('#editUserForm').serialize();
                                console.log('Form data serialized:', formData);
                                
                                // Submit form via AJAX
                                $.ajax({
                                    url: '../../views/adminModals/updateUser.php',
                                    type: 'POST',
                                    data: formData,
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log('Response received:', response);
                                        if (response.status === 'success') {
                                            // Close the modal
                                            editUserModal.hide();
                                            
                                            // Show success message
                                            alert(response.message);
                                            console.log('User updated successfully');
                                            
                                            // Reload users with current search and filter
                                            loadUsers(currentSearchTerm, currentRole);
                                        } else {
                                            // Show error message
                                            console.error('Error response:', response.message);
                                            alert(response.message || 'An error occurred while updating the user.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error:', status, error);
                                        console.log('Response Text:', xhr.responseText);
                                        alert('An error occurred while processing your request. Please check the console for details.');
                                    }
                                });
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading edit modal:', status, error);
                            alert('Failed to load the Edit User modal.');
                        }
                    });
                } else {
                    alert(response.message || 'Failed to load user data.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Failed to load user data.');
            }
        });
    });

    // Handle Delete User button click
    $(document).on('click', '.delete-btn', function() {
        var userId = $(this).data('id');
        console.log("Delete button clicked for user ID:", userId);
        
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            // Submit deletion request via AJAX
            $.ajax({
                url: '../../views/adminModals/deleteUser.php',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function(response) {
                    console.log('Delete response received:', response);
                    if (response.status === 'success') {
                        alert(response.message);
                        console.log('User deleted successfully');
                        
                        // Reload users with current search and filter
                        loadUsers(currentSearchTerm, currentRole);
                    } else {
                        console.error('Error response:', response.message);
                        alert(response.message || 'An error occurred while deleting the user.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.log('Response Text:', xhr.responseText);
                    alert('An error occurred while processing your request. Please check the console for details.');
                }
            });
        }
    });
});
