<?php
session_start();
require '../../classes/newsClass.php';

// Debugging
error_log("editNews.php accessed via " . $_SERVER['REQUEST_METHOD']);

$newsClass = new NewsClass();

// Handle AJAX request to fetch news details
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['news_id'])) {
    $newsId = intval($_GET['news_id']);
    error_log("GET request for news ID: " . $newsId);
    $newsItem = $newsClass->getNewsById($newsId);
    
    if ($newsItem) {
        echo json_encode([
            'status' => 'success',
            'data' => $newsItem
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'News article not found'
        ]);
    }
    exit;
}

// Handle form submission for updating news
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news_id'])) {
    error_log("POST request received with news_id: " . $_POST['news_id']);
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));
    
    $newsId = intval($_POST['news_id']);
    $title = $_POST['news_title'] ?? '';
    $description = $_POST['news_description'] ?? '';
    $messageContent = $_POST['message'] ?? '';
    $category = $_POST['category'] ?? '';
    $newsDate = $_POST['news_date'] ?? date('Y-m-d');
    $author = $_POST['author'] ?? '';
    $keepCurrentImage = isset($_POST['keep_current_image']) && $_POST['keep_current_image'] == '1';
    $currentImage = $_POST['current_image'] ?? '';
    
    // Initialize image variable
    $image = $keepCurrentImage ? $currentImage : '';
    
    // Process new image upload if not keeping current image
    if (!$keepCurrentImage && !empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        // Create directory if it doesn't exist
        $targetDir = "../../assets/images/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Generate a unique filename to prevent overwrites
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = 'news_' . time() . '_' . uniqid() . '.' . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;
        
        error_log("Attempting to upload file to: " . $targetFilePath);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $image = $newFileName;
            error_log("File upload successful: " . $image);
        } else {
            error_log("File upload failed: " . error_get_last()['message'] ?? 'Unknown error');
        }
    }
    
    // Update the news article
    $success = $newsClass->updateNewsById($newsId, $title, $description, $messageContent, $category, $image, $newsDate, $author);
    error_log("Update result: " . ($success ? 'success' : 'failure'));
    
    echo json_encode([
        'status' => $success ? 'success' : 'error',
        'message' => $success ? 'News article updated successfully' : 'Failed to update news article'
    ]);
    exit;
}

// If we got here, it's an invalid request
error_log("Invalid request to editNews.php");
echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request'
]);
exit; 