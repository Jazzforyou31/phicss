<?php
// events.php
session_start();
include_once '../../includes/auth_check.php';
require_once '../../classes/eventClass.php';

$eventClass = new EventClass();
$eventList = $eventClass->fetchEventsByAdmin();

// Debug image paths - remove in production
$debug = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Events</title>
    <?php include '../../includes/head.php'; ?>
    <link href="../../css/admin_dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <link rel="stylesheet" href="../../css/admin_news.css">
</head>
<body>
<div class="admin-container">
    <?php include '../../includes/admin_sidebar.php'; ?>

    <div class="content">
        <div class="page-header">
            <h1>Events Management</h1>
            <p>Manage Events</p>
        </div>

        <!-- Message Alert -->
        <div id="messageAlert" class="alert alert-dismissible fade" role="alert">
            <span id="alertMessage"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="search-and-button-container">
            <div class="search-container">
                <input type="text" placeholder="Search events...">
                <button><i class="fas fa-search"></i> Search</button>
            </div>
            <button class="add-report-btn" id="addEventButton" data-bs-toggle="modal" data-bs-target="#addEventModal">
                <i class="fas fa-plus"></i> Add Event
            </button>
        </div>

        <!-- Events Cards -->
        <?php if (!empty($eventList)): ?>
            <div class="news-container">
                <?php foreach ($eventList as $event): ?>
                    <div class="news-card">
                        <div class="news-image">
                            <?php
                            $defaultImage = '../../assets/images/default.png';
                            $imagePath = $defaultImage;
                            
                            if (!empty($event['image'])) {
                                if (filter_var($event['image'], FILTER_VALIDATE_URL)) {
                                    // External URL
                                    $imagePath = $event['image'];
                                } else {
                                    // Local file
                                    $imagePath = '../../assets/images/' . $event['image'];
                                    
                                    // Debug info - remove in production
                                    if ($debug) {
                                        echo "<!-- Image debug: " . $imagePath . " -->";
                                        echo "<!-- File exists: " . (file_exists($_SERVER['DOCUMENT_ROOT'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__) . '/../../assets/images/') . '/' . $event['image'])) ? 'Yes' : 'No') . " -->";
                                    }
                                }
                            }
                            ?>
                            <img src="<?php echo $imagePath; ?>" 
                                 alt="<?php echo htmlspecialchars($event['event_name']); ?>" 
                                 onerror="this.onerror=null;this.src='<?php echo $defaultImage; ?>'">
                        </div>
                        <div class="news-content">
                            <p class="news-date">
                                <?= date('M d, Y', strtotime($event['event_start_date'])) ?> to 
                                <?= date('M d, Y', strtotime($event['event_end_date'])) ?>
                            </p>
                            <h2 class="news-title"><?= htmlspecialchars($event['event_name']) ?></h2>
                            <p class="news-description"><?= nl2br(htmlspecialchars($event['event_description'])) ?></p>
                            <p class="news-author">
                                <i class="fas fa-map-marker-alt me-2"></i><?= htmlspecialchars($event['event_venue']) ?>
                            </p>
                        </div>
                        <div class="action-icons">
                            <button type="button" class="edit-btn btn" data-id="<?= $event['event_id'] ?>" title="Edit Event">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="delete-btn btn" data-id="<?= $event['event_id'] ?>" title="Delete Event">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No events found. Click the "Add Event" button to create your first event.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Include Modals -->
<?php include '../adminModals/addEventModal.html'; ?>
<?php include '../adminModals/editEventModal.html'; ?>
<?php include '../adminModals/deleteEventModal.html'; ?>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../js/events.js"></script>
</body>
</html>