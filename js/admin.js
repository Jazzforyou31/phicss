// Immediately run sidebar initialization
(function() {
    console.log('Immediate sidebar initialization running');
    initializeSidebar();
})();

// Initialize sidebar functionality when DOM is ready 
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - initializing sidebar');
    initializeSidebar();
});

// Function to initialize sidebar
function initializeSidebar() {
    // Get elements
    const sidebar = document.getElementById('adminSidebar');
    const mainContent = document.querySelector('.main-content');
    const toggleButton = document.getElementById('menu-toggle');
    const toggleIcon = document.getElementById('toggleIcon');
    const overlay = document.getElementById('sidebarOverlay');
    
    console.log('Sidebar initialization - Elements:', {
        sidebar: sidebar ? true : false,
        mainContent: mainContent ? true : false,
        toggleButton: toggleButton ? true : false,
        toggleIcon: toggleIcon ? true : false,
        overlay: overlay ? true : false
    });
    
    // If elements don't exist, exit early
    if (!sidebar || !toggleButton || !toggleIcon) {
        console.error('Required sidebar elements not found');
        return;
    }
    
    // Function to toggle sidebar
    function toggleSidebar(e) {
        console.log('Toggle sidebar button clicked');
        
        // Prevent default behavior
        if (e) e.preventDefault();
        e.stopPropagation();
        
        if (window.innerWidth < 768) {
            console.log('Mobile view: toggling active class');
            
            // Toggle active classes
            sidebar.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
            document.body.classList.toggle('sidebar-open');
            
            // Update icon
            if (sidebar.classList.contains('active')) {
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-times');
            } else {
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            }
        } else {
            console.log('Desktop view: toggling collapsed class');
            
            // Toggle collapsed classes
            sidebar.classList.toggle('collapsed');
            if (mainContent) mainContent.classList.toggle('expanded');
        }
    }
    
    // Add click event listener to toggle button
    console.log('Adding click event to toggle button');
    toggleButton.onclick = toggleSidebar;
    
    // Backup method - add event listener normally as well
    toggleButton.addEventListener('click', toggleSidebar);
    
    // Adjust for screen size
    function adjustForScreenSize() {
        console.log('Adjusting for screen size:', window.innerWidth);
        
        if (window.innerWidth < 768) {
            // Mobile view setup
            sidebar.classList.remove('collapsed');
            
            if (mainContent) {
                mainContent.classList.add('expanded');
            }
        } else {
            // Desktop view setup
            sidebar.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            
            if (mainContent) {
                mainContent.classList.remove('expanded');
            }
        }
        
        // Reset icon regardless
        toggleIcon.classList.remove('fa-times');
        toggleIcon.classList.add('fa-bars');
    }
    
    // Add resize event listener
    window.addEventListener('resize', adjustForScreenSize);
    
    // Initial setup
    adjustForScreenSize();
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (window.innerWidth < 768 && 
            sidebar.classList.contains('active') && 
            !sidebar.contains(event.target) && 
            !toggleButton.contains(event.target)) {
            
            console.log('Closing sidebar - clicked outside');
            sidebar.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.classList.remove('sidebar-open');
            toggleIcon.classList.remove('fa-times');
            toggleIcon.classList.add('fa-bars');
        }
    });

    // Close sidebar when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            if (sidebar.classList.contains('active')) {
                console.log('Closing sidebar - clicked overlay');
                sidebar.classList.remove('active');
                this.classList.remove('active');
                document.body.classList.remove('sidebar-open');
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            }
        });
    }
}

function loadNewsSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/news.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("News")').parent().addClass('active');
            // Update page title
            document.title = "News | phicss Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading news section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load News section. Please try again.</p>');
        }
    });
}

function loadTransparencySection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/transparency.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("Transparency")').parent().addClass('active');
            // Update page title
            document.title = "Transparency Report | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading transparency section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Transparency section. Please try again.</p>');
        }
    });
}

function loadDashboardSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/admin_dashboard_content.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("Dashboard")').parent().addClass('active');
            // Update page title
            document.title = "Dashboard | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading dashboard section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Dashboard section. Please try again.</p>');
        }
    });
}

function loadEventsSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/events.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("Events")').parent().addClass('active');
            // Update page title
            document.title = "Events | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading news section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load News section. Please try again.</p>');
        }
    });
}


function loadUserSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/users.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("Users")').parent().addClass('active');
            // Update page title
            document.title = "Events | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading news section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load News section. Please try again.</p>');
        }
    });
}

function loadFaqsSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/faqs.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("FAQs")').parent().addClass('active');
            // Update page title
            document.title = "FAQs | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading FAQs section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load FAQs section. Please try again.</p>');
        }
    });
}


function loadOfficerSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/officers.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("Officers")').parent().addClass('active');
            // Update page title
            document.title = "Officers | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            $('#contentArea').html('<p class="text-danger">Failed to load Officers section. Please try again.</p>');
        }
    });
}


function loadSettingSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/settings.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("settings")').parent().addClass('active');
            // Update page title
            document.title = "Setting | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading Officers section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load settings section. Please try again.</p>');
        }
    });
}




