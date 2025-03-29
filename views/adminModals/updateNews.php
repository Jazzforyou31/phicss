<?php
// Include necessary files for database connection and security
require '../../classes/newsClass.php'; // Your class to interact with the database

// Instantiate the NewsClass
$newsClass = new NewsClass();

// Check if form data is provided via POST
if (isset($_POST['news_id'], $_POST['news_title'], $_POST['news_description'], $_POST['message'], $_POST['news_date'], $_POST['author'])) {
    $newsId = $_POST['news_id'];
    $newsTitle = $_POST['news_title'];
    $newsDescription = $_POST['news_description'];
    $message = $_POST['message'];
    $newsDate = $_POST['news_date'];
    $author = $_POST['author'];

    // Call the update method to update the news in the database
    $result = $newsClass->updateNewsById($newsId, $newsTitle, $newsDescription, $message, $newsDate, $author);

    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete form data']);
}
?>
