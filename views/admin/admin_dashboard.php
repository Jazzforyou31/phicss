<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>    
    <?php 
    // Include authentication check
    include_once '../../includes/auth_check.php';
    include '../../includes/head.php'; 
    ?> 
</head>
<body>
<div class="admin-container">
   
    <?php include '../../includes/admin_sidebar.php'; ?>
    
    
    <div class="main-content">
       
        <?php include '../../includes/admin_topnav.php'; ?>

            <div class="col py-3 content-container">
                <div id="contentArea" class="container mt-4">
                    <?php include '../admin/admin_dashboard_content.php'; ?>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../js/admin.js"></script>
    <script src="../../js/mobile-toggle.js"></script>
</body>
</html>
