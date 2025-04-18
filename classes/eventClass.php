<?php
require_once 'databaseClass.php';

class EventClass {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function fetchEventsByAdmin() {
        try {
            $query = "SELECT * FROM events ORDER BY event_start_date DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching events: " . $e->getMessage());
            return [];
        }
    }

    public function fetchEventDates() {
        try {
            $query = "SELECT event_id, event_name, event_venue, event_description, event_start_date, event_end_date FROM events";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Format events for calendar display
            $calendarEvents = [];
            foreach ($events as $event) {
                $calendarEvents[] = [
                    'id' => $event['event_id'],
                    'title' => $event['event_name'],
                    'start' => $event['event_start_date'],
                    'end' => $event['event_end_date'],
                    'description' => $event['event_description'],
                    'location' => $event['event_venue']
                ];
            }
            
            return $calendarEvents;
        } catch (PDOException $e) {
            error_log("Error fetching event dates: " . $e->getMessage());
            return [];
        }
    }

    public function getEventById($eventId) {
        try {
            $query = "SELECT * FROM events WHERE event_id = :event_id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting event: " . $e->getMessage());
            return false;
        }
    }

    public function addEvent($name, $category, $audience, $image, $description, $createdBy, $officers, $venue, $startDate, $endDate) {
        try {
            $query = "INSERT INTO events (
                event_name, event_category, event_audience, image, event_description, 
                created_by, assigned_officers, event_venue, event_start_date, event_end_date
            ) VALUES (
                :name, :category, :audience, :image, :description, 
                :created_by, :officers, :venue, :start_date, :end_date
            )";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':audience', $audience);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':created_by', $createdBy, PDO::PARAM_INT);
            $stmt->bindParam(':officers', $officers);
            $stmt->bindParam(':venue', $venue);
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error adding event: " . $e->getMessage());
            return false;
        }
    }

    public function updateEvent($eventId, $name, $category, $audience, $image, $description, $officers, $venue, $startDate, $endDate) {
        try {
            $this->db->beginTransaction();
            
            $query = "UPDATE events SET
                event_name = :name,
                event_category = :category,
                event_audience = :audience,
                image = :image,
                event_description = :description,
                assigned_officers = :officers,
                event_venue = :venue,
                event_start_date = :start_date,
                event_end_date = :end_date
                WHERE event_id = :event_id";
            
            $stmt = $this->db->prepare($query);
            $params = [
                ':name' => $name,
                ':category' => $category,
                ':audience' => $audience,
                ':image' => $image ?: 'default.png',
                ':description' => $description,
                ':officers' => $officers,
                ':venue' => $venue,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':event_id' => $eventId
            ];
            
            $success = $stmt->execute($params);
            $this->db->commit();
            
            return $success;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Event Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteEvent($eventId) {
        try {
            $query = "DELETE FROM events WHERE event_id = :event_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting event: " . $e->getMessage());
            return false;
        }
    }

    // public function getUpcomingEventsCount() {
    //     $query = "SELECT COUNT(*) AS upcoming_events FROM events WHERE _date >= CURDATE()";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->execute();
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $result['upcoming_events'];
    // }
}