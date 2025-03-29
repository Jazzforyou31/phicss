<?php
require_once 'databaseClass.php'; // Include your database class

class TransparencyClass {
    private $connection;

    public function __construct() {
        // Connect to the database
        $database = new Database();
        $this->connection = $database->connect();
    }

    /**
     * Fetch all sections from the transparency_section table.
     */
    public function fetchSections() {
        try {
            $query = "SELECT * FROM transparency_section ORDER BY created_at DESC";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching sections: " . $exception->getMessage();
            return [];
        }
    }

    /**
     * Fetch all links for a specific section from the transparency_link table.
     * 
     * @param int $sectionId The ID of the section.
     */
    public function fetchLinksBySection($sectionId) {
        try {
            $query = "
                SELECT l.id, l.document_title, l.document_link, l.created_at, l.updated_at
                FROM transparency_link l
                WHERE l.section_id = :section_id
                ORDER BY l.created_at DESC
            ";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':section_id', $sectionId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching links: " . $exception->getMessage();
            return [];
        }
    }

    /**
     * Fetch a specific section by ID from the transparency_section table.
     * 
     * @param int $sectionId The ID of the section.
     */
    public function fetchSectionById($sectionId) {
        try {
            $query = "SELECT * FROM transparency_section WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $sectionId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching section: " . $exception->getMessage();
            return null;
        }
    }
}