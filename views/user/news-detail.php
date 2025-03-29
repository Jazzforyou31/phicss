<?php
include_once '../../includes/header.php';
require_once '../../classes/newsClass.php';

// Check if news_id is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to news page if no ID is provided
    header("Location: {$base_url}views/user/news.php");
    exit;
}

// Get news ID from URL
$newsId = intval($_GET['id']);

// Fetch news details
$newsClass = new NewsClass();
$newsItem = $newsClass->getNewsById($newsId);

// If news not found, redirect to news page
if (!$newsItem) {
    header("Location: {$base_url}views/user/news.php");
    exit;
}

// Format the date
$formattedDate = date('F d, Y', strtotime($newsItem['news_date']));

// Define default image path
$defaultImage = $base_url . 'assets/images/default.png';

// Try to get the news image
$imagePath = $base_url . 'assets/images/' . htmlspecialchars($newsItem['image']);
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>css/news-detail.css">

<div class="container news-detail-container">
    <div class="breadcrumb">
        <a href="<?php echo $base_url; ?>">Home</a> &gt; 
        <a href="<?php echo $base_url; ?>views/user/news.php">News</a> &gt; 
        <span><?php echo htmlspecialchars($newsItem['news_title']); ?></span>
    </div>

    <article class="news-article">
        <header>
            <h1 class="news-title"><?php echo htmlspecialchars($newsItem['news_title']); ?></h1>
            
            <div class="news-meta">
                <span class="news-date"><i class="fas fa-calendar-alt"></i> <?php echo $formattedDate; ?></span>
                <span class="news-author"><i class="fas fa-user"></i> <?php echo htmlspecialchars($newsItem['author']); ?></span>
            </div>
        </header>

        <div class="news-featured-image">
            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($newsItem['news_title']); ?>" onerror="this.src='<?php echo $defaultImage; ?>'">
        </div>

        <div class="news-content">
            <?php if (!empty($newsItem['message'])): ?>
            <div class="news-message">
                <blockquote>
                    <?php echo nl2br(htmlspecialchars($newsItem['message'])); ?>
                </blockquote>
            </div>
            <?php endif; ?>

            <div class="news-description">
                <?php echo nl2br(htmlspecialchars($newsItem['news_description'])); ?>
            </div>
        </div>

        <footer class="news-footer">
            <div class="news-navigation">
                <a href="<?php echo $base_url; ?>views/user/news.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to News
                </a>
                
                <div class="news-share">
                    <span>Share:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($newsItem['news_title']); ?>" target="_blank" class="share-btn twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="mailto:?subject=<?php echo urlencode($newsItem['news_title']); ?>&body=<?php echo urlencode('Check out this news: ' . $_SERVER['REQUEST_URI']); ?>" class="share-btn email">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </footer>
    </article>

    <div class="related-news">
        <h3>Related News</h3>
        <div class="related-news-container">
            <?php 
            // Fetch related news (excluding current news)
            $relatedNews = $newsClass->fetchNewsByAdmin();
            $count = 0;
            
            foreach ($relatedNews as $related) {
                // Skip current news and limit to 3 items
                if ($related['news_id'] == $newsId || $count >= 3) continue;
                
                // Format related news date
                $relatedDate = date('M d, Y', strtotime($related['news_date']));
                
                // Get related news image
                $relatedImagePath = $base_url . 'assets/images/' . htmlspecialchars($related['image']);
            ?>
            <div class="related-news-item">
                <div class="related-news-image">
                    <img src="<?php echo $relatedImagePath; ?>" alt="<?php echo htmlspecialchars($related['news_title']); ?>" onerror="this.src='<?php echo $defaultImage; ?>'">
                </div>
                <div class="related-news-content">
                    <div class="related-news-date"><?php echo $relatedDate; ?></div>
                    <h4 class="related-news-title">
                        <a href="<?php echo $base_url; ?>views/user/news-detail.php?id=<?php echo $related['news_id']; ?>">
                            <?php echo htmlspecialchars($related['news_title']); ?>
                        </a>
                    </h4>
                </div>
            </div>
            <?php 
                $count++;
            } 
            ?>
        </div>
    </div>
</div>

<?php
include_once '../../includes/footer.php';
?> 