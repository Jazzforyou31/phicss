<?php
include_once '../../includes/header.php';
require_once '../../classes/AboutClass.php';

$aboutClass = new AboutClass();
$aboutInfo = $aboutClass->fetchAboutInfo(); // Fetch mission, vision, description, and phicss_image dynamically
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>css/about.css">

<section class="hero about-hero">
    <div class="hero-image">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>About Phiccs</h1>
        </div>
    </div>
</section>

<section class="about-description">
    <div class="container">
        <div class="about-content">
            <h2>About Us</h2>
            <p><?php echo htmlspecialchars($aboutInfo['description']); ?></p>
        </div>
    </div>
</section>

<section class="mission-vision-section">
    <div class="container">
        <div class="mv-container">
            <div class="mv-image">
                <?php if (!empty($aboutInfo['phicss_image'])): ?>
                    <img src="<?php echo $base_url; ?>assets/images/<?php echo htmlspecialchars($aboutInfo['phicss_image']); ?>" alt="Phiccs Logo">
                <?php else: ?>
                    <img src="<?php echo $base_url; ?>assets/images/default.png" alt="Default Logo">
                <?php endif; ?>
            </div>
            <div class="mv-content">
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
    </div>
</section>

<section class="officers-section">
    <div class="container">
        <h2 class="section-title">Executive Officers</h2>
        
        <div class="officers-grid">
           
            <div class="officer-card">
                <div class="officer-image">
                    <img src="<?php echo $base_url; ?>assets/images/saad.jpg" alt="President">
                </div>
                <div class="officer-info">
                    <h3>Sa'ad Bin Ain Jandul</h3>
                    <p class="position">President</p>
                    <p class="bio">Leading with vision and dedication to guide Phiccs towards excellence and innovation.</p>
                </div>
            </div>
            
            
            <div class="officer-card">
                <div class="officer-image">
                    <img src="<?php echo $base_url; ?>assets/images/brex.jpg" alt="Vice President">
                </div>
                <div class="officer-info">
                    <h3>Brixell Mesa</h3>
                    <p class="position">Vice President</p>
                    <p class="bio">Supporting the president and overseeing operational initiatives with strategic insight.</p>
                </div>
            </div>
            
            
            <div class="officer-card">
                <div class="officer-image">
                    <img src="<?php echo $base_url; ?>assets/images/Reymard.jpg" alt="Secretary">
                </div>
                <div class="officer-info">
                    <h3>Reymard Bengil</h3>
                    <p class="position">Secretary</p>
                    <p class="bio">Managing communications and documentation with precision and attention to detail.</p>
                </div>
            </div>
            
            
            <div class="officer-card">
                <div class="officer-image">
                    <img src="<?php echo $base_url; ?>assets/images/shud.jpg" alt="Treasurer">
                </div>
                <div class="officer-info">
                    <h3>AlMashud Jumli</h3>
                    <p class="position">Treasurer</p>
                    <p class="bio">Handling financial matters with expertise to ensure the organization's fiscal health.</p>
                </div>
            </div>
            
            
            <div class="officer-card">
                <div class="officer-image">
                    <img src="<?php echo $base_url; ?>assets/images/jc.jpg" alt="PR Officer">
                </div>
                <div class="officer-info">
                    <h3>John Carlo Bautista</h3>
                    <p class="position">Public Relations Officer</p>
                    <p class="bio">Building relationships and promoting Phiccs with creativity and strategic communication.</p>
                </div>
            </div>

             
            <div class="officer-card">
                <div class="officer-image">
                    <img src="<?php echo $base_url; ?>assets/images/lak.jpg" alt="Treasurer">
                </div>
                <div class="officer-info">
                    <h3>Julhadz Jinno</h3>
                    <p class="position">Public Information Officer (PIO)</p>
                    <p class="bio">Communicating with clarity and transparency to keep the public informed and enhance the organization's image.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
include_once '../../includes/footer.php';
?>