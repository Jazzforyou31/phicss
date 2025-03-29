<?php
require_once 'databaseClass.php'; // Ensure database connection

class AboutClass {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Fetch About PHICSS details (Assuming there's only one entry)
    public function fetchAboutInfo() {
        $query = "SELECT a.*, 
                         c.username AS created_by_name, 
                         u.username AS updated_by_name
                  FROM about_phicss a
                  LEFT JOIN account c ON a.created_by = c.user_id
                  LEFT JOIN account u ON a.updated_by = u.user_id
                  WHERE a.info_id = 1"; // Assuming only one record exists

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update About PHICSS details
    public function updateAbout($mission, $vision, $description, $updated_by) {
        $query = "UPDATE about_phicss 
                  SET mission = :mission, 
                      vision = :vision, 
                      description = :description, 
                      updated_at = NOW(), 
                      updated_by = :updated_by
                  WHERE info_id = 1"; // Assuming only one record exists

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mission', $mission);
        $stmt->bindParam(':vision', $vision);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':updated_by', $updated_by);

        return $stmt->execute();
    }
}
?>
