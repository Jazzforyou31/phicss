<?php
class VolunteerClass {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct() {
        require_once 'DatabaseClass.php';
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Fetch all volunteers
    public function fetchAllVolunteers() {
        try {
            $sql = "SELECT * FROM volunteers"; // Removed ORDER BY created_at
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR MESSAGE: " . $e->getMessage();
            return [];
        }
    }

    // Fetch specific volunteer details by ID
    public function fetchVolunteer($id) {
        try {
            $sql = "SELECT * FROM volunteers WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR MESSAGE: " . $e->getMessage();
            return null;
        }
    }

    // Update volunteer status
    public function updateStatus($volunteer_id, $status, $approved_by = null) {
        try {
            $sql = "UPDATE volunteers SET status = :status, approved_by = :approved_by WHERE id = :volunteer_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':approved_by', $approved_by);
            $stmt->bindParam(':volunteer_id', $volunteer_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "ERROR MESSAGE: " . $e->getMessage();
            return false;
        }
    }

    

    // Delete a volunteer
    public function deleteVolunteer($id) {
        try {
            $sql = "DELETE FROM volunteers WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "ERROR MESSAGE: " . $e->getMessage();
            return false;
        }
    }

    // Fetch approver details by ID (from account table)
    public function fetchApprover($id) {
        try {
            $sql = "SELECT username FROM account WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR MESSAGE: " . $e->getMessage();
            return null;
        }
    }
}
?>