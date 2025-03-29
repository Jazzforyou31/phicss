<?php
session_start();
require '../../classes/announcementClass.php';
include_once '../../includes/header.php';

$announcementClass = new AnnouncementClass();
$announcements = $announcementClass->fetchAnnouncements();
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>css/announcement.css">


<div class="container mt-4">
    <div class="page-header">
        <h1>Announcements</h1>
        <p>Stay updated with the latest news</p>
    </div>

    <div id="announcementContainer">
        <?php if (!empty($announcements)): ?>
            <?php foreach ($announcements as $announcement): ?>
                <div class="announcement-card">
                    <h5 class="announcement-title"><?php echo htmlspecialchars($announcement['announcement_title']); ?></h5>
                    <p class="announcement-meta">Posted on <?php echo date("F j, Y", strtotime($announcement['announcement_date'])); ?> by <?php echo htmlspecialchars($announcement['created_by']); ?></p>
                    <p class="announcement-message"><?php echo nl2br(htmlspecialchars($announcement['message'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">No announcements available.</p>
        <?php endif; ?>
    </div>
</div>

<?php
include_once '../../includes/footer.php';
?>
