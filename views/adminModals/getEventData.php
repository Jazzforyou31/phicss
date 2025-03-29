<?php
require_once '../../classes/eventClass.php';
header('Content-Type: application/json');

if (isset($_GET['event_id'])) {
    $eventId = (int)$_GET['event_id'];
    $event = new EventClass();
    $eventData = $event->getEventById($eventId);
    
    if ($eventData) {
        echo json_encode([
            'status' => 'success',
            'data' => [
                'event_id' => $eventData['event_id'],
                'event_name' => $eventData['event_name'],
                'event_category' => $eventData['event_category'],
                'event_audience' => $eventData['event_audience'],
                'image' => $eventData['image'],
                'event_description' => $eventData['event_description'],
                'assigned_officers' => $eventData['assigned_officers'],
                'event_venue' => $eventData['event_venue'],
                'event_start_date' => $eventData['event_start_date'],
                'event_end_date' => $eventData['event_end_date']
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Event not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Event ID not provided']);
}