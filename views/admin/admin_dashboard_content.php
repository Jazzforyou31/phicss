<?php
require_once '../../classes/accountClass.php'; // For users
// require_once '../../classes/EventClass.php'; // For events
require_once '../../classes/newsClass.php'; // For content
require_once '../../classes/cashInOutClass.php'; // For total collection

// Initialize classes to interact with the database
$account = new account();
// $eventClass = new EventClass();
$newsClass = new newsClass();
$cashInOutClass = new cashInOutClass();


$account = $account->getTotalUsers();
// $upcomingEvents = $eventClass->getUpcomingEventsCount();
$totalContentItems = $newsClass->getTotalContentItems();
$totalCashIn = $cashInOutClass->getTotalCashIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../css/admin_dashboard.css">
    
</head>
<body>

<div class="content">
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Welcome to the PhiCCS Admin Dashboard</p>
    </div>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Users</h3>
                <p><?php echo htmlspecialchars($account); ?></p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon events">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>Upcoming Events</h3>
                <p>5</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon content">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <h3>Content Items</h3>
                <p>11</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon activity">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>Total Collection</h3>
                <p><?php echo htmlspecialchars(number_format($totalCashIn, 2)); ?></p>
            </div>
        </div>
    </div>
    
    <div class="dashboard-widgets">
        <!-- Recent Activity Widget -->
        <div class="widget recent-activity">
            <div class="widget-header">
                <h2>Recent Activity</h2>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="widget-content">
                <ul class="activity-list">
                    <?php if (!empty($recentActivities)): ?>
                        <?php foreach ($recentActivities as $activity): ?>
                            <li>
                                <div class="activity-icon"><i class="fas <?php echo htmlspecialchars($activity['icon']); ?>"></i></div>
                                <div class="activity-details">
                                    <p><?php echo htmlspecialchars($activity['message']); ?></p>
                                    <span class="activity-time"><?php echo htmlspecialchars($activity['time']); ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No recent activities found.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
        <!-- Quick Actions Widget -->
        <div class="widget quick-actions">
            <div class="widget-header">
                <h2>Quick Actions</h2>
            </div>
            <div class="widget-content">
                <div class="action-buttons">
                    <a href="create_event" class="action-btn">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Create Event</span>
                    </a>
                    
                    <div class="action-btn">
                        <i class="fas fa-user-plus" id="addNewUserBtn"></i>
                        <span>Add User</span>
                    </div>
                 

                    <div class="action-btn">
                        <i class="fas fa-file-medical" id="addNewsButton"></i>
                        <span>Create Post</span>
                    </div>


                    <a href="settings.php" class="action-btn">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="../../js/users.js"></script>
<script src="../../js/news.js"></script>

</html>


