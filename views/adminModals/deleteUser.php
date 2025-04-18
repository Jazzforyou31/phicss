<?php
require_once '../../classes/accountClass.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);
    
    try {
        // Create an instance of AccountClass
        $account = new Account();
        
        // Delete the user
        $result = $account->deleteUser($userId);
        
        // Return a JSON response based on the result
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user.']);
        }
    } catch (Exception $e) {
        // Return error message
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    // Handle invalid access
    echo json_encode(['status' => 'error', 'message' => 'Invalid request or missing user ID.']);
} 