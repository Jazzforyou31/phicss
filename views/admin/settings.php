<?php
session_start();
include_once '../../includes/auth_check.php';
// require '../../classes/faqs.php';

// $accountClass = new AccountClass();
// $userList = $accountClass->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | PhiCCS Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <link rel="stylesheet" href="../../css/admin_settings.css">
    
    <style>
        .nav-menu {
            display: flex;
            gap: 20px;
            padding: 15px;
            background: rgb(255, 255, 255);
            border-radius: 10px;
        }
        .nav-btn {
            border: none;
            background: transparent;
            color: rgb(2, 67, 0);
            font-size: 16px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .nav-btn.active {
            background: #1abc9c;
            border-radius: 5px;
            color: white;
        }
        .nav-btn:hover {
            background: #16a085;
            border-radius: 5px;
        }
        .content-container {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="admin-container">
    <!-- Include Sidebar Navigation -->
    <?php include '../../includes/admin_sidebar.php'; ?>

        <div class="container">
            <div class="nav-menu">
                <button class="nav-btn" data-target="announcement">📢 Announcement</button>
                <button class="nav-btn" data-target="admin_about_phicss.php">ℹ️ About PhiCSS</button>
                <button class="nav-btn" data-target="admin_contacts.php">📞 Contacts</button>
                <button class="nav-btn" data-target="admin_photos.php">🏷️ Others</button>
            </div>
    
        <div id="content-area" class="content-container">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>  
</div>

<script src="../../js/settings.js"></script>
</body>
</html>
