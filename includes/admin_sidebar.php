<?php
// Determine the current page for active menu highlighting
$request_uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($request_uri, '/'));
$current_page = end($uri_parts);

// If the URI ends with .php, remove it
if (substr($current_page, -4) === '.php') {
    $current_page = basename($current_page, '.php');
}

// If the current page is empty, set it to a default value
if (empty($current_page)) {
    // This is likely the homepage
    $current_page = 'index';
}

// If we're in admin section and the page is 'admin', change to admin_dashboard
if ($current_page == 'admin') {
    $current_page = 'admin_dashboard';
}

// If base_url is not defined, create it for proper linking
if (!isset($base_url)) {
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
        $base_url = 'https://';
    } else {
        $base_url = 'http://';
    }
    $base_url .= $_SERVER['HTTP_HOST'];
    $folder = '/phicss/';
    if (strpos($_SERVER['REQUEST_URI'], '/phicss/') !== false) {
        $base_url .= $folder;
    } else {
        $folder = '/';
        $base_url .= $folder;
    }
}
?>

<!-- Mobile toggle button -->
<div class="mobile-toggle-container">
    <button type="button" id="menu-toggle" class="menu-toggle" aria-label="Toggle navigation">
        <i class="fas fa-bars" id="toggleIcon"></i>
    </button>
</div>

<!-- Sidebar overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar container -->
<div class="sidebar" id="adminSidebar">
    <div class="logo-container">
        <img src="<?php echo $base_url; ?>assets/images/OfficialLogoVer2.png" alt="PhiCCS Logo">
        <div class="logo-text">WMSU | COLLEGE OF COMPUTING STUDIES</div>
    </div>
    
    <hr class="sidebar-divider">
    
    <div class="menu-section">
        <div class="menu-label">MAIN</div>
        <ul class="menu-items">
            <li class="<?php echo ($current_page == 'admin_dashboard') ? 'active' : ''; ?>">
                <a href="#" onclick="loadDashboardSection()">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php echo ($current_page == 'users') ? 'active' : ''; ?>">
                <a href="#" onclick="loadUserSection()">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="<?php echo ($current_page == 'faqs') ? 'active' : ''; ?>">
                <a href="#" onclick="loadFaqsSection()">
                    <i class="fas fa-question-circle"></i>
                    <span>FAQs</span>
                </a>
            </li>
            <li class="<?php echo ($current_page == 'events') ? 'active' : ''; ?>">
                <a href="#" onclick="loadEventsSection()">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events & Calendar</span>
                </a>
            </li>
            <li class="<?php echo ($current_page == 'news') ? 'active' : ''; ?>">
                <a href="#" onclick="loadNewsSection()">
                    <i class="fas fa-newspaper"></i>
                    <span>News</span>
                </a>
            </li>
            <li class="<?php echo ($current_page == 'transparency') ? 'active' : ''; ?>">
                <a href="#" onclick="loadTransparencySection()">
                    <i class="fas fa-file-alt"></i>
                    <span>Transparency Report</span>
                </a>
            </li>
            <li class="<?php echo ($current_page == 'officers') ? 'active' : ''; ?>">
                <a href="#" onclick="loadOfficerSection()">
                    <i class="fas fa-users"></i>
                    <span>Officers</span>
                </a>
            </li>
        </ul>
    </div>
    
    <hr class="sidebar-divider">
    
    <div class="menu-section">
        <div class="menu-label">CONTENT MANAGEMENT</div>
        <ul class="menu-items">
            <li class="<?php echo ($current_page == 'settings') ? 'active' : ''; ?>">
                <a href="#" onclick="loadSettingSection()">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="sidebar-footer">
        <a href="<?php echo $base_url; ?>logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>