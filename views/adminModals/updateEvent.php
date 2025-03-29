<?php
require_once '../../classes/eventClass.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event = new EventClass();
    $eventId = (int)$_POST['event_id'];
    
    // Get current event data
    $currentEvent = $event->getEventById($eventId);
    if (!$currentEvent) {
        echo json_encode(['status' => 'error', 'message' => 'Event not found']);
        exit;
    }
    
    // Process image
    $image = $_POST['current_image'];
    $keepCurrentImage = isset($_POST['keep_current_image']) && $_POST['keep_current_image'] == '1';
    
    if (!$keepCurrentImage && !empty($_FILES['image']['name'])) {
        // Upload new image
        $targetDir = "../../assets/images/";
        $fileName = 'event_' . time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Delete old image if it exists and isn't default
            if (!empty($currentEvent['image']) && $currentEvent['image'] !== 'default.png') {
                @unlink($targetDir . $currentEvent['image']);
            }
            $image = $fileName;
        }
    } elseif (!$keepCurrentImage) {
        $image = null; // Remove image if unchecked and no new image provided
    }
    
    // Update event
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