<?php

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
                            <p>250</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon events">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Upcoming Events</h3>
                            <p>12</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon content">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Content Items</h3>
                            <p>86</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon activity">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Visitors</h3>
                            <p>24</p>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-widgets">
                    <div class="widget recent-activity">
                        <div class="widget-header">
                            <h2>Recent Activity</h2>
                            <a href="#" class="view-all">View All</a>
                        </div>
                        <div class="widget-content">
                            <ul class="activity-list">
                                <li>
                                    <div class="activity-icon"><i class="fas fa-user-plus"></i></div>
                                    <div class="activity-details">
                                        <p>New user registered</p>
                                        <span class="activity-time">2 hours ago</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="activity-icon"><i class="fas fa-edit"></i></div>
                                    <div class="activity-details">
                                        <p>Content updated on Events page</p>
                                        <span class="activity-time">5 hours ago</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="activity-icon"><i class="fas fa-comment"></i></div>
                                    <div class="activity-details">
                                        <p>New comment on FAQ section</p>
                                        <span class="activity-time">1 day ago</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="activity-icon"><i class="fas fa-calendar-plus"></i></div>
                                    <div class="activity-details">
                                        <p>New event created</p>
                                        <span class="activity-time">2 days ago</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
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
                                <a href="add_user" class="action-btn">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Add User</span>
                                </a>
                                <a href="create_post" class="action-btn">
                                    <i class="fas fa-file-medical"></i>
                                    <span>Create Post</span>
                                </a>
                                <a href="settings" class="action-btn">
                                    <i class="fas fa-cog"></i>
                                    <span>Settings</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 