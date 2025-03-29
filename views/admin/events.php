<?php
// events.php
session_start();
require_once '../../classes/eventClass.php';

$eventClass = new EventClass();
$eventList = $eventClass->fetchEventsByAdmin();

// Prepare events for FullCalendar
$calendarEvents = [];
foreach ($eventList as $event) {
    $imagePath = '../../assets/images/default.png';
    if (!empty($event['image'])) {
        if (filter_var($event['image'], FILTER_VALIDATE_URL)) {
            $imagePath = $event['image'];
        } else {
            $localPath = '../../assets/images/' . $event['image'];
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($localPath, PHP_URL_PATH))) {
                $imagePath = $localPath;
            }
        }
    }

    $calendarEvents[] = [
        'id' => $event['event_id'],
        'title' => $event['event_name'],
        'start' => $event['event_start_date'],
        'end' => $event['event_end_date'],
        'description' => $event['event_description'],
        'className' => 'fc-event-primary'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <link rel="stylesheet" href="../../css/admin_news.css">
    <style>
        /* Calendar-specific styles */
        #eventsCalendar {
            min-height: 600px;
            background: white;
            margin: 0 auto;
        }
        .fc-event {
            cursor: pointer;
            padding: 3px;
            margin-bottom: 2px;
            border-radius: 3px;
        }
        .fc-event-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .fc-daygrid-event {
            white-space: normal !important;
        }
    </style>
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

        <!-- Calendar Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="far fa-calendar-alt me-2"></i>Events Calendar</h5>
            </div>
            <div class="card-body">
                <div id="eventsCalendar"></div>
            </div>
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
                                    $imagePath = $event['image'];
                                } else {
                                    $localPath = '../../assets/images/' . $event['image'];
                                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($localPath, PHP_URL_PATH))) {
                                        $imagePath = $localPath;
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
<!-- Add FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="../../js/events.js"></script>

<!-- Initialize FullCalendar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('eventsCalendar');
    
    if (!calendarEl) {
        console.error('Calendar element not found');
        return;
    }
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: <?php echo json_encode($calendarEvents); ?>,
        eventDisplay: 'block',
        eventDidMount: function(info) {
            if (info.event.title) {
                info.el.setAttribute('title', info.event.title);
            }
        }
    });
    
    calendar.render();
});
</script>
</body>
</html>