<?php
require '../../classes/databaseClass.php';
$db = new Database();
$conn = $db->getConnection();

// Initialize the response array
$response = ['success' => false, 'data' => []];

// Get the school year ID from the request (if any)
$schoolYearId = isset($_GET['school_year_id']) ? $_GET['school_year_id'] : null;

try {
    // Prepare the query based on whether a school year is selected
    if (is_null($schoolYearId)) {
        $query = "SELECT ts.id, ts.section_title, sy.school_year
                  FROM transparency_section ts
                  JOIN school_year sy ON ts.school_year_id = sy.school_year_id
                  ORDER BY ts.id DESC";
        $stmt = $conn->prepare($query);
    } else {
        $query = "SELECT ts.id, ts.section_title, sy.school_year
                  FROM transparency_section ts
                  JOIN school_year sy ON ts.school_year_id = sy.school_year_id
                  WHERE ts.school_year_id = ?
                  ORDER BY ts.id DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $schoolYearId);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $sections = [];

    while ($row = $result->fetch_assoc()) {
        $sectionId = $row['id'];

        // Fetch all links associated with this section
        $linkQuery = "SELECT document_title, document_link FROM transparency_link WHERE section_id = ?";
        $linkStmt = $conn->prepare($linkQuery);
        $linkStmt->bind_param("i", $sectionId);
        $linkStmt->execute();
        $linkResult = $linkStmt->get_result();

        $links = [];
        while ($linkRow = $linkResult->fetch_assoc()) {
            $links[] = $linkRow;
        }

        // Attach links to the section data
        $row['links'] = $links;
        $sections[] = $row;

        $linkStmt->close(); // Close inner statement
    }

    $stmt->close();

    $response['success'] = true;
    $response['data'] = $sections;

} catch (Exception $e) {
    $response['success'] = false;
    $response['error'] = 'Error fetching transparency sections: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
