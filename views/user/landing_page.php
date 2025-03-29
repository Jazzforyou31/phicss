<?php
include_once '../../includes/header.php';
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>css/landing_page.css">

<section class="hero fullscreen">
    <div class="hero-image">
    
    </div>
</section>

<section class="card-section">
    <div class="container">
        <div class="card-container">
          
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Events</h3>
                <p>Join us for our upcoming community events and activities.</p>
                <a href="<?php echo $base_url; ?>views/user/events.php" class="card-btn">View Events</a>
            </div>
            
        
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>News</h3>
                <p>Stay updated with the latest news and announcements.</p>
                <a href="<?php echo $base_url; ?>views/user/news.php" class="card-btn">Read News</a>
            </div>
            
        
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3>Resources</h3>
                <p>Access valuable resources and materials from our library.</p>
                <a href="<?php echo $base_url; ?>views/user/resources.php" class="card-btn">Browse Resources</a>
            </div>
        </div>
    </div>
</section>


<section class="mission-vision">
    <div class="container">
        <div class="mv-container">
          
            <div class="mission">
                <h2>Our Mission</h2>
                <p>To foster a vibrant community through innovative programs, quality services, and dedicated support that enhances the lives of all members.</p>
            </div>
            
          
            <div class="vision">
                <h2>Our Vision</h2>
                <p>To become a leading organization known for excellence in community development, creating sustainable impact and meaningful connections across diverse groups.</p>
            </div>
        </div>
    </div>
</section>


<section class="about-overview">
    <div class="container">
        <div class="about-container">
            <div class="about-text">
                <h2>About PhiCCS</h2>
                <p>PhiCCS is a community-driven organization dedicated to providing valuable resources, engaging events, and quality services to our members and the broader community.</p>
                <p>Founded in 2020, we've been working tirelessly to create meaningful connections and foster growth opportunities for individuals from all backgrounds.</p>
                <a href="<?php echo $base_url; ?>views/user/about.php" class="about-btn">Read More</a>
            </div>
            <div class="about-image">
                <img src="<?php echo $base_url; ?>assets/images/LOGOCIRCLEVER2.png" alt="About Us">
            </div>
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
                        <img src="<?php echo $base_url; ?>assets/images/saad.jpg" alt="Team Member">
                    </div>
                    <h3>John Doe</h3>
                    <p class="position">President</p>
                </div>
                
                
                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/lak.jpg" alt="Team Member">
                    </div>
                    <h3>Jane Smith</h3>
                    <p class="position">Vice President</p>
                </div>
                
               
                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/Reymard.jpg" alt="Team Member">
                    </div>
                    <h3>Robert Johnson</h3>
                    <p class="position">Secretary</p>
                </div>
                
              
                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/jc.jpg" alt="Team Member">
                    </div>
                    <h3>Emily Williams</h3>
                    <p class="position">Treasurer</p>
                </div>
                
              
                <div class="team-member">
                    <div class="member-image">
                        <img src="<?php echo $base_url; ?>assets/images/shud.jpg" alt="Team Member">
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
