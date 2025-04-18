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
            $query = "
                SELECT 
                    contact_id, street, campus, building, city, province, country, 
                    start_day, end_day, opening_time, closing_time, primary_number, secondary_number,
                    primary_email, alternative_email
                FROM contacts
                ORDER BY contact_id DESC
            ";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching contacts: " . $exception->getMessage();
            return [];
        }
    }

   

    /**
     * Add a new contact
     */
    public function addContact($street, $campus, $building, $city, $province, $country, $startDay, $endDay, $openingTime, $closingTime) {
        try {
            $query = "
                INSERT INTO contacts (street, campus, building, city, province, country, start_day, end_day, opening_time, closing_time) 
                VALUES (:street, :campus, :building, :city, :province, :country, :start_day, :end_day, :opening_time, :closing_time)
            ";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':street', $street);
            $statement->bindParam(':campus', $campus);
            $statement->bindParam(':building', $building);
            $statement->bindParam(':city', $city);
            $statement->bindParam(':province', $province);
            $statement->bindParam(':country', $country);
            $statement->bindParam(':start_day', $startDay);
            $statement->bindParam(':end_day', $endDay);
            $statement->bindParam(':opening_time', $openingTime);
            $statement->bindParam(':closing_time', $closingTime);
            return $statement->execute();
        } catch (PDOException $exception) {
            echo "Error adding contact: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Update a contact
     */
    public function updateContact($contactId, $street, $campus, $building, $city, $province, $country, $startDay, $endDay, $openingTime, $closingTime) {
        try {
            $query = "
                UPDATE contacts 
                SET 
                    street = :street,
                    campus = :campus,
                    building = :building,
                    city = :city,
                    province = :province,
                    country = :country,
                    start_day = :start_day,
                    end_day = :end_day,
                    opening_time = :opening_time,
                    closing_time = :closing_time
                WHERE contact_id = :contact_id
            ";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':contact_id', $contactId, PDO::PARAM_INT);
            $statement->bindParam(':street', $street);
            $statement->bindParam(':campus', $campus);
            $statement->bindParam(':building', $building);
            $statement->bindParam(':city', $city);
            $statement->bindParam(':province', $province);
            $statement->bindParam(':country', $country);
            $statement->bindParam(':start_day', $startDay);
            $statement->bindParam(':end_day', $endDay);
            $statement->bindParam(':opening_time', $openingTime);
            $statement->bindParam(':closing_time', $closingTime);
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