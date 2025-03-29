<?php
include_once '../../includes/header.php';
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>css/contact.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="contact-page">
    <div class="contact-hero">
        <h1>Get in Touch</h1>
        <p>We'd love to hear from you. Feel free to reach out with any questions or inquiries.</p>
    </div>

    <div class="contact-container">
        <div class="contact-info">
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Visit Us</h3>
                <p>123 University Avenue</p>
                <p>Computing Department</p>
                <p>Campus Building B, Floor 3</p>
                <p>Manila, Philippines</p>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>Call Us</h3>
                <p>Main Office: +63 2 8123 4567</p>
                <p>Student Affairs: +63 2 8123 4568</p>
                <p>Mon-Fri: 8:00 AM - 5:00 PM</p>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email Us</h3>
                <p>General Inquiries:</p>
                <p><a href="mailto:info@computing.edu.ph">info@computing.edu.ph</a></p>
                <p>Admissions:</p>
                <p><a href="mailto:admissions@computing.edu.ph">admissions@computing.edu.ph</a></p>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Office Hours</h3>
                <p>Monday to Friday:</p>
                <p>8:00 AM - 5:00 PM</p>
                <p>Weekends & Holidays:</p>
                <p>Closed</p>
            </div>
        </div>
        
        <div class="contact-form-container">
            <div class="form-header">
                <h2>Send us a Message</h2>
                <p>Fill out the form below and we'll get back to you as soon as possible.</p>
            </div>
            
            <form id="contactForm" class="contact-form" action="#" method="post">
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
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject" required>
                        <option value="" disabled selected>Select a subject</option>
                        <option value="General Inquiry">General Inquiry</option>
                        <option value="Admissions">Admissions</option>
                        <option value="Academic Programs">Academic Programs</option>
                        <option value="Student Services">Student Services</option>
                        <option value="Technical Support">Technical Support</option>
                        <option value="Other">Other</option>
                    </select>
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

    <div class="faq-section">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">How can I apply to the Computing Department?</div>
                <div class="faq-answer">
                    <p>To apply to our programs, visit the Admissions section of our website or contact our admissions office directly at admissions@computing.edu.ph. We offer various undergraduate and graduate programs in Computer Science, Information Technology, and related fields.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">What are your admission requirements?</div>
                <div class="faq-answer">
                    <p>Admission requirements vary by program. Generally, you need to submit academic transcripts, recommendation letters, and complete an entrance examination. For detailed requirements, please visit our Admissions page or contact our admissions office.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Are there scholarships available?</div>
                <div class="faq-answer">
                    <p>Yes, we offer various merit-based and need-based scholarships. The Computing Department also has specific scholarships for outstanding students in computer science and related fields. Application deadlines typically fall on March 31 and October 31 each year.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">How can I schedule a campus tour?</div>
                <div class="faq-answer">
                    <p>Campus tours are available Monday through Friday, 9:00 AM to 3:00 PM. To schedule a tour, please contact our office at least 3 days in advance by email or phone. Virtual tours are also available upon request.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $base_url; ?>js/contact.js"></script>

<?php
include_once '../../includes/footer.php';
?> 