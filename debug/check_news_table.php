<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/databaseClass.php';
require_once 'classes/newsClass.php';

// Check database connection
$database = new Database();
$connection = $database->connect();
echo "Database connection successful.<br><br>";

// Check if news table exists
$statement = $connection->query("SHOW TABLES LIKE 'news'");
$tableExists = $statement->rowCount() > 0;
echo "News table exists: " . ($tableExists ? "Yes" : "No") . "<br><br>";

if ($tableExists) {
    // Check table structure
    $statement = $connection->query("DESCRIBE news");
    $columns = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo "News table structure:<br>";
    echo "<pre>" . print_r($columns, true) . "</pre><br>";
    
    // Count records
    $statement = $connection->query("SELECT COUNT(*) as count FROM news");
    $count = $statement->fetch(PDO::FETCH_ASSOC)['count'];
    echo "Number of news records: " . $count . "<br><br>";
    
    // Check for news records with admin created_by
    $newsClass = new NewsClass();
    $newsList = $newsClass->fetchNewsByAdmin();
    echo "Number of news records created by admin: " . count($newsList) . "<br><br>";
    
    // Show a few records for debugging
    if ($count > 0) {
        $statement = $connection->query("SELECT * FROM news LIMIT 5");
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "Sample news records:<br>";
        echo "<pre>" . print_r($records, true) . "</pre><br>";
    }
    
    // Check the account table for admin users
    $statement = $connection->query("SELECT COUNT(*) as count FROM account WHERE role = 'admin'");
    $adminCount = $statement->fetch(PDO::FETCH_ASSOC)['count'];
    echo "Number of admin users: " . $adminCount . "<br><br>";
    
    if ($adminCount > 0) {
        $statement = $connection->query("SELECT user_id, username, role FROM account WHERE role = 'admin' LIMIT 5");
        $admins = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "Admin users:<br>";
        echo "<pre>" . print_r($admins, true) . "</pre><br>";
    }
}
?> 