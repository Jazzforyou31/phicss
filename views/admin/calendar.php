<?php
require '../../classes/eventClass.php';

$eventClass = new EventClass();
$eventDates = $eventClass->fetchEventDates();

// Debugging output to check the events fetched
if (empty($eventDates)) {
    echo "<script>console.error('No events found');</script>";
}

// Convert event data to JSON
echo "<script>const events = " . json_encode($eventDates) . ";</script>";
?>

<div id="calendar">
    <div class="calendar-header">
        <button id="prevMonth"><i class="fas fa-chevron-left"></i></button>
        <h2 id="currentMonthYear"></h2>
        <button id="nextMonth"><i class="fas fa-chevron-right"></i></button>
    </div>
    <div class="calendar-grid"></div>
</div>

<script src="../../js/calendar.js"></script>