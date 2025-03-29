<?php
require_once '../../classes/accountClass.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);
    
    // Create an instance of AccountClass
    $account = new AccountClass();
    
    // Get user data
    $userData = $account->getUserById($userId);
    
    if ($userData) {
        // Return user data as JSON
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'user' => $userData]);
    } else {
        // User not found or error
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else {
    // Invalid request
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
} 