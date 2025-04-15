<?php
require_once '../tools/function.php';
require_once '../classes/accountClass.php';

session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator') {
        header('location: ../views/admin/admin_dashboard');
        exit();
    } else {
        header('location: ../views/user/landing_page.php');
        exit();
    }
}

$username = $password = '';
$accountObj = new Account();
$loginErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

    if ($accountObj->login($username, $password)) {
        $data = $accountObj->fetch($username);
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['account'] = $data;
        $_SESSION['role'] = $data['role']; 

        if ($data['role'] == 'admin' || $data['role'] == 'moderator') {
            header('location: ../views/admin/admin_dashboard');
            exit();
        } else {
            header('location: ../views/user/landing_page.php');
            exit();
        }
    } else {
        $loginErr = 'Invalid username or password';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhiCCS Login</title>
   
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
                    <h2>Welcome to PhiCCS</h2>
                    <p>Philippine Computing Students Society</p>
                </div>
                <div class="login-body">
                    <?php if (!empty($loginErr)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($loginErr) ?></div>
                    <?php endif; ?>
                    
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required autocomplete="username">
                            <i class="fas fa-user input-icon"></i>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        
                        <div class="form-group mt-5">
                            <button type="submit" class="btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>Log in
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../js/login.js"></script>
</body>
</html>
