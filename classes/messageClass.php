<?php
require_once 'databaseClass.php'; // Ensure this file connects to your database

class MessageClass {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    /**
     * Add a new message
     */
    public function addMessage($fullName, $emailAddress, $phoneNumber, $messageContent, $dateSent) {
        try {
            $query = "INSERT INTO message (full_name, email_address, phone_number, message, date_sent)
                      VALUES (:full_name, :email_address, :phone_number, :message, :date_sent)";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':full_name', $fullName);
            $statement->bindParam(':email_address', $emailAddress);
            $statement->bindParam(':phone_number', $phoneNumber);
            $statement->bindParam(':message', $messageContent);
            $statement->bindParam(':date_sent', $dateSent);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error adding message: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Fetch all messages
     */
    public function fetchAllMessages() {
        try {
            $query = "SELECT * FROM message ORDER BY message_id DESC";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching messages: " . $exception->getMessage();
            return [];
        }
    }

    public function fetch($user_id) {
    try {
        $query = "SELECT username FROM account WHERE user_id = :user_id"; // Assuming 'account' table and 'user_id' column
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC); // Returns an associative array with 'username'
    } catch (PDOException $exception) {
        echo "Error fetching user data: " . $exception->getMessage();
        return false;
    }
}

    /**
     * Update the status of a message and the admin who processed it
     */
    public function updateStatus($message_id, $status, $adminUserId) {
        try {
            $processed_by = ($status === 'Resolved') ? $adminUserId : null;
            $date_resolved = ($status === 'Resolved') ? date('Y-m-d') : null;
    
            $query = "
                UPDATE message 
                SET status = :status, 
                    processed_by = :processed_by, 
                    date_resolved = :date_resolved
                WHERE message_id = :message_id
            ";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':status', $status);
            $statement->bindParam(':processed_by', $processed_by, PDO::PARAM_INT);
            $statement->bindParam(':date_resolved', $date_resolved);
            $statement->bindParam(':message_id', $message_id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error updating message status: " . $exception->getMessage();
            return false;
        }
    }
    

    
}