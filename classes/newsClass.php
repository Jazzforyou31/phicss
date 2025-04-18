<?php
require_once 'databaseClass.php';

class NewsClass {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    /**
     * Fetch news added by admin
     * 
     * This function retrieves all news entries from the database.
     * The previous version filtered by admin role, but now it will show all news.
     */
    public function fetchNewsByAdmin() {
        try {
            $query = "
                SELECT 
                    n.news_id, 
                    n.news_title, 
                    n.news_description, 
                    n.message, 
                    n.category,
                    n.image, 
                    n.news_date, 
                    n.created_at, 
                    n.author,
                    n.is_latest
                FROM 
                    news n
                ORDER BY 
                    n.created_at DESC
            ";

            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Error fetching news: " . $exception->getMessage());
            return [];
        }
    }

    /**
     * Add news entry (Optional helper if needed later)
     */
    public function addNews($title, $description, $message, $category, $image, $newsDate, $author, $createdBy, $isLatest) {
        try {
            // Sanitize image path - ensure it's a valid local file
            $image = $this->validateImagePath($image);
            
            $query = "
                INSERT INTO news (news_title, news_description, message, category, image, news_date, created_at, created_by, author, is_latest)
                VALUES (:news_title, :news_description, :message, :category, :image, :news_date, NOW(), :created_by, :author, :is_latest)
            ";
            
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':news_title', $title);
            $statement->bindParam(':news_description', $description);
            $statement->bindParam(':message', $message);
            $statement->bindParam(':category', $category);
            $statement->bindParam(':image', $image);
            $statement->bindParam(':news_date', $newsDate);
            $statement->bindParam(':created_by', $createdBy);
            $statement->bindParam(':author', $author);
            $statement->bindParam(':is_latest', $isLatest, PDO::PARAM_BOOL); // Assuming is_latest is a boolean
            
            return $statement->execute();
        } catch (PDOException $exception) {
            error_log("Error adding news: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * Validate image path to ensure it's not a URL or invalid path
     */
    private function validateImagePath($imagePath) {
        // If it's a URL or an invalid path, use default image
        if (filter_var($imagePath, FILTER_VALIDATE_URL) || 
            strpos($imagePath, '://') !== false || 
            strpos($imagePath, 'http') === 0) {
            return 'default.png';
        }
        
        // Check if the image exists in the assets directory
        $fullPath = dirname(dirname(__FILE__)) . '/assets/images/' . $imagePath;
        if (!file_exists($fullPath) && $imagePath != 'default.png') {
            return 'default.png';
        }
        
        return $imagePath;
    }

    public function getNewsById($newsId) {
        $sql = "SELECT * FROM news WHERE news_id = :news_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':news_id', $newsId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteNewsById($newsId) {
        $query = "DELETE FROM news WHERE news_id = :news_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':news_id', $newsId, PDO::PARAM_INT);

        return $stmt->execute(); // Will return true if successful, false otherwise
    }

    public function updateNewsById($newsId, $title, $description, $message, $category, $image, $date, $author) {
        try {
            // Sanitize image path if provided
            if ($image) {
                $image = $this->validateImagePath($image);
            }
            
            // If no image specified, keep the existing one
            if (empty($image)) {
                $existingNews = $this->getNewsById($newsId);
                $image = $existingNews['image'] ?? 'default.png';
            }
            
            $query = "UPDATE news SET 
                news_title = :news_title, 
                news_description = :news_description, 
                message = :message, 
                category = :category,
                news_date = :news_date, 
                author = :author, 
                image = :image 
                WHERE news_id = :news_id";
                
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':news_id', $newsId, PDO::PARAM_INT);
            $stmt->bindParam(':news_title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':news_description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':news_date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':author', $author, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);

            return $stmt->execute(); // Return whether the update was successful
        } catch (PDOException $exception) {
            error_log("Error updating news: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * Search news by title, description, or author
     * 
     * @param string $searchTerm The search term to look for
     * @return array Array of news articles matching the search
     */
    public function searchNews($searchTerm = '') {
        try {
            // If no search term, return all news
            if (empty($searchTerm)) {
                return $this->fetchNewsByAdmin();
            }
            
            // Build search query
            $query = "
                SELECT 
                    news_id, 
                    news_title, 
                    news_description, 
                    message, 
                    category,
                    image, 
                    news_date, 
                    created_at, 
                    author 
                FROM 
                    news
                WHERE 
                    news_title LIKE :search OR
                    news_description LIKE :search OR
                    author LIKE :search OR
                    message LIKE :search
                ORDER BY 
                    created_at DESC
            ";

            $statement = $this->connection->prepare($query);
            $searchParam = '%' . $searchTerm . '%';
            $statement->bindParam(':search', $searchParam, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Error searching news: " . $exception->getMessage());
            return [];
        }
    }

    
    public function fetchAllCategories() {
        $query = "SELECT DISTINCT category FROM news";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateIsLatest($newsId, $isLatest) {
        try {
            $sql = "UPDATE news SET is_latest = :isLatest WHERE news_id = :newsId";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':isLatest', $isLatest, PDO::PARAM_BOOL);
            $stmt->bindParam(':newsId', $newsId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating is_latest: " . $e->getMessage());
            return false;
        }
    }

    public function fetchAllNewsTitles() {
        try {
            $sql = "SELECT news_id, news_title FROM news ORDER BY news_date DESC";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching news titles: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalContentItems() {
        $query = "SELECT COUNT(*) AS total_content FROM news";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_content'];
    }
}