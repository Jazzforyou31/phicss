<?php
session_start();
require '../../classes/newsClass.php';

$newsClass = new NewsClass();

// Check if this is a POST request with a news_id
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news_id'])) {
    $newsId = intval($_POST['news_id']);
    
    // Get the news item to check if it exists
    $newsItem = $newsClass->getNewsById($newsId);
    
    if (!$newsItem) {
        echo json_encode([
            'status' => 'error',
            'message' => 'News article not found'
        ]);
        exit;
    }
    
    // Delete the news article
    $success = $newsClass->deleteNewsById($newsId);
    
    // Delete associated image if it exists and isn't the default
    if ($success && !empty($newsItem['image']) && $newsItem['image'] !== 'default.png') {
        $imagePath = '../../assets/images/' . $newsItem['image'];
        if (file_exists($imagePath)) {
            @unlink($imagePath); // Try to delete the file, but don't trigger an error if it fails
        }
    }
    
    echo json_encode([
        'status' => $success ? 'success' : 'error',
        'message' => $success ? 'News article deleted successfully' : 'Failed to delete news article'
    ]);
    exit;
}

// If we got here, it's an invalid request
echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request'
]);
exit;