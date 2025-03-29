<?php
require_once 'databaseClass.php';

class ContactClass {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    /**
     * Fetch all contacts
     */
    public function fetchAllContacts() {
        try {
            $query = "SELECT * FROM contacts ORDER BY contact_id DESC";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching contacts: " . $exception->getMessage();
            return [];
        }
    }

    /**
     * Fetch contact by user ID
     */
    public function fetchContactByUserId($userId) {
        try {
            $query = "SELECT * FROM contacts WHERE user_id = :user_id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching contact: " . $exception->getMessage();
            return null;
        }
    }

    /**
     * Add a new contact
     */
    public function addContact($address, $contactNumber, $email, $schedule, $userId) {
        try {
            $query = "INSERT INTO contacts (address, contact_number, email, schedule, user_id) VALUES (:address, :contact_number, :email, :schedule, :user_id)";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':address', $address);
            $statement->bindParam(':contact_number', $contactNumber);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':schedule', $schedule);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error adding contact: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Update a contact
     */
    public function updateContact($contactId, $address, $contactNumber, $email, $schedule) {
        try {
            $query = "UPDATE contacts SET address = :address, contact_number = :contact_number, email = :email, schedule = :schedule WHERE contact_id = :contact_id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':contact_id', $contactId, PDO::PARAM_INT);
            $statement->bindParam(':address', $address);
            $statement->bindParam(':contact_number', $contactNumber);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':schedule', $schedule);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error updating contact: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Delete a contact
     */
    public function deleteContact($contactId) {
        try {
            $query = "DELETE FROM contacts WHERE contact_id = :contact_id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':contact_id', $contactId, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error deleting contact: " . $exception->getMessage();
            return false;
        }
    }
}
