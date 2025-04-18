<?php
session_start();
include_once '../../includes/auth_check.php';
require '../../classes/newsClass.php'; 

$newsClass = new NewsClass();
$newsList = $newsClass->fetchNewsByAdmin();

// Handle "Mark as Latest" requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news_id'], $_POST['is_latest'])) {
    $news_id = intval($_POST['news_id']);
    $is_latest = filter_var($_POST['is_latest'], FILTER_VALIDATE_BOOLEAN);

    $result = $newsClass->updateIsLatest($news_id, $is_latest);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Management | Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <link rel="stylesheet" href="../../css/admin_news.css">
</head>
<body>
<div class="admin-container">
    <?php include '../../includes/admin_sidebar.php'; ?>

    <div class="content">
        <div class="page-header">
            <h1>News Management</h1>
            <p>Create, edit and manage news articles for your website</p>
        </div>

        <div class="search-and-button-container">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="newsSearchInput" placeholder="Search by title, author or content..." autocomplete="off">
                <button id="newsSearchBtn"><i class="fas fa-search"></i> Search</button>
            </div>
            <button class="add-report-btn" id="addNewsButton"><i class="fas fa-plus"></i> Add News</button>
        </div>

        <?php if (!empty($newsList)): ?>
            <div class="news-container">
                <?php foreach ($newsList as $news): ?>
                    <div class="news-card">
                        <div class="news-image">
                            <?php
                            // Define default image path
                            $defaultImage = '../../assets/images/default.png';
                            
                            // Try to get the news image
                            $imagePath = '../../assets/images/' . htmlspecialchars($news['image']);
                            
                            // Check if image is a URL or doesn't exist
                            $imageSrc = (!file_exists($imagePath) || filter_var($news['image'], FILTER_VALIDATE_URL) || strpos($news['image'], 'http') === 0)
                                ? $defaultImage
                                : $imagePath;
                            ?>
                            <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($news['news_title']); ?>" onerror="this.src='<?php echo $defaultImage; ?>'">
                        </div>
                        <div class="news-content">
                            <h5 class="category">Category: <?php echo htmlspecialchars($news['category']); ?></h5>
                            <p class="news-date"><?php echo date('M d, Y', strtotime($news['news_date'])); ?></p>
                            <h2 class="news-title"><?php echo htmlspecialchars($news['news_title']); ?></h2>
                            <p class="news-description"><?php echo nl2br(htmlspecialchars(substr($news['news_description'], 0, 150))) . (strlen($news['news_description']) > 150 ? '...' : ''); ?></p>
                            <p class="news-author">Author: <?php echo htmlspecialchars($news['author']); ?></p>
                        </div>
                        <div class="action-icons">
                            <button type="button" class="edit-btn btn" data-id="<?php echo $news['news_id']; ?>" title="Edit Article" onclick="editNews(<?php echo $news['news_id']; ?>)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="delete-btn btn" data-id="<?php echo $news['news_id']; ?>" title="Delete Article" onclick="deleteNews(<?php echo $news['news_id']; ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <div class="toggle-latest">
                            <label for="is_latest_<?php echo $news['news_id']; ?>">Mark as Latest:</label>
                            <input type="checkbox" id="is_latest_<?php echo $news['news_id']; ?>"
                                onchange="toggleIsLatest(<?php echo $news['news_id']; ?>, this.checked)"
                                <?php echo isset($news['is_latest']) && $news['is_latest'] ? 'checked' : ''; ?>>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No news articles found. Click the "Add News" button to create your first article.
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="../../js/news.js"></script>
<script>
// Function to toggle "Mark as Latest"
function toggleIsLatest(newsId, isLatest) {
    console.log("Toggle 'Mark as Latest' for News ID:", newsId);

    // Show loading indicator on the checkbox
    var checkbox = document.querySelector(`#is_latest_${newsId}`);
    checkbox.disabled = true;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo basename(__FILE__); ?>', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                var result = JSON.parse(xhr.responseText);
                if (result.status === 'success') {
                    alert(result.message);
                } else {
                    alert("Error: " + result.message);
                    checkbox.checked = !isLatest; // Revert checkbox
                }
            } catch (e) {
                alert("Invalid server response.");
                console.error(e, xhr.responseText);
                checkbox.checked = !isLatest; // Revert checkbox
            }
        } else {
            alert("Server error: " + xhr.status);
            checkbox.checked = !isLatest; // Revert checkbox
        }
        checkbox.disabled = false;
    };

    xhr.onerror = function () {
        alert("Network error. Please try again later.");
        checkbox.checked = !isLatest; // Revert checkbox
        checkbox.disabled = false;
    };

    xhr.send('news_id=' + newsId + '&is_latest=' + isLatest);
}
</script>
</body>
</html>
