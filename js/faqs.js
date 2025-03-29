document.addEventListener('DOMContentLoaded', function() {
    
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    
    if (!faqQuestions.length) return;
    
   
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
          
            const faqItem = this.parentElement;
            const answer = this.nextElementSibling;
            const icon = this.querySelector('.toggle-icon i');
            
            
            faqItem.classList.toggle('active');
            
            
            if (icon) {
                if (faqItem.classList.contains('active')) {
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                } else {
                    icon.classList.remove('fa-minus');
                    icon.classList.add('fa-plus');
                }
            }
        });
    });
    
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const currentFaqItem = this.parentElement;
            
        
            faqQuestions.forEach(otherQuestion => {
                const otherFaqItem = otherQuestion.parentElement;
                const otherIcon = otherQuestion.querySelector('.toggle-icon i');
                
                if (otherFaqItem !== currentFaqItem && otherFaqItem.classList.contains('active')) {
                    otherFaqItem.classList.remove('active');
                    
                    if (otherIcon) {
                        otherIcon.classList.remove('fa-minus');
                        otherIcon.classList.add('fa-plus');
                    }
                }
            });
        });
    });
    
}); 