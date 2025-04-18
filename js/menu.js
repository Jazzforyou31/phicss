/**
 * Main navigation and UI interactions
 * Handles sticky header, mobile menu, dropdowns and announcements
 */
document.addEventListener('DOMContentLoaded', function() {
    // -----------------------------------------
    // ELEMENT SELECTORS AND UTILITY FUNCTIONS
    // -----------------------------------------
    const mobileToggle = document.getElementById('mobile-menu-toggle') || document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.nav-links');
    const dropdowns = document.querySelectorAll('.dropdown');
    const header = document.querySelector('header') || document.getElementById('site-header');
    
    // Skip initialization if nav not found
    if (!navLinks) return;
    
    // Check if viewing on mobile device
    function isMobileView() {
        return window.innerWidth <= 768;
    }
    
    // -----------------------------------------
    // STICKY HEADER FUNCTIONALITY
    // -----------------------------------------
    if (header) {
        const headerOffset = header.offsetTop;
        
        function makeHeaderSticky() {
            if (window.pageYOffset > headerOffset) {
                header.classList.add('sticky');
                document.body.style.paddingTop = header.offsetHeight + 'px';
            } else {
                header.classList.remove('sticky');
                document.body.style.paddingTop = 0;
            }
        }
        
        window.addEventListener('scroll', makeHeaderSticky);
        makeHeaderSticky(); // Initialize on page load
    }
    
    // -----------------------------------------
    // MOBILE MENU TOGGLE
    // -----------------------------------------
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            navLinks.classList.toggle('active');
            this.classList.toggle('active');
            
            // Toggle icon between bars and X
            const icon = this.querySelector('i');
            if (icon) {
                if (icon.classList.contains('fa-bars')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
            
            // Close all dropdowns when toggling menu
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        });
    }
    
    // -----------------------------------------
    // DROPDOWN MENU FUNCTIONALITY
    // -----------------------------------------
    dropdowns.forEach(dropdown => {
        const dropdownLink = dropdown.querySelector('a');
        
        if (dropdownLink) {
            dropdownLink.addEventListener('click', function(e) {
                if (isMobileView()) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Close other open dropdowns
                    document.querySelectorAll('.dropdown').forEach(function(item) {
                        if (item !== dropdown && item.classList.contains('active')) {
                            item.classList.remove('active');
                        }
                    });
                    
                    // Toggle current dropdown
                    dropdown.classList.toggle('active');
                    
                    // Ensure dropdown is visible when open
                    if (dropdown.classList.contains('active')) {
                        setTimeout(function() {
                            const dropdownContent = dropdown.querySelector('.dropdown-content');
                            if (dropdownContent) {
                                const lastItem = dropdownContent.querySelector('li:last-child');
                                
                                if (lastItem) {
                                    const lastItemRect = lastItem.getBoundingClientRect();
                                    const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
                                    
                                    if (lastItemRect.bottom > viewportHeight) {
                                        dropdown.scrollIntoView({behavior: 'smooth', block: 'start'});
                                        
                                        setTimeout(function() {
                                            const navLinks = document.querySelector('.nav-links');
                                            if (navLinks && navLinks.classList.contains('active')) {
                                                navLinks.scrollTop = dropdownContent.offsetHeight;
                                            }
                                        }, 300);
                                    }
                                }
                            }
                        }, 100);
                    }
                }
            });
        }
    });
    
    // -----------------------------------------
    // CLOSE MENU WHEN CLICKING OUTSIDE
    // -----------------------------------------
    document.addEventListener('click', function(e) {
        if (!mobileToggle || !navLinks) return;
        
        const isClickInside = navLinks.contains(e.target) || mobileToggle.contains(e.target);
        
        if (!isClickInside && navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            mobileToggle.classList.remove('active');
            
            if (mobileToggle.querySelector('i')) {
                mobileToggle.querySelector('i').classList.add('fa-bars');
                mobileToggle.querySelector('i').classList.remove('fa-times');
            }
            
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });
    
    // -----------------------------------------
    // HANDLE WINDOW RESIZE
    // -----------------------------------------
    window.addEventListener('resize', function() {
        if (!isMobileView()) {
            // Reset when switching to desktop view
            if (navLinks) navLinks.classList.remove('active');
            if (mobileToggle) {
                mobileToggle.classList.remove('active');
                
                if (mobileToggle.querySelector('i')) {
                    mobileToggle.querySelector('i').classList.add('fa-bars');
                    mobileToggle.querySelector('i').classList.remove('fa-times');
                }
            }
            
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });
    
   
});
    

