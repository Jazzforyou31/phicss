<?php
session_start();
include_once '../../includes/auth_check.php';
require '../../classes/aboutClass.php';

$aboutClass = new AboutClass();
$aboutInfo = $aboutClass->fetchAboutInfo();
?>

<div class="container-fluid">
    <div class="page-header">
        <h1>About PHICSS</h1>
        <p>Manage PHICSS Information</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search..." id="searchBar">
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="editAboutBtn"><i class="fas fa-edit"></i> Edit About PHICSS</button>
    </div>

    <div class="card p-3 mb-3">
        <h5>About PHICSS Details</h5>
        <ul class="list-group">
            <li class="list-group-item border-top mb-4 mt-4">
                <h5 class="mb-1">Mission</h5>
                <p class="mb-1 text-muted"><?php echo htmlspecialchars($aboutInfo['mission'] ?? 'Not available'); ?></p>
            </li>
            <li class="list-group-item border-top mb-4">
                <h5 class="mb-1">Vision</h5>
                <p class="mb-1 text-muted"><?php echo htmlspecialchars($aboutInfo['vision'] ?? 'Not available'); ?></p>
            </li>
            <li class="list-group-item border-top mb-4">
                <h5 class="mb-1">Description</h5>
                <p class="mb-1 text-muted"><?php echo nl2br(htmlspecialchars($aboutInfo['description'] ?? 'Not available')); ?></p>
            </li>
        </ul>
        <small class="text-secondary">
            Last updated by: <strong><?php echo htmlspecialchars($aboutInfo['updated_by_name'] ?? 'Unknown'); ?></strong> 
            | Date: <?php echo htmlspecialchars($aboutInfo['updated_at'] ?? 'Unknown'); ?>
        </small>
    </div>
</div>

<script src="../../js/about.js"></script>
