<?php
include_once '../../includes/header.php';
require_once '../../classes/AboutClass.php';

$aboutClass = new AboutClass();
$aboutInfo = $aboutClass->fetchLandingPageInfo();
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>css/landing_page.css">
<link rel="stylesheet" href="<?php echo $base_url; ?>css/studentVolunteer.css">

<section class="hero fullscreen">
    <div class="hero-image">
        <!-- Dynamic background image (optional) -->
    </div>
</section>

<section class="card-section">
    <div class="container">
        <div class="card-container">

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Join Us</h3>
                <p>Join us for our upcoming community events and activities.</p>
                <a href="<?php echo $base_url; ?>views/user/studentVolunteer.php" class="card-btn">Join Now</a>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Contact Us</h3>
                <p>Have questions or need assistance? Reach out to us anytime.</p>
                <a href="<?php echo $base_url; ?>views/user/contact.php" class="card-btn">Get in Touch</a>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Rate Us</h3>
                <p>We value your feedback! Share your experience and help us improve.</p>
                <a href="<?php echo $base_url; ?>views/user/inputFeedback.php" class="card-btn">Rate Now</a>
            </div>
        </div>
    </div>
</section>

<div class="about_phicss">
    <section class="mission-vision">
        <div class="container">
            <div class="mv-container">

                <div class="mission">
                    <h2>Our Mission</h2>
                    <p><?php echo htmlspecialchars($aboutInfo['mission']); ?></p>
                </div>

                <div class="vision">
                    <h2>Our Vision</h2>
                    <p><?php echo htmlspecialchars($aboutInfo['vision']); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-overview">
        <div class="container">
            <div class="about-container">
                <div class="about-text">
                    <h2>About PhiCCS</h2>
                    <p><?php echo htmlspecialchars($aboutInfo['description']); ?></p>
                    <a href="<?php echo $base_url; ?>views/user/about.php" class="about-btn">Read More</a>
                </div>
                <div class="about-image">
                    <?php if (!empty($aboutInfo['phicss_image'])): ?>
                        <img src="<?php echo $base_url; ?>assets/images/<?php echo htmlspecialchars($aboutInfo['phicss_image']); ?>" alt="PhiCCS Logo">
                    <?php else: ?>
                        <img src="<?php echo $base_url; ?>assets/images/default.png" alt="Default Logo">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="volunteer-section">
    <div class="container volunteer-container">
        <div class="volunteer-text">
            <h2 class="volunteer-title">Empower Communities, Enrich Lives</h2>
            <p class="volunteer-description">
                Become a catalyst for positive change. Whether you're lending your time, talent, or voice, your involvement plays a pivotal role in building a better tomorrow. Step forward and make a lasting difference in the lives of others—and your own.
            </p>

            <div class="volunteer-cta">
                <a href="<?php echo $base_url; ?>views/user/studentVolunteer.php" class="volunteer-btn">Become a Volunteer</a>
            </div>
        </div>

        <div class="volunteer-image">
            <img src="<?php echo $base_url; ?>assets/images/volunteer.png" alt="Volunteering Illustration">
        </div>
    </div>
</section>

<section class="team-section">
    <div class="container">
        <h2 class="section-title">Our Team</h2>
        <div class="carousel-container">
            <div class="carousel">

                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/saad.jpg" alt="President">
                    </div>
                    <h3>John Doe</h3>
                    <p class="position">President</p>
                </div>

                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/lak.jpg" alt="Vice President">
                    </div>
                    <h3>Jane Smith</h3>
                    <p class="position">Vice President</p>
                </div>

                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/Reymard.jpg" alt="Secretary">
                    </div>
                    <h3>Robert Johnson</h3>
                    <p class="position">Secretary</p>
                </div>

                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/jc.jpg" alt="Treasurer">
                    </div>
                    <h3>Emily Williams</h3>
                    <p class="position">Treasurer</p>
                </div>

                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/shud.jpg" alt="Event Coordinator">
                    </div>
                    <h3>Michael Brown</h3>
                    <p class="position">Event Coordinator</p>
                </div>
            </div>

            <div class="carousel-nav">
                <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
                <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo $base_url; ?>js/carousel.js"></script>

<?php
include_once '../../includes/footer.php';
?>