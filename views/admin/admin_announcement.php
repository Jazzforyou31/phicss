<?php
session_start();
include_once '../../includes/auth_check.php';
require '../../classes/announcementClass.php';

$announcementClass = new AnnouncementClass();
$announcements = $announcementClass->fetchAnnouncements();
?>

<div class="container-fluid">
    <div class="page-header">
        <h1>Announcement</h1>
        <p>Manage PhiCSS announcements</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search announcements..." id="searchBar">
            </div>
            <div class="input-group">
                <button class="btn btn-outline-secondary" id="filterBtn"><i class="fas fa-filter"></i></button>
                <select class="form-select" id="filterSelect">
                    <option value="">Filter by</option>
                    <option value="latest">Latest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="addAnnouncementBtn"><i class="fas fa-plus"></i> Add Announcement</button>
    </div>

    <div class="card p-3 mb-3" id="announcementListContainer">
        <h5>Manage Announcements</h5>
        <ul class="list-group" id="announcementList">
            <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $announcement): ?>
                    <li class="list-group-item border-top mb-4"> <!-- Keeps border at the top + spacing -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-1"><?php echo htmlspecialchars($announcement['announcement_title']); ?></h5>
                            <div class="d-flex gap-3">
                                <button class="border-0 bg-transparent edit-btn" data-id="<?php echo $announcement['announcement_id']; ?>">
                                    <i class="fas fa-edit text-warning"></i>
                                </button>
                                <button class="border-0 bg-transparent delete-btn" data-id="<?php echo $announcement['announcement_id']; ?>">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </div>
                        </div>
                        <p class="mb-1 text-muted"><?php echo htmlspecialchars($announcement['message']); ?></p>
                        <small class="text-secondary">
                            Created by: <?php echo htmlspecialchars($announcement['created_by']); ?> 
                            | Date: <?php echo date('F j, Y', strtotime($announcement['announcement_date'])); ?>
                        </small>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No announcements available.</p>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script src="../../js/announcement.js"></script>
