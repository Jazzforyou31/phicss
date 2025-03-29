<?php
// Include necessary files for database connection and security
require '../../classes/newsClass.php'; // Your class to interact with the database

// Instantiate the NewsClass
$newsClass = new NewsClass();

// Check if news_id is passed via GET request
if (isset($_GET['news_id'])) {
    $newsId = $_GET['news_id'];

    // Fetch the news data from the database
    $newsData = $newsClass->getNewsById($newsId);

    if ($newsData) {
        echo json_encode([
            'status' => 'success',
            'news_id' => $newsData['news_id'],
            'news_title' => $newsData['news_title'],
            'news_description' => $newsData['news_description'],
            'message' => $newsData['message'],
            'news_date' => $newsData['news_date'],
            'author' => $newsData['author']
        ]);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'News ID not provided']);
}
?>
