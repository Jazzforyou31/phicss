<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // If not logged in, redirect to login page
    header("Location: ../../accounts/login.php");
    exit();
}

// Check if user has admin/moderator role for admin pages
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'moderator') {
    // If not admin or moderator, redirect to user landing page
    header("Location: ../../views/user/landing_page.php");
    exit();
}
?> 