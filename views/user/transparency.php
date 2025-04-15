<?php
include_once '../../includes/header.php';
require_once '../../classes/TransparencyClass.php'; // Include the TransparencyClass

$transparency = new TransparencyClass();
$sections = $transparency->fetchSections();
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>css/transparency.css">

<body>
    <h1>Transparency Page <span class="fy-year"><a href="#">| S.Y 2025-2026</a></span></h1>

    <div class="sidebar">
        <p><a href="#">See also:</a></p>
        <p>Transparency Page <br>
        <a href="#">2023-2024</a><br><a href="#">2024-2025</a><br><a href="#">2025-2026</a></p>
    </div>

    <div class="logo">
        <img src="<?php echo $base_url; ?>assets/images/OfficialLogoVer2.png" alt="Organization logo">
    </div>

    <hr>

    <div class="content">
        <?php if (!empty($sections)) : ?>
            <?php 
            $sectionNumber = 1; // Initialize section number
            foreach ($sections as $section) : ?>
                <div class="section">
                    <p class="section-title"><?php echo $sectionNumber . ". " . htmlspecialchars($section['section_title']); ?></p>
                    <ul>
                        <?php 
                        $links = $transparency->fetchLinksBySection($section['id']); 
                        if (!empty($links)) :
                            foreach ($links as $link) : ?>
                                <li><a href="<?php echo htmlspecialchars($link['document_link']); ?>" target="_blank">
                                    <?php echo htmlspecialchars($link['document_title']); ?>
                                </a></li>
                            <?php endforeach;
                        else: ?>
                            <li>No documents available.</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php $sectionNumber++; // Increment section number ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No transparency data available.</p>
        <?php endif; ?>
    </div>
</body>

<?php include_once '../../includes/footer.php'; ?>
