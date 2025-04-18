<?php
require '../../classes/databaseClass.php';

$db = new Database();
$conn = $db->connect(); // ✅ FIXED this line

$response = ['success' => false, 'data' => []];

$query = "SELECT school_year_id, school_year FROM school_year ORDER BY school_year ASC";
$result = $conn->query($query);

if ($result && $result->rowCount() > 0) { // ✅ For PDO use rowCount()
    $schoolYears = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $schoolYears[] = $row;
    }
    $response['success'] = true;
    $response['data'] = $schoolYears;
} else {
    $response['message'] = 'No school years found.';
}

header('Content-Type: application/json');
echo json_encode($response);




exit;
