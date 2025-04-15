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

        // Add a new announcement
        public function addAnnouncement($title, $message, $createdBy) {
            try {
                $query = "
                    INSERT INTO announcements (announcement_title, message, created_by, created_at)
                    VALUES (:title, :message, :createdBy, NOW())
                ";

                $statement = $this->connection->prepare($query);
                $statement->bindParam(':title', $title);
                $statement->bindParam(':message', $message);
                $statement->bindParam(':createdBy', $createdBy);
                $statement->execute();

                return $this->connection->lastInsertId(); // Return the ID of the newly inserted announcement
            } catch (PDOException $exception) {
                echo "Error adding announcement: " . $exception->getMessage();
                return false;
            }
        }

        // Edit an existing announcement
        public function editAnnouncement($id, $title, $message, $updatedBy) {
            try {
                $query = "
                    UPDATE announcements
                    SET announcement_title = :title, message = :message, updated_by = :updatedBy, updated_at = NOW()
                    WHERE announcement_id = :id
                ";

                $statement = $this->connection->prepare($query);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->bindParam(':title', $title);
                $statement->bindParam(':message', $message);
                $statement->bindParam(':updatedBy', $updatedBy);
                $statement->execute();

                return $statement->rowCount(); // Return the number of affected rows
            } catch (PDOException $exception) {
                echo "Error editing announcement: " . $exception->getMessage();
                return false;
            }
        }

        // Delete an announcement
        public function deleteAnnouncement($id) {
            try {
                $query = "
                    DELETE FROM announcements WHERE announcement_id = :id
                ";

                $statement = $this->connection->prepare($query);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->execute();

                return $statement->rowCount(); // Return the number of affected rows
            } catch (PDOException $exception) {
                echo "Error deleting announcement: " . $exception->getMessage();
                return false;
            }
        }
    }

 
    
}
?>
