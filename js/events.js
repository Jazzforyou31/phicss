// events.js
$(document).ready(function() {
    // Show alert message
    function showAlert(message, type) {
        const alert = $('#messageAlert');
        alert.removeClass('alert-success alert-danger').addClass('alert-' + type);
        $('#alertMessage').text(message);
        alert.addClass('show');
        
        setTimeout(function() {
            alert.removeClass('show');
        }, 5000);
    }

    // Add Event Form Submission
    $('#addEventForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: '../adminModals/addEvent.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('Event added successfully!', 'success');
                    $('#addEventModal').modal('hide');
                    $('#addEventForm')[0].reset();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                showAlert('Error: ' + error, 'danger');
            }
        });
    });

    // Handle keep current image checkbox
    $(document).on('change', '#keep_current_image', function() {
        const isChecked = $(this).is(':checked');
        $('#edit_event_image').prop('disabled', isChecked);
        
        if (isChecked) {
            // Restore original image preview if checkbox is checked
            const originalImage = $('#current_image').val();
            if (originalImage) {
                if (originalImage.match(/^https?:\/\//)) {
                    $('#current_image_preview').attr('src', originalImage);
                } else {
                    $('#current_image_preview').attr('src', '../../assets/images/' + originalImage);
                }
            } else {
                $('#current_image_preview').attr('src', '../../assets/images/default.png');
            }
        }
    });

    // Edit Event - Load Data
    $('#edit_event_image').on('change', function(e) {
        if (!$('#keep_current_image').is(':checked')) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#current_image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        }
    });
    
    $(document).on('click', '.edit-btn', function() {
        const eventId = $(this).data('id');
        
        $.ajax({
            url: '../adminModals/getEventData.php',
            type: 'GET',
            data: { event_id: eventId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const event = response.data;
                    
                    // Set form values
                    $('#edit_event_id').val(event.event_id);
                    $('#edit_event_name').val(event.event_name);
                    $('#edit_event_category').val(event.event_category);
                    $('#edit_event_audience').val(event.event_audience);
                    $('#edit_event_venue').val(event.event_venue);
                    $('#edit_event_start_date').val(formatDateTimeForInput(event.event_start_date));
                    $('#edit_event_end_date').val(formatDateTimeForInput(event.event_end_date));
                    $('#edit_event_description').val(event.event_description);
                    $('#edit_assigned_officers').val(event.assigned_officers);
                    $('#current_image').val(event.image);
                    
                    // Reset the keep current image checkbox and file input
                    $('#keep_current_image').prop('checked', true);
                    $('#edit_event_image').prop('disabled', true).val('');
                    
                    // Show current image
                    if (event.image) {
                        // Check if it's a URL or a local path
                        if (event.image.match(/^https?:\/\//)) {
                            $('#current_image_preview').attr('src', event.image);
                        } else {
                            $('#current_image_preview').attr('src', '../../assets/images/' + event.image);
                        }
                        $('#current_image_preview').show();
                    } else {
                        $('#current_image_preview').attr('src', '../../assets/images/default.png');
                    }
                    
                    $('#editEventModal').modal('show');
                } else {
                    showAlert(response.message, 'danger');
                }
            }
        });
    });

    // Helper function to format date for datetime-local input
    function formatDateTimeForInput(dateTimeStr) {
        const date = new Date(dateTimeStr);
        return date.toISOString().slice(0, 16);
    }

    // Update Event
    $('#editEventForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        // Show loading indicator
        const submitBtn = $(this).find('button[type="submit"]');
        const originalBtnText = submitBtn.text();
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...').prop('disabled', true);
        
        $.ajax({
            url: '../adminModals/editEvent.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('Event updated successfully!', 'success');
                    $('#editEventModal').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(response.message, 'danger');
                    submitBtn.html(originalBtnText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                showAlert('Error: ' + error, 'danger');
                submitBtn.html(originalBtnText).prop('disabled', false);
            }
        });
    });

    // Delete Event Confirmation
    $(document).on('click', '.delete-btn', function() {
        const eventId = $(this).data('id');
        $('#delete_event_id').val(eventId);
        $('#deleteEventModal').modal('show');
    });

    // Confirm Delete
    $('#confirmDeleteEventBtn').on('click', function() {
        const eventId = $('#delete_event_id').val();
        
        $.ajax({
            url: '../adminModals/deleteEvent.php',
            type: 'POST',
            data: { event_id: eventId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('Event deleted successfully!', 'success');
                    $('#deleteEventModal').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(response.message, 'danger');
                }
            }
        });
    });
});