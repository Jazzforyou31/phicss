<?php
require_once '../tools/function.php';
require_once '../classes/accountClass.php';

session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator') {
        header('location: ../views/admin/admin_dashboard.php');
        exit();
    } else {
        header('location: ../views/user/landing_page.php');
        exit();
    }
}

$accountObj = new Account();
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and clean form data
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $confirm_password = clean_input($_POST['confirm_password']);
    $first_name = clean_input($_POST['first_name']);
    $middle_name = isset($_POST['middle_name']) ? clean_input($_POST['middle_name']) : '';
    $last_name = clean_input($_POST['last_name']);
    $email = clean_input($_POST['email']);
    $role = 'user'; // Default role for new signups

    // Validate email domain must be @wmsu.edu.ph
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@wmsu\.edu\.ph$/', $email)) {
        $errors[] = "Email must use @wmsu.edu.ph domain";
    }

    // Check if email already exists
    $user = $accountObj->getUserByEmail($email);
    if ($user) {
        $errors[] = "Email is already registered";
    }

    // Validate password length (minimum 8 characters)
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    // If no errors, register the account
    if (empty($errors)) {
        if ($accountObj->registerAccount($username, $password, $first_name, $middle_name, $last_name, $email, $role)) {
            $success = true;
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhiCCS Sign Up</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    
    <div class="bg-animation"></div>
    
    <div class="login-container">
        <div class="login-card-wrapper">
            <div class="login-card">
                <div class="login-header">
                    <div class="logo-container">
                        <img src="../assets/images/LOGOCIRCLEVER2.png" alt="PhiCCS Logo">
                    </div>
                    <h2>Create an Account</h2>
                    <p>Philippine Computing Students Society</p>
                </div>
                <div class="login-body">
                    <?php if ($success): ?>
                        <div class="alert alert-success" role="alert">
                            Registration successful! <a href="login.php">Click here to login</a>.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!$success): ?>
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">Email (@wmsu.edu.ph)</label>
                                <input type="email" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@wmsu\.edu\.ph$" required>
                                <small class="form-text text-muted">Only @wmsu.edu.ph email addresses are allowed.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password (Minimum 8 characters)</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                                <small class="form-text text-muted">Password must be at least 8 characters long.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="8" required>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn-login">
                                <i class="fas fa-user-plus me-2"></i>Sign Up
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="login.php">Login here</a></p>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password validation
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            
            passwordInput.addEventListener('input', function() {
                if (this.value.length < 8) {
                    this.setCustomValidity('Password must be at least 8 characters long');
                } else {
                    this.setCustomValidity('');
                }
            });
            
            // Email validation
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('input', function() {
                const isValid = /^[a-zA-Z0-9._%+-]+@wmsu\.edu\.ph$/.test(this.value);
                if (!isValid) {
                    this.setCustomValidity('Email must use @wmsu.edu.ph domain');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    </script>
</body>
</html> 