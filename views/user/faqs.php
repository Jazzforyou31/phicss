<?php
include_once '../../includes/header.php';
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>css/faqs.css">
<script src="<?php echo $base_url; ?>js/faqs.js"></script>


<section class="hero faqs-hero">
    <div class="hero-image">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Frequently Asked Questions</h1>
        </div>
    </div>
</section>

<!-- FAQs Content Section -->
<section class="faqs-content">
    <div class="container">
        <h2>Common Questions</h2>
        
        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What is Phiccs?</h3>
                    <span class="toggle-icon"><i class="fas fa-plus"></i></span>
                </div>
                <div class="faq-answer">
                    <p>Phiccs is a community-driven organization dedicated to providing valuable resources, engaging events, and quality services to our members and the broader community.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How can I join Phiccs?</h3>
                    <span class="toggle-icon"><i class="fas fa-plus"></i></span>
                </div>
                <div class="faq-answer">
                    <p>Information about joining Phiccs will be available soon. Please check back later for membership details.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Where can I find more information about upcoming events?</h3>
                    <span class="toggle-icon"><i class="fas fa-plus"></i></span>
                </div>
                <div class="faq-answer">
                    <p>You can find information about our upcoming events on the <a href="<?php echo $base_url; ?>views/user/events.php">Events</a> page.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include_once '../../includes/footer.php';
?> 