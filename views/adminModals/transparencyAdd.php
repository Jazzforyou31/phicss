<?php
require_once '../../classes/databaseClass.php'; // Include your database connection class
require_once '../../classes/transparencyClass.php'; // Include your TransparencyClass

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $sectionTitle = $_POST['section_title'] ?? null;
    $createdBy = $_POST['created_by'] ?? null; // Typically fetched from session or input

    if (empty($sectionTitle) || empty($createdBy)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Instantiate TransparencyClass
    $transparency = new TransparencyClass();

    try {
        $query = "INSERT INTO transparency_section (section_title, created_by) VALUES (:section_title, :created_by)";
        $statement = $transparency->getConnection()->prepare($query);
        $statement->bindParam(':section_title', $sectionTitle, PDO::PARAM_STR);
        $statement->bindParam(':created_by', $createdBy, PDO::PARAM_INT);

        // Execute the query
        if ($statement->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Transparency section added successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add transparency section.']);
        }
    } catch (PDOException $exception) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $exception->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}