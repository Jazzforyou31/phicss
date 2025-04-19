<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Philippine Computing Students Society</title>
    <?php 
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
    ?>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/header.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    
    <script src="<?php echo $base_url; ?>js/menu.js" defer></script>
</head>
<body>
    <header id="site-header">
       
        <div class="top-header">
            <div class="logo-container">
                <img src="<?php echo $base_url; ?>assets/images/OfficialLogoVer2.png" alt="PhiCCS Logo">
                <div class="title-container">
                    <h1>Philippine Computing Students Society</h1>
                    <p>Western Mindanao State University | College of Computing Studies</p>
                </div>
            </div>
            <div class="header-right">
                <?php include_once 'announcementBanner.php'; ?>
                <a href="<?php echo $base_url; ?>views/user/contact" class="contact-btn">Contact Us</a>
            </div>
        </div>
        
        <!-- Main navigation -->
        <nav class="main-nav">
            <!-- Search box -->
            <div class="search-container">
            <button class="search-button" id="searchButton">
                <i class="fas fa-search"></i> <!-- Search Icon -->Search here..
            </button> 
            <input type="text" placeholder="Type to search..." class="search-box" id="searchBox">
        </div>
            
            <!-- Hamburger menu for mobile -->
            <div class="mobile-toggle" id="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            
            <ul class="nav-links">
                <?php 
                $isHomePage = (strpos($_SERVER['REQUEST_URI'], 'landing_page') !== false || 
                              $_SERVER['REQUEST_URI'] == '/PhiCCS_Prototype/' || 
                              $_SERVER['REQUEST_URI'] == '/');
                ?>
                <li><a href="<?php echo $base_url; ?>" class="<?php echo $isHomePage ? 'active' : ''; ?>">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle <?php echo (strpos($_SERVER['REQUEST_URI'], '/about') !== false || strpos($_SERVER['REQUEST_URI'], '/bylaws') !== false || strpos($_SERVER['REQUEST_URI'], '/faqs') !== false) ? 'active' : ''; ?>">About PhiCCS</a>
                    <ul class="dropdown-content">
                        <li><a href="<?php echo $base_url; ?>views/user/about" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/about') !== false) ? 'active' : ''; ?>">About Us</a></li>
                        <li><a href="<?php echo $base_url; ?>views/user/bylaws" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/bylaws') !== false) ? 'active' : ''; ?>">Bylaws</a></li>
                        <li><a href="<?php echo $base_url; ?>views/user/faqs" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/faqs') !== false) ? 'active' : ''; ?>">FAQs</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo $base_url; ?>views/user/news" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/news') !== false) ? 'active' : ''; ?>">News</a></li>
                <li><a href="<?php echo $base_url; ?>views/user/events" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/events') !== false) ? 'active' : ''; ?>">Events</a></li>
                <li><a href="<?php echo $base_url; ?>views/user/transparency" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/transparency') !== false) ? 'active' : ''; ?>">Transparency Page</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>

<script>
const searchButton = document.getElementById('searchButton');
const searchBox = document.getElementById('searchBox');

searchButton.addEventListener('click', () => {
    // Toggle the active class on the search box
    searchBox.classList.toggle('active');

    // Hide the button text when the search box is expanded
    if (searchBox.classList.contains('active')) {
        searchButton.classList.add('hidden');
        searchBox.focus(); // Focus on the input field when expanded
    } else {
        searchButton.classList.remove('hidden');
    }
});
</script>