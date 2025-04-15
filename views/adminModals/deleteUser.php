<?php
require_once '../../classes/accountClass.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a log of the received POST data
$logData = "DELETE POST data received: " . print_r($_POST, true);
file_put_contents(__DIR__ . '/deleteuser_debug.log', $logData, FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);
    
    // Log the user ID
    file_put_contents(__DIR__ . '/deleteuser_debug.log', "\nDelete user ID: $userId", FILE_APPEND);
    
    try {
        // Create an instance of AccountClass
        $account = new Account();
        
        // Delete the user
        $result = $account->deleteUser($userId);
        
        // Log the result
        file_put_contents(__DIR__ . '/deleteuser_debug.log', "\nDelete result: " . ($result ? "success" : "failure"), FILE_APPEND);
        
        // Return a JSON response based on the result
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user.']);
        }
    } catch (Exception $e) {
        // Log the exception
        file_put_contents(__DIR__ . '/deleteuser_debug.log', "\nException: " . $e->getMessage(), FILE_APPEND);
        
        // Return error message
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    // Handle invalid access
    echo json_encode(['status' => 'error', 'message' => 'Invalid request or missing user ID.']);
} 