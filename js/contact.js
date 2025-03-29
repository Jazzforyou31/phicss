/**
 * Contact Page JavaScript
 * Handles FAQ toggle and form validation
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Toggle FAQ answers
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            answer.classList.toggle('active');
            question.classList.toggle('active');
        });
    });
    
    // Contact form validation
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Basic form validation
            let valid = true;
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const subject = document.getElementById('subject');
            const message = document.getElementById('message');
            
            // Reset previous error states
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach(group => {
                group.classList.remove('error');
            });
            
            // Validate name
            if (!name.value.trim()) {
                valid = false;
                name.parentElement.classList.add('error');
            }
            
            // Validate email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailPattern.test(email.value)) {
                valid = false;
                email.parentElement.classList.add('error');
            }
            
            // Validate subject
            if (!subject.value || subject.value === "") {
                valid = false;
                subject.parentElement.classList.add('error');
            }
            
            // Validate message
            if (!message.value.trim()) {
                valid = false;
                message.parentElement.classList.add('error');
            }
            
            // If valid, we would typically submit the form
            // For now, just show a success message
            if (valid) {
                // Simulated form submission - in a real app, you'd handle AJAX submission
                // or allow the form to submit naturally
                
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'success-message';
                successMessage.textContent = 'Thank you for your message! We will get back to you soon.';
                
                // Insert success message after the form
                contactForm.parentNode.insertBefore(successMessage, contactForm.nextSibling);
                
                // Reset form
                contactForm.reset();
                
                // Hide success message after 5 seconds
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 5000);
            }
        });
    }
}); 