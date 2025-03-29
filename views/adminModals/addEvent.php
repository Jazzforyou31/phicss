<?php
require_once '../../classes/eventClass.php';
header('Content-Type: application/json');

// Start session to access user_id
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event = new EventClass();
    
    // Required fields
    $required = ['event_name', 'event_category', 'event_audience', 'event_venue', 
                'event_start_date', 'event_end_date', 'event_description'];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['status' => 'error', 'message' => "$field is required"]);
            exit;
        }
    }
    
    // Process file upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../../../assets/images/";  // Adjusted path (3 levels up)
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);  // Create directory if it doesn't exist
        }
        
        $fileName = 'event_' . time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        
        // Validate image file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image = $fileName;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image type']);
            exit;
        }
    }
    
    // Add event
    $result = $event->addEvent(
        $_POST['event_name'],
        $_POST['event_category'],
        $_POST['event_audience'],
        $image,
        $_POST['event_description'],
        $_SESSION['user_id'] ?? 1, // created_by
        $_POST['assigned_officers'] ?? null,
        $_POST['event_venue'],
        $_POST['event_start_date'],
        $_POST['event_end_date']
    );
    
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Event added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add event']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}