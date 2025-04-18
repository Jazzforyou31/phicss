<?php
require_once '../../classes/newsClass.php';

$news = new NewsClass();
$newsTitles = $news->fetchAllNewsTitles(); // Get news ID and titles
?>

<!-- Announcement Banner -->
<div class="announcement-banner">
    <div class="announcement-label">Announcement</div>
    <div class="announcement-content">
        <div class="announcement-text" id="announcementText">
            <?php if (!empty($newsTitles)): ?>
                <a href="<?php echo $base_url; ?>views/user/news-detail.php?id=<?php echo $newsTitles[0]['news_id']; ?>" class="announcement-link">
                    <?php echo htmlspecialchars($newsTitles[0]['news_title']); ?>
                </a>
            <?php else: ?>
                <p>No announcements available at the moment.</p>
            <?php endif; ?>
        </div>
        <div class="nav-arrows">
            <div class="nav-arrow" id="prevArrow">&#10094;</div>
            <div class="nav-arrow" id="nextArrow">&#10095;</div>
        </div>
    </div>
</div>

<script>
    const newsTitles = <?php echo json_encode($newsTitles); ?>;
    let currentIndex = 0;

    const announcementText = document.getElementById('announcementText');
    const prevArrow = document.getElementById('prevArrow');
    const nextArrow = document.getElementById('nextArrow');

    function updateAnnouncementText() {
        if (newsTitles.length > 0) {
            const newsId = newsTitles[currentIndex].news_id;
            const newsTitle = newsTitles[currentIndex].news_title;

            announcementText.innerHTML = `
                <a href="<?php echo $base_url; ?>views/user/news-detail.php?id=${newsId}" class="announcement-link">
                    ${newsTitle}
                </a>
            `;
        }
    }

    prevArrow?.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + newsTitles.length) % newsTitles.length;
        updateAnnouncementText();
    });

    nextArrow?.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % newsTitles.length;
        updateAnnouncementText();
    });

    if (newsTitles.length > 1) {
        setInterval(() => {
            currentIndex = (currentIndex + 1) % newsTitles.length;
            updateAnnouncementText();
        }, 5000);
    }

    updateAnnouncementText();
</script>