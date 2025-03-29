<?php
session_start();
require_once '../../classes/newsClass.php';

// Get search query
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Get news data with search filter
$newsClass = new NewsClass();
$newsList = $newsClass->searchNews($searchQuery);

// Return HTML for news cards
if (!empty($newsList)) {
    foreach ($newsList as $news) {
        // Define default image path
        $defaultImage = '../../assets/images/default.png';
        
        // Try to get the news image
        $imagePath = '../../assets/images/' . htmlspecialchars($news['image']);
        
        // Check if image is a URL or doesn't exist
        if (!file_exists($imagePath) || 
            filter_var($news['image'], FILTER_VALIDATE_URL) || 
            strpos($news['image'], 'http') === 0) {
            $imageSrc = $defaultImage;
        } else {
            $imageSrc = $imagePath;
        }
        ?>
        <div class="news-card">
            <div class="news-image">
                <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($news['news_title']); ?>" onerror="this.src='<?php echo $defaultImage; ?>'">
            </div>
            <div class="news-content">
                <p class="news-date"><?php echo date('M d, Y', strtotime($news['news_date'])); ?></p>
                <h2 class="news-title"><?php echo htmlspecialchars($news['news_title']); ?></h2>
                <p class="news-description"><?php echo nl2br(htmlspecialchars(substr($news['news_description'], 0, 150) . (strlen($news['news_description']) > 150 ? '...' : ''))); ?></p>
                <p class="news-author"><?php echo htmlspecialchars($news['author']); ?></p>
            </div>
            <div class="action-icons">
                <button type="button" class="edit-btn btn" data-id="<?php echo $news['news_id']; ?>" title="Edit Article" onclick="editNews(<?php echo $news['news_id']; ?>)">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button type="button" class="delete-btn btn" data-id="<?php echo $news['news_id']; ?>" title="Delete Article" onclick="deleteNews(<?php echo $news['news_id']; ?>)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div class="alert alert-info">
        <?php if(!empty($searchQuery)): ?>
            <i class="fas fa-info-circle"></i> No news articles found matching "<?php echo htmlspecialchars($searchQuery); ?>". Try a different search term.
        <?php else: ?>
            <i class="fas fa-info-circle"></i> No news articles found. Click the "Add News" button to create your first article.
        <?php endif; ?>
    </div>
    <?php
}
?> 