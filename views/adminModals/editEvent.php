<?php
require_once '../../classes/eventClass.php';
header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

// Debug logging
$debug = false;
if ($debug) {
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event = new EventClass();
    $eventId = (int)$_POST['event_id'];
    
    // 1. Get current event data
    $currentEvent = $event->getEventById($eventId);
    if (!$currentEvent) {
        echo json_encode(['status' => 'error', 'message' => 'Event not found']);
        exit;
    }
    
    // 2. Process image upload
    $keepCurrentImage = isset($_POST['keep_current_image']) && $_POST['keep_current_image'] == '1';
    
    if ($keepCurrentImage) {
        // Keep the current image
        $image = $currentEvent['image'];
        if ($debug) error_log("Keeping current image: " . $image);
    } else {
        // Check if a new image is uploaded
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
            // Handle new image upload
            $upload_dir = realpath(dirname(__FILE__) . '/../../assets/images');
            if (!$upload_dir) {
                $upload_dir = dirname(__FILE__) . '/../../assets/images';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
            }
            
            // Generate unique filename
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'event_' . time() . '_' . uniqid() . '.' . $extension;
            $upload_path = $upload_dir . '/' . $filename;
            
            if ($debug) error_log("Trying to upload new image to: " . $upload_path);
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Delete old image if exists and is not default
                if (!empty($currentEvent['image']) && $currentEvent['image'] !== 'default.png') {
                    $old_image_path = $upload_dir . '/' . $currentEvent['image'];
                    if (file_exists($old_image_path)) {
                        @unlink($old_image_path);
                        if ($debug) error_log("Deleted old image: " . $old_image_path);
                    }
                }
                $image = $filename;
                if ($debug) error_log("New image uploaded: " . $image);
            } else {
                $error = error_get_last();
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload image: ' . ($error ? $error['message'] : 'Unknown error')]);
                exit;
            }
        } else {
            // No new image uploaded and not keeping the current one - use default
            $image = 'default.png';
            if ($debug) error_log("No new image, using default");
            
            // Remove old image if it's not the default
            if (!empty($currentEvent['image']) && $currentEvent['image'] !== 'default.png') {
                $old_image_path = realpath(dirname(__FILE__) . '/../../assets/images/' . $currentEvent['image']);
                if (file_exists($old_image_path)) {
                    @unlink($old_image_path);
                    if ($debug) error_log("Deleted old image: " . $old_image_path);
                }
            }
        }
    }
    
    // 3. Validate required fields
    $required = [
        'event_name', 'event_category', 'event_audience', 
        'event_venue', 'event_start_date', 'event_end_date', 
        'event_description'
    ];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['status' => 'error', 'message' => "$field is required"]);
            exit;
        }
    }
    
    // 4. Update the event
    $result = $event->updateEvent(
        $eventId,
        $_POST['event_name'],
        $_POST['event_category'],
        $_POST['event_audience'],
        $image,
        $_POST['event_description'],
        $_POST['assigned_officers'] ?? null,
        $_POST['event_venue'],
        $_POST['event_start_date'],
        $_POST['event_end_date']
    );
    
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Event updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update event']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}