<?php
require_once 'databaseClass.php';

class CollectionClass {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    /**
     * Fetch all collection records with school year details
     */
    public function fetchAllCollections($schoolYearId = null) {
        try {
            $query = "
                SELECT 
                    SUM(c.membership_fee) AS total_membership_fee,
                    SUM(c.loyalty_fee) AS total_loyalty_fee,
                    SUM(c.tech_fair_fee) AS total_tech_fair_fee,
                    SUM(c.project_fee) AS total_project_fee,
                    SUM(c.faculty_student_assembly) AS total_faculty_student_assembly,
                    SUM(c.total) AS grand_total,
                    sy.school_year 
                FROM 
                    collection c 
                JOIN 
                    school_year sy ON c.payment_school_year_id = sy.school_year_id
            ";
    
            // Add a WHERE clause if a specific school year is selected
            if (!empty($schoolYearId)) {
                $query .= " WHERE sy.school_year_id = :schoolYearId";
            }
    
            $query .= " GROUP BY sy.school_year";
    
            $statement = $this->connection->prepare($query);
    
            // Bind the school year ID if provided
            if (!empty($schoolYearId)) {
                $statement->bindParam(':schoolYearId', $schoolYearId, PDO::PARAM_INT);
            }
    
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Error fetching collections: " . $exception->getMessage());
            return [];
        }
    }

    /**
     * Add a new collection record
     */
    public function addCollection($membership, $loyalty, $techFair, $project, $assembly, $schoolYearId) {
        try {
            $query = "
                INSERT INTO collection (
                    membership_fee, 
                    loyalty_fee, 
                    tech_fair_fee, 
                    project_fee, 
                    faculty_student_assembly, 
                    payment_school_year_id
                ) VALUES (
                    :membership, 
                    :loyalty, 
                    :tech_fair, 
                    :project, 
                    :assembly, 
                    :school_year_id
                )
            ";

            $statement = $this->connection->prepare($query);
            $statement->bindParam(':membership', $membership);
            $statement->bindParam(':loyalty', $loyalty);
            $statement->bindParam(':tech_fair', $techFair);
            $statement->bindParam(':project', $project);
            $statement->bindParam(':assembly', $assembly);
            $statement->bindParam(':school_year_id', $schoolYearId);

            return $statement->execute();
        } catch (PDOException $exception) {
            error_log("Error adding collection: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * Fetch all school years
     */
    public function fetchSchoolYears() {
        try {
            $query = "SELECT * FROM school_year ORDER BY school_year DESC";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Error fetching school years: " . $exception->getMessage());
            return [];
        }
    }
}
?>
