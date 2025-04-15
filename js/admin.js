// Document ready shorthand
$(function() {
    initializeSidebar();

    // Also initialize on DOM content loaded (for robustness)
    document.addEventListener('DOMContentLoaded', function() {
        initializeSidebar();
    });

    function initializeSidebar() {
        // Get sidebar elements
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebarOverlay = document.querySelector('.sidebar-overlay');
        const content = document.querySelector('.content');
        
        // Skip if elements don't exist
        if (!sidebar || !sidebarToggle || !content) {
            return;
        }
        
        // Function to toggle sidebar
        function toggleSidebar() {
            const viewportWidth = window.innerWidth;
            
            // Different behavior based on screen size
            if (viewportWidth < 992) { // Mobile view
                sidebar.classList.toggle('active');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.toggle('active');
                }
                
                // Prevent scroll on body when sidebar is open on mobile
                document.body.classList.toggle('sidebar-open');
            } else { // Desktop view
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
                
                // Store preference in localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebar_collapsed', isCollapsed ? 'true' : 'false');
            }
        }
        
        // Add click event to toggle button
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        
        // Adjust layout based on screen size
        function adjustLayout() {
            const viewportWidth = window.innerWidth;
            
            // Get saved preference from localStorage
            const savedCollapsed = localStorage.getItem('sidebar_collapsed');
            
            if (viewportWidth < 992) {
                // Mobile view - always close sidebar
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('active');
                content.classList.remove('expanded');
                
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('active');
                }
                
                document.body.classList.remove('sidebar-open');
            } else {
                // Desktop view - respect saved preferences
                if (savedCollapsed === 'true') {
                    sidebar.classList.add('collapsed');
                    content.classList.add('expanded');
                } else {
                    sidebar.classList.remove('collapsed');
                    content.classList.remove('expanded');
                }
                
                // Always remove mobile classes
                sidebar.classList.remove('active');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('active');
                }
                document.body.classList.remove('sidebar-open');
            }
        }
        
        // Close sidebar when clicking outside (mobile only)
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 992 && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target) && 
                sidebar.classList.contains('active')) {
                
                sidebar.classList.remove('active');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('active');
                }
                document.body.classList.remove('sidebar-open');
            }
        });
        
        // Close sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            });
        }
        
        // Initial layout adjustment
        adjustLayout();
        
        // Adjust layout on window resize
        window.addEventListener('resize', adjustLayout);
    }
});

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

function loadCollectionSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/collection.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("collection")').parent().addClass('active');
            // Update page title
            document.title = "Collection | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading Collection section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load collection section. Please try again.</p>');
        }
    });
}

function loadVolunteerSection() {
    // Show loading indicator
    $('#contentArea').html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    $.ajax({
        url: "../../views/admin/volunteers.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
            // Update active state in sidebar
            $('.menu-items li').removeClass('active');
            $('.menu-items li a:contains("volunteer")').parent().addClass('active');
            // Update page title
            document.title = "Volunteer | PhiCCS Admin";
        },
        error: function (xhr, status, error) {
            console.error('Error loading volunteer section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load volunteer section. Please try again.</p>');
        }
    });
}





