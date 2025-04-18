<?php
session_start();
require_once '../../classes/eventClass.php';

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Initialize response array
$response = ['status' => 'error', 'message' => ''];

try {
    // Validate required fields
    $required_fields = ['event_name', 'event_category', 'event_audience', 'event_venue', 
                       'event_start_date', 'event_end_date', 'event_description'];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("$field is required");
        }
    }

    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            throw new Exception('Invalid image type. Only JPG, PNG, and GIF are allowed.');
        }

        if ($_FILES['image']['size'] > $max_size) {
            throw new Exception('Image size too large. Maximum size is 5MB.');
        }

        // Generate unique filename
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        
        // Make sure the upload directory exists
        $upload_dir = realpath(dirname(__FILE__) . '/../../assets/images');
        if (!$upload_dir) {
            $upload_dir = dirname(__FILE__) . '/../../assets/images';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
        }
        
        $upload_path = $upload_dir . '/' . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            $image = $filename;
            $response['debug'] = 'Image saved to: ' . $upload_path;
        } else {
            $error = error_get_last();
            throw new Exception('Failed to upload image. Error: ' . ($error ? $error['message'] : 'Unknown error'));
        }
    }

    // Create event instance
    $eventClass = new EventClass();

    // Add event to database
    $result = $eventClass->addEvent(
        $_POST['event_name'],
        $_POST['event_category'],
        $_POST['event_audience'],
        $image,
        $_POST['event_description'],
        $_SESSION['user_id'],
        $_POST['assigned_officers'] ?? '',
        $_POST['event_venue'],
        $_POST['event_start_date'],
        $_POST['event_end_date']
    );

    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'Event added successfully';
    } else {
        throw new Exception('Failed to add event');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);