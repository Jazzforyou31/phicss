<?php
require_once 'databaseClass.php';

class TransparencyClass {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addSection($title, $createdBy) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO transparency_section (section_title, created_by) VALUES (:title, :created_by)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':created_by', $createdBy, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('addSection ERROR: ' . $e->getMessage());
            return false;
        }
    }

    public function addLink($sectionId, $title, $link, $createdBy) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO transparency_link (section_id, document_title, document_link, created_by)
                                          VALUES (:section_id, :title, :link, :created_by)");
            $stmt->bindParam(':section_id', $sectionId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':link', $link);
            $stmt->bindParam(':created_by', $createdBy, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('addLink ERROR: ' . $e->getMessage());
            return false;
        }
    }



    public function fetchSections() {
        try {
            $query = "SELECT * FROM transparency_section ORDER BY created_at DESC";
            $statement = $this->conn->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching sections: " . $exception->getMessage();
            return [];
        }
    }


  
    public function fetchAllSectionsWithLinks() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM transparency_section ORDER BY created_at DESC");
            $stmt->execute();
            $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($sections as &$section) {
                $section['links'] = $this->fetchLinksBySection($section['id']);
            }
            return $sections;
        } catch (PDOException $e) {
            error_log('getAllSectionsWithLinks ERROR: ' . $e->getMessage());
            return [];
        }
    }

    public function fetchLinksBySection($sectionId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM transparency_link WHERE section_id = :section_id ORDER BY created_at DESC");
            $stmt->bindParam(':section_id', $sectionId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getLinksBySection ERROR: ' . $e->getMessage());
            return [];
        }
    }

    
//viewTransparency.php
    public function fetchSectionById($sectionId) {
        $stmt = $this->conn->prepare("
            SELECT ts.*, 
                   (SELECT CONCAT(a1.first_name, ' ', a1.last_name) FROM account a1 WHERE a1.user_id = ts.created_by) AS created_by_name,
                   (SELECT CONCAT(a2.first_name, ' ', a2.last_name) FROM account a2 WHERE a2.user_id = ts.updated_by) AS updated_by_name
            FROM transparency_section ts
            WHERE ts.id = ?
        ");
        $stmt->execute([$sectionId]);
        $section = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($section) {
            $linkStmt = $this->conn->prepare("SELECT * FROM transparency_link WHERE section_id = ?");
            $linkStmt->execute([$sectionId]);
            $section['links'] = $linkStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $section;
    }

    public function fetchSectionsBySchoolYear($schoolYearId)
{
    // Ensure your database query fetches the correct sections based on the school year
    $sql = "SELECT ts.*, tl.document_title, tl.document_link 
            FROM transparency_section ts
            LEFT JOIN transparency_link tl ON ts.id = tl.section_id
            WHERE ts.school_year_id = :schoolYearId";  // Assuming the transparency_section table has a `school_year_id` field
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':schoolYearId', $schoolYearId, PDO::PARAM_INT);
    $stmt->execute();

    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // You might want to format the sections or links in the desired format
    return $sections;
}


    

   
    
    
    
}
