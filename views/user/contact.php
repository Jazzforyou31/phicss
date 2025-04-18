<?php
include_once '../../includes/header.php';
require_once '../../classes/ContactsClass.php';
require_once '../../classes/MessageClass.php';

// Initialize classes
$contacts = new ContactClass();
$contactList = $contacts->fetchAllContacts();


$messageObj = new MessageClass();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? null;
    $message = $_POST['message'] ?? '';

    // Validate required fields
    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $dateSent = date('Y-m-d H:i:s'); // Current timestamp
            $status = 'Pending'; // Default status for new inquiries
            $added = $messageObj->addMessage($name, $email, $phone, $message, $dateSent, $status);
            if ($added) {
                $successMessage = 'Your inquiry has been sent successfully!';
            } else {
                $errorMessage = 'Failed to send your inquiry. Please try again later.';
            }
        } catch (Exception $e) {
            $errorMessage = 'An error occurred: ' . $e->getMessage();
        }
    } else {
        $errorMessage = 'Name, email, and message are required fields.';
    }
}
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>css/contact.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="contact-page">
    <div class="contact-hero">
        <h1>Get in Touch</h1>
        <p>We'd love to hear from you. Feel free to reach out with any questions or inquiries.</p>
    </div>

    <div class="contact-container">
        <!-- Contact Information Section -->
        <div class="contact-info">
            <?php if (!empty($contactList)): ?>
                <?php foreach ($contactList as $contact): ?>
                    <!-- Address Section -->
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Visit Us</h3>
                        <p>
                            <?php echo htmlspecialchars($contact['street']); ?><br>
                            <?php echo htmlspecialchars($contact['campus']); ?><br>
                            <?php echo htmlspecialchars($contact['building']); ?><br>
                            <?php echo htmlspecialchars($contact['city']); ?>, 
                            <?php echo htmlspecialchars($contact['province']); ?><br>
                            <?php echo htmlspecialchars($contact['country']); ?>
                        </p>
                    </div>

                    <!-- Contact Numbers Section -->
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h3>Call Us</h3>
                            <p>Office Number: <br><?php echo htmlspecialchars($contact['primary_number']); ?></p>
                            <p>CSC Number: <br><?php echo htmlspecialchars($contact['secondary_number']); ?></p>
                        </div>

                    <!-- Emails Section -->
                    <!-- Emails Section -->
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h3>Email Us</h3>
                            <p>Office Email: <br>
                                <a href="mailto:<?php echo htmlspecialchars($contact['primary_email']); ?>">
                                    <?php echo htmlspecialchars($contact['primary_email']); ?>
                                </a>
                            </p>
                            <p>CSC Email: <br>
                                <a href="mailto:<?php echo htmlspecialchars($contact['alternative_email']); ?>">
                                    <?php echo htmlspecialchars($contact['alternative_email']); ?>
                                </a> (Alternative)
                            </p>
                        </div>

                    <!-- Office Hours Section -->
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Office Hours</h3>
                        <p><?php echo htmlspecialchars($contact['start_day']); ?> to <?php echo htmlspecialchars($contact['end_day']); ?></p>
                        <p><?php echo htmlspecialchars($contact['opening_time']); ?> - <?php echo htmlspecialchars($contact['closing_time']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No contact information available at the moment.</p>
            <?php endif; ?>
        </div>

        <div class="contact-form-container">
            <div class="form-header">
                <h2>Send us a Message</h2>
                <p>Fill out the form below and we'll get back to you as soon as possible.</p>
                <?php if (!empty($successMessage)): ?>
                    <p class="success"><?php echo $successMessage; ?></p>
                <?php elseif (!empty($errorMessage)): ?>
                    <p class="error"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
            </div>
            
            <form id="contactForm" class="contact-form" action="" method="post">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Enter your message" rows="6" required></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="submit-btn">Send Message</button>
                </div>
            </form>
        </div>
    </div>

   
    <div class="map-container">
        <h2>Find Us on Campus</h2>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1697.6927624041605!2d122.06292035986824!3d6.912627295057878!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x325041e776ae8bd1%3A0xddec6d32d10c14fa!2sInstitute%20of%20Computer%20Studies!5e0!3m2!1sen!2sph!4v1741517195040!5m2!1sen!2sph" 
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <?php include_once 'faqs.php'; ?>

    <?php include_once 'inputFeedback.php'; ?>

    
     

<script>
document.querySelector('#contactForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    fetch('', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        const parser = new DOMParser();
        const htmlDoc = parser.parseFromString(data, "text/html");
        const successMessage = htmlDoc.querySelector(".success");
        const errorMessage = htmlDoc.querySelector(".error");

        const formHeader = document.querySelector('.form-header');
        if (successMessage) {
            // Hide the form
            form.style.display = 'none';

            // Display success message only
            const statusDiv = document.createElement('div');
            statusDiv.classList.add('form-status-message');
            statusDiv.innerHTML = `
                <p class="success">${successMessage.textContent}</p>
            `;
            formHeader.appendChild(statusDiv);
        } else if (errorMessage) {
            alert(errorMessage.textContent);
        }
    })
    .catch(() => {
        alert('An error occurred while submitting the form. Please try again.');
    });
});

</script>

<!-- Bootstrap JS (required for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php include_once '../../includes/footer.php'; ?>






