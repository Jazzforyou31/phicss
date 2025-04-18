<?php
session_start();
require '../../classes/newsClass.php';

// Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Set a default admin user ID if no user is logged in
    // Get the first admin from the database
    require_once '../../classes/databaseClass.php';
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->query("SELECT user_id FROM account WHERE role = 'admin' LIMIT 1");
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $userId = ($admin && isset($admin['user_id'])) ? $admin['user_id'] : 1;
} else {
    $userId = $_SESSION['user_id'];
}

$newsClass = new NewsClass();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['news_title'] ?? '';
    $description = $_POST['news_description'] ?? '';
    $messageContent = $_POST['message'] ?? '';
    $category = $_POST['category'] ?? ''; // Default category if none provided
    $newsDate = $_POST['news_date'] ?? date('Y-m-d');
    $author = $_POST['author'] ?? 'Unknown';
    $createdBy = $userId; // Use the user ID we determined above
    
    // Log the createdBy value for debugging
    error_log("Adding news with createdBy: " . $createdBy);
    
    $image = "default.png"; // Default image if none provided
    
    // Check if an image file was uploaded
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        // Create directory if it doesn't exist
        $targetDir = "../../assets/images/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Generate a unique filename to prevent overwrites
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = 'news_' . time() . '_' . uniqid() . '.' . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $image = $newFileName;
        }
    }

     // Calculate the "Latest" tag dynamically
     $isLatest = (strtotime($newsDate) >= strtotime('-7 days')) ? true : false;

    $success = $newsClass->addNews($title, $description, $messageContent, $category, $image, $newsDate, $author, $createdBy, $isLatest);
    
    echo json_encode(["status" => $success ? "success" : "error"]);
    exit;
}
