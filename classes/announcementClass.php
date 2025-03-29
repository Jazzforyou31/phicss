<?php
require_once 'databaseClass.php';

if (!class_exists('AnnouncementClass')) {
    class AnnouncementClass {
        private $connection;

        public function __construct() {
            $database = new Database();
            $this->connection = $database->connect();
        }

        // Fetch all announcements, ordered by creation date (latest first)
        public function fetchAnnouncements() {
            try {
                $query = "
                    SELECT 
                        announcement_id, 
                        announcement_title, 
                        message, 
                        announcement_date, 
                        created_by, 
                        created_at, 
                        updated_at, 
                        updated_by 
                    FROM 
                        announcements
                    ORDER BY 
                        created_at DESC
                ";

                $statement = $this->connection->prepare($query);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                echo "Error fetching announcements: " . $exception->getMessage();
                return [];
            }
        }
    }
}
?>
