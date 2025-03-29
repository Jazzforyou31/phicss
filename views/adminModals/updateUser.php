<?php
require_once '../../classes/accountClass.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a log of the received POST data
$logData = "UPDATE POST data received: " . print_r($_POST, true);
file_put_contents(__DIR__ . '/updateuser_debug.log', $logData, FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input values from POST request
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $middleName = isset($_POST['middle_name']) ? trim($_POST['middle_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';

    // Log the processed form data
    $formData = "Processed update form data: userId=$userId, username=$username, firstName=$firstName, " .
                "middleName=$middleName, lastName=$lastName, email=$email, role=$role";
    file_put_contents(__DIR__ . '/updateuser_debug.log', "\n" . $formData, FILE_APPEND);

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
        $account = new AccountClass();

        // Update user information
        $result = $account->updateUser($userId, $username, $firstName, $middleName, $lastName, $email, $role);

        // Log the result
        file_put_contents(__DIR__ . '/updateuser_debug.log', "\nUpdate result: " . ($result ? "success" : "failure"), FILE_APPEND);

        // Return a JSON response based on the result
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'User updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update user. The username or email may already be in use.']);
        }
    } catch (Exception $e) {
        // Log the exception
        file_put_contents(__DIR__ . '/updateuser_debug.log', "\nException: " . $e->getMessage(), FILE_APPEND);
        
        // Return error message
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    // Handle invalid access (if not POST request)
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
} 