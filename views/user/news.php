<?php
include_once '../../includes/header.php';
require_once '../../classes/newsClass.php';

// Fix: Use the correct class name
$news = new NewsClass();
$newsList = $news->fetchNewsByAdmin();
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>css/news.css">

<div class="announcement-banner">
    <div class="announcement-label">Announcement</div>
    <div class="announcement-content">
        <div class="announcement-text">
            <a href="<?php echo $base_url; ?>views/user/announcements.php" class="announcement-link">Part Time Offer for Computing Studies Students</a>
        </div>
        <div class="nav-arrows">
            <div class="nav-arrow">&#10094;</div>
            <div class="nav-arrow">&#10095;</div>
        </div>
    </div>
</div>
    
<p class="h">University News</p>

<div class="search-bar">
    <input type="text" placeholder="Search for news...">
    <button type="submit">Search</button>
</div>

<div class="card-container">
    <?php if (!empty($newsList)): ?>
        <?php foreach ($newsList as $newsItem): ?>
            <div class="card">
                <div class="card-image">
                    <img src="<?php echo $base_url; ?>assets/images/<?php echo htmlspecialchars($newsItem['image']); ?>" alt="News Image">
                    <div class="tag">Latest</div>
                </div>
                <div class="content">
                    <div>
                        <div class="date"><?php echo htmlspecialchars($newsItem['news_date']); ?></div>
                        <div class="title"><?php echo htmlspecialchars($newsItem['news_title']); ?></div>
                        <div class="description">
                            <?php echo nl2br(htmlspecialchars(substr($newsItem['news_description'], 0, 150))) . '...'; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo $base_url; ?>views/user/news-detail.php?id=<?php echo $newsItem['news_id']; ?>" class="read-more">Read More</a>
                        <div class="author">Author: <?php echo htmlspecialchars($newsItem['author']); ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No news available.</p>
    <?php endif; ?>
</div>

<?php
include_once '../../includes/footer.php';
?>
