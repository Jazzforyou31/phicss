<?php
require_once '../../classes/accountClass.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input values from POST request
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $middleName = isset($_POST['middle_name']) ? trim($_POST['middle_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';

    // Validate required fields
    if (empty($userId) || empty($username) || empty($firstName) || 
        empty($lastName) || empty($email) || empty($role)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please provide a valid email address.']);
        exit;
    }

    try {
        // Create an instance of AccountClass
        $account = new Account();

        // Update user information
        $result = $account->updateUser($userId, $username, $firstName, $middleName, $lastName, $email, $role);

        // Return a JSON response based on the result
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'User updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update user. The username or email may already be in use.']);
        }
    } catch (Exception $e) {
        // Return error message
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    // Handle invalid access (if not POST request)
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
} 