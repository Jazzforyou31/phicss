document.addEventListener('DOMContentLoaded', function() {
    console.log('Mobile toggle script loaded');
    
   
    function setupMobileToggle() {
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleIcon = document.getElementById('toggleIcon');
        
        console.log('Mobile toggle elements:', {
            toggleBtn: toggleBtn ? true : false,
            sidebar: sidebar ? true : false,
            overlay: overlay ? true : false,
            toggleIcon: toggleIcon ? true : false
        });
        
        if (!toggleBtn || !sidebar) {
            console.error('Critical elements missing for mobile toggle');
            return;
        }
        
       
        toggleBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Mobile toggle clicked');
            
            
            sidebar.classList.toggle('active');
            
            
            if (overlay) {
                overlay.classList.toggle('active');
            }
            
           
            document.body.classList.toggle('sidebar-open');
            
           
            if (toggleIcon) {
                if (sidebar.classList.contains('active')) {
                    toggleIcon.classList.remove('fa-bars');
                    toggleIcon.classList.add('fa-times');
                } else {
                    toggleIcon.classList.remove('fa-times');
                    toggleIcon.classList.add('fa-bars');
                }
            }
            
            return false;
        };
        
       
        if (overlay) {
            overlay.onclick = function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.classList.remove('sidebar-open');
                
                if (toggleIcon) {
                    toggleIcon.classList.remove('fa-times');
                    toggleIcon.classList.add('fa-bars');
                }
            };
        }
    }
    
   
    setupMobileToggle();
    
    
    setTimeout(setupMobileToggle, 500);
});


window.onload = function() {
    console.log('Window loaded - trying mobile toggle setup again');
    
    const toggleBtn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('adminSidebar');
    
    if (toggleBtn && sidebar) {
        toggleBtn.onclick = function() {
            console.log('Toggle clicked via window.onload handler');
            sidebar.classList.toggle('active');
            document.getElementById('sidebarOverlay')?.classList.toggle('active');
            document.body.classList.toggle('sidebar-open');
            
            const icon = document.getElementById('toggleIcon');
            if (icon) {
                if (sidebar.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        };
    }
}; 