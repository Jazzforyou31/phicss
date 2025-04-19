<?php
require_once '../../classes/newsClass.php';

// Fetch news titles using the NewsClass
$news = new NewsClass();
$newsTitles = $news->fetchAllNewsTitles();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcement Banner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* General Styling */
    .announcement-banner {
        display: flex;
        align-items: center;
        background-color: #f3f4f6;
        padding: 3px 5px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        height: 40px;
    }

    .announcement-label {
        font-weight: bold;
        color:rgb(255, 255, 255);
        padding: 5px 10px;
        margin-right: 15px;
        border-radius: 5px;
    }

    .announcement-content {
        flex: 1;
        overflow: hidden;
        position: relative;
    }

    .announcement-text-wrapper {
        width: 350px;
        height: 20px;
        overflow: hidden;
        position: relative;
    }

    .announcement-text {
        position: absolute;
        white-space: nowrap;
        animation: scrollText 10s linear infinite;
    }

    .announcement-link {
        color: #2563eb;
        text-decoration: none;
    }

    .announcement-link:hover {
        text-decoration: underline;
    }

    .announcement-arrows {
        display: flex;
        gap: 10px;
        margin-left: 15px;
        position: relative;
    }

    .announcement-arrows i {
        font-size: 15px; /* Increased font size for thicker appearance */
        font-weight: 900; /* Adds a sense of thickness */
        color: #2563eb; /* Arrow color */
        cursor: pointer; /* Pointer cursor for interaction */
        transition: color 0.3s; /* Smooth hover effect */
    }

    .announcement-arrows i:hover {
        color: #1d4ed8; /* Slightly darker blue on hover */
    }

    @keyframes scrollText {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }
  </style>
</head>
<body>
  <!-- Announcement Banner -->
  <div class="announcement-banner">
    <div class="announcement-label">Announcement</div>
    <div class="announcement-content">
      <div class="announcement-text-wrapper">
        <div class="announcement-text" id="announcementText">
          <?php if (!empty($newsTitles)): ?>
            <a href="<?php echo $base_url; ?>views/user/news-detail.php?id=<?php echo $newsTitles[0]['news_id']; ?>" class="announcement-link">
              <?php echo htmlspecialchars($newsTitles[0]['news_title']); ?>
            </a>
          <?php else: ?>
            <p>No announcements available at the moment.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="announcement-arrows">
      <i id="prevAnnouncement" class="fas fa-chevron-left"></i>
      <i id="nextAnnouncement" class="fas fa-chevron-right"></i>
    </div>
  </div>

  <script>
    const newsTitles = <?php echo json_encode($newsTitles); ?>;
    let currentIndex = 0;

    const announcementText = document.getElementById('announcementText');
    const prevButton = document.getElementById('prevAnnouncement');
    const nextButton = document.getElementById('nextAnnouncement');

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

    function slideToNext() {
        currentIndex = (currentIndex + 1) % newsTitles.length;
        updateAnnouncementText();
    }

    function slideToPrevious() {
        currentIndex = (currentIndex - 1 + newsTitles.length) % newsTitles.length;
        updateAnnouncementText();
    }

    // Event listeners for arrows
    nextButton.addEventListener('click', slideToNext);
    prevButton.addEventListener('click', slideToPrevious);

    // Auto-scroll every 10 seconds
    if (newsTitles.length > 1) {
        setInterval(slideToNext, 10000);
    }

    updateAnnouncementText();
  </script>
</body>
</html>