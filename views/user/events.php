<?php
include_once '../../includes/header.php';
require_once '../../classes/eventClass.php';

$eventClass = new EventClass();
$events = $eventClass->fetchEventsByAdmin(); // Fetch events from the database
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>css/events.css">

<div class="announcement-banner">
    <div class="announcement-label">Announcement</div>
    <div class="announcement-content">
        <div class="announcement-text">
            <a href="<?php echo $base_url; ?>views/user/announcements.php" class="announcement-link">Part Time Offer for Computing Studies Students</a>
        </div>
        <div class="nav-arrows">
            <div class="nav-arrow">&#10094;</div>
            <div class="nav-arrow">&#10095;</div>
        </div>
    </div>
</div>

<section>
    <div class="container">
        <div class="header">
            <h1>Calendar of Events</h1>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search for an Event">
            <button>Search</button>
        </div>

        <div class="nav-and-filters">
            <div class="nav">
                <button class="active">All Events</button>
                <button>Day | March 9, 2025</button>
                <button>Week</button>
                <button>Month</button>
            </div>

            <div class="filters">
                <select>
                    <option>Date Range</option>
                </select>
                <select>
                    <option>Event Category</option>
                </select>
                <select>
                    <option>Audience</option>
                </select>
            </div>
        </div>

        <hr>

        <div class="events">
            <h2>Upcoming Events</h2>
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="event">
                        <img src="<?php echo $base_url . 'uploads/' . $event['image']; ?>" alt="Event Image">
                        <div class="event-details">
                            <p><?php echo date('F j, Y', strtotime($event['event_start_date'])) . " - " . date('F j, Y', strtotime($event['event_end_date'])); ?></p>
                            <a href="#"><h3><?php echo htmlspecialchars($event['event_name']); ?></h3></a>
                            <p><?php echo htmlspecialchars($event['event_description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No events found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
include_once '../../includes/footer.php';
?>
