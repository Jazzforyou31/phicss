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
    
    // Get event data to delete associated image
    $eventData = $event->getEventById($eventId);
    
    // Delete event
    $success = $event->deleteEvent($eventId);
    
    if ($success) {
        // Delete image file if it exists
        if (!empty($eventData['image']) && $eventData['image'] !== 'default.png') {
            $imagePath = "../../assets/images/" . $eventData['image'];
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }
        echo json_encode(['status' => 'success', 'message' => 'Event deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete event']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}