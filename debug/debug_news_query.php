<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/databaseClass.php';

// Connect to database
$database = new Database();
$connection = $database->connect();

// The query from NewsClass->fetchNewsByAdmin()
$query = "
    SELECT 
        n.news_id, 
        n.news_title, 
        n.news_description, 
        n.message, 
        n.image, 
        n.news_date, 
        n.created_at, 
        n.author 
    FROM 
        news n
    INNER JOIN 
        account a 
    ON 
        n.created_by = a.user_id 
    WHERE 
        a.role = 'admin'
    ORDER BY 
        n.created_at DESC
";

try {
    // Execute the query directly with debug info
    echo "Attempting to run the query:<br>";
    echo "<pre>" . $query . "</pre><br>";
    
    $statement = $connection->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Query executed successfully.<br>";
    echo "Number of results: " . count($results) . "<br><br>";
    
    if (count($results) > 0) {
        echo "Results:<br>";
        echo "<pre>" . print_r($results, true) . "</pre>";
    } else {
        echo "No results found.<br><br>";
        
        // Check if there are any news records at all
        $statement = $connection->query("SELECT COUNT(*) as count FROM news");
        $total = $statement->fetch(PDO::FETCH_ASSOC)['count'];
        echo "Total news records: " . $total . "<br>";
        
        // Check if any of those news records have a created_by that exists in account
        $statement = $connection->query("
            SELECT COUNT(*) as count 
            FROM news n 
            INNER JOIN account a ON n.created_by = a.user_id
        ");
        $joined = $statement->fetch(PDO::FETCH_ASSOC)['count'];
        echo "News records that join with account: " . $joined . "<br>";
        
        // Check if any admin accounts exist
        $statement = $connection->query("SELECT COUNT(*) as count FROM account WHERE role = 'admin'");
        $admins = $statement->fetch(PDO::FETCH_ASSOC)['count'];
        echo "Admin accounts: " . $admins . "<br>";
        
        // Check if any news records have created_by that matches admin user_id
        $statement = $connection->query("
            SELECT COUNT(*) as count 
            FROM news n 
            INNER JOIN account a ON n.created_by = a.user_id
            WHERE a.role = 'admin'
        ");
        $adminNews = $statement->fetch(PDO::FETCH_ASSOC)['count'];
        echo "News records created by admin: " . $adminNews . "<br><br>";
        
        // List all news records with their created_by and corresponding account info
        echo "News records with creator info:<br>";
        $statement = $connection->query("
            SELECT 
                n.news_id, 
                n.news_title, 
                n.created_by,
                a.user_id,
                a.username,
                a.role
            FROM 
                news n
            LEFT JOIN 
                account a ON n.created_by = a.user_id
            ORDER BY 
                n.news_id
            LIMIT 10
        ");
        $newsWithCreators = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>" . print_r($newsWithCreators, true) . "</pre>";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?> 