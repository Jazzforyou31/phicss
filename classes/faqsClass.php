<?php
require_once 'databaseClass.php';

class FaqsClass {
    private $connection;

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
            
            // Debugging
            if (!is_array($result)) {
                die("Error: fetchFAQs() did not return an array. Returned: " . print_r($result, true));
            }
            
            return $result;
        } catch (PDOException $exception) {
            die("Error fetching FAQs: " . $exception->getMessage());
        }
    }
    
    public function fetchCategories() {
        try {
            $query = "SELECT DISTINCT category FROM faqs";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            // Debugging
            if (!is_array($result)) {
                die("Error: fetchCategories() did not return an array. Returned: " . print_r($result, true));
            }
    
            return $result;
        } catch (PDOException $exception) {
            die("Error fetching categories: " . $exception->getMessage());
        }
    }
    

    /**
     * Add a new FAQ
     */
    public function addFaq($question, $answer, $category, $createdBy) {
        try {
            $query = "INSERT INTO faqs (question, answer, category, created_at, created_by) VALUES (:question, :answer, :category, NOW(), :created_by)";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':question', $question);
            $statement->bindParam(':answer', $answer);
            $statement->bindParam(':category', $category);
            $statement->bindParam(':created_by', $createdBy);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error adding FAQ: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Update an existing FAQ
     */
    public function updateFaq($faqId, $question, $answer, $category, $updatedBy) {
        try {
            $query = "UPDATE faqs SET question = :question, answer = :answer, category = :category, updated_at = NOW(), updated_by = :updated_by WHERE faq_id = :faq_id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':faq_id', $faqId, PDO::PARAM_INT);
            $statement->bindParam(':question', $question);
            $statement->bindParam(':answer', $answer);
            $statement->bindParam(':category', $category);
            $statement->bindParam(':updated_by', $updatedBy);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error updating FAQ: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Delete an FAQ
     */
    public function deleteFaq($faqId) {
        try {
            $query = "DELETE FROM faqs WHERE faq_id = :faq_id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':faq_id', $faqId, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error deleting FAQ: " . $exception->getMessage();
            return false;
        }
    }
}