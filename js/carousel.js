document.addEventListener('DOMContentLoaded', function() {
   
    const carousel = document.querySelector('.carousel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const teamMembers = document.querySelectorAll('.team-member');
    
    
    if (!carousel || !prevBtn || !nextBtn || teamMembers.length === 0) return;
    
    let currentIndex = 0;
    const memberWidth = teamMembers[0].offsetWidth;
    const visibleMembers = window.innerWidth < 768 ? 1 : 3; 
    const maxIndex = Math.max(0, teamMembers.length - visibleMembers);
    
    
    updateCarousel();
    
  
    prevBtn.addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });
    
    nextBtn.addEventListener('click', function() {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel();
        }
    });
    
    
    window.addEventListener('resize', function() {
        
        const newVisibleMembers = window.innerWidth < 768 ? 1 : 3;
        if (visibleMembers !== newVisibleMembers) {
            visibleMembers = newVisibleMembers;
            maxIndex = Math.max(0, teamMembers.length - visibleMembers);
            
            if (currentIndex > maxIndex) currentIndex = maxIndex;
            updateCarousel();
        }
    });
    
    function updateCarousel() {
        const offset = -currentIndex * (memberWidth + 20); 
        carousel.style.transform = `translateX(${offset}px)`;
        
        
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= maxIndex;
    }
}); 