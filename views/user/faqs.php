<?php
include_once '../../includes/header.php';
require_once '../../classes/FaqsClass.php'; // Include the FaqsClass

$faqsClass = new FaqsClass();
$faqs = $faqsClass->fetchFAQs(); // Fetch all FAQs dynamically
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
            <?php if (!empty($faqs)): ?>
                <?php foreach ($faqs as $faq): ?>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3><?php echo htmlspecialchars($faq['question']); ?></h3>
                            <span class="toggle-icon"><i class="fas fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No FAQs available at the moment. Please check back later.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
include_once '../../includes/footer.php';
?>