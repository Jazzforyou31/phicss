<?php
require_once 'databaseClass.php';

class FaqsClass {
    public $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    /**
     * Fetch all FAQs
     */
    public function fetchFAQs() {
        try {
            $query = "SELECT * FROM faqs ORDER BY created_at DESC";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!is_array($result)) {
                die("Error: fetchFAQs() did not return an array. Returned: " . print_r($result, true));
            }

            return $result;
        } catch (PDOException $exception) {
            die("Error fetching FAQs: " . $exception->getMessage());
        }
    }

    /**
     * Add a new FAQ
     */
    public function addFAQ($question, $answer, $created_by) {
        try {
            $query = "INSERT INTO faqs (question, answer, created_at, created_by) VALUES (?, ?, NOW(), ?)";
            $statement = $this->connection->prepare($query);
            return $statement->execute([$question, $answer, $created_by]);
        } catch (PDOException $e) {
            die("Error adding FAQ: " . $e->getMessage());
        }
    }

    /**
     * Edit an existing FAQ
     */
    public function editFAQ($faq_id, $question, $answer, $updated_by) {
        try {
            $query = "UPDATE faqs SET question = ?, answer = ?, updated_at = NOW(), updated_by = ? WHERE faq_id = ?";
            $statement = $this->connection->prepare($query);
            return $statement->execute([$question, $answer, $updated_by, $faq_id]);
        } catch (PDOException $e) {
            die("Error editing FAQ: " . $e->getMessage());
        }
    }

    /**
     * Delete a FAQ
     */
    public function deleteFAQ($faq_id) {
        try {
            $query = "DELETE FROM faqs WHERE faq_id = ?";
            $statement = $this->connection->prepare($query);
            return $statement->execute([$faq_id]);
        } catch (PDOException $e) {
            die("Error deleting FAQ: " . $e->getMessage());
        }
    }
}
