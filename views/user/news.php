<?php
include_once '../../includes/header.php';
require_once '../../classes/newsClass.php';

$news = new NewsClass();
$newsList = $news->fetchNewsByAdmin(); // Get all news
$categories = $news->fetchAllCategories(); // Get unique categories

?>

<link rel="stylesheet" href="<?php echo $base_url; ?>css/news.css">

<!-- Announcement Banner -->
<?php include_once 'announcementBanner.php'; ?>

<!-- Category Tabs -->
<div class="category-tabs-wrapper">
    <div class="category-tabs">
        <button class="category-tab" onclick="filterNewsByCategory('all')">All</button>
        <?php foreach ($categories as $category): ?>
            <button class="category-tab" onclick="filterNewsByCategory('<?php echo htmlspecialchars($category['category']); ?>')">
                <?php echo htmlspecialchars($category['category']); ?>
            </button>
        <?php endforeach; ?>
    </div>
</div>

<div class="container">
    <!-- Main Grid -->
    <div class="main-grid">
        <?php if (!empty($newsList)): ?>
            <!-- Left Side Cards -->
            <div class="side-cards">
                <?php foreach (array_slice($newsList, 0, 2) as $newsItem): ?>
                    <div class="card small-card">
                        <img src="<?php echo $base_url; ?>assets/images/<?php echo htmlspecialchars($newsItem['image']); ?>" alt="News Image">
                        <div class="label"><?php echo htmlspecialchars($newsItem['category']); ?></div>
                        <div class="title"><?php echo htmlspecialchars($newsItem['news_title']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Main Card -->
            <?php $mainNews = $newsList[2]; ?>
            <div class="main-card">
                <div class="card large-card">
                    <img src="<?php echo $base_url; ?>assets/images/<?php echo htmlspecialchars($mainNews['image']); ?>" alt="News Image">
                    <div class="label"><?php echo htmlspecialchars($mainNews['category']); ?></div>
                    <div class="title"><?php echo htmlspecialchars($mainNews['news_title']); ?></div>
                    <div class="meta"><?php echo date('M d, Y', strtotime($mainNews['news_date'])); ?> • <?php echo htmlspecialchars($mainNews['author']); ?></div>
                    <a href="<?php echo $base_url; ?>views/user/news-detail.php?id=<?php echo $mainNews['news_id']; ?>" class="card-btn">Read News</a>
                </div>
            </div>

            <!-- Right Side Cards -->
            <div class="side-cards">
                <?php foreach (array_slice($newsList, 3, 2) as $newsItem): ?>
                    <div class="card small-card">
                        <img src="<?php echo $base_url; ?>assets/images/<?php echo htmlspecialchars($newsItem['image']); ?>" alt="News Image">
                        <div class="label"><?php echo htmlspecialchars($newsItem['category']); ?></div>
                        <div class="title"><?php echo htmlspecialchars($newsItem['news_title']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No news available.</p>
        <?php endif; ?>
    </div>

    <!-- Bottom Grid -->
    <div class="bottom-grid">
        <?php if (!empty($newsList)): ?>
            <?php foreach (array_slice($newsList, 3) as $newsItem): ?>
                <div class="card">
                    <img src="<?php echo $base_url; ?>assets/images/<?php echo htmlspecialchars($newsItem['image']); ?>" alt="News Image">
                    <div class="label"><?php echo htmlspecialchars($newsItem['category']); ?></div>
                    <div class="title"><?php echo htmlspecialchars($newsItem['news_title']); ?></div>
                    <div class="meta"><?php echo date('M d, Y', strtotime($newsItem['news_date'])); ?> • <?php echo htmlspecialchars($newsItem['author']); ?></div>
                    <a href="<?php echo $base_url; ?>views/user/news-detail.php?id=<?php echo $newsItem['news_id']; ?>" class="card-btn">Read News</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No news available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- <script>
    // Filter by category
    function filterNewsByCategory(category) {
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            if (category === 'all' || cardCategory === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script> -->

<?php include_once '../../includes/footer.php'; ?>