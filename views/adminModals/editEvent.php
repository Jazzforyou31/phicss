<?php
require_once '../../classes/eventClass.php';
header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
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
    $image = $currentEvent['image']; // Keep current by default
    $keepCurrentImage = isset($_POST['keep_current_image']) && $_POST['keep_current_image'] == '1';
    
    if (!$keepCurrentImage) {
        if (!empty($_FILES['image']['name'])) {
            // Handle new image upload
            $targetDir = "../../../assets/images/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $fileName = 'event_' . time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Delete old image if exists
                if (!empty($currentEvent['image']) && $currentEvent['image'] !== 'default.png') {
                    @unlink($targetDir . $currentEvent['image']);
                }
                $image = $fileName;
            }
        } else {
            // Remove image if unchecked
            if (!empty($currentEvent['image']) && $currentEvent['image'] !== 'default.png') {
                @unlink("../../../assets/images/" . $currentEvent['image']);
            }
            $image = null;
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