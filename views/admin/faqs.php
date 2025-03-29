<?php
session_start();
require_once '../../classes/faqsClass.php';

$faqsClass = new FaqsClass();

$categories = $faqsClass->fetchCategories();
$faqs = $faqsClass->fetchFAQs();

if (!is_array($categories) || !is_array($faqs)) {
    die("Error: Data retrieval failed.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin_faqs.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="admin-container">
    <?php include '../../includes/admin_sidebar.php'; ?>
    
    <div class="content">
        <h2 class="page-title">FAQs & Categories</h2>

        <!-- FAQ Categories Section -->
        <div class="faq-categories">
            <h4>Categories</h4>
            <div class="categories-container">
                <?php foreach ($categories as $category): ?>
                    <span class="category-item">
                        <?= htmlspecialchars($category['category']) ?>
                        <button class="remove-category" data-category="<?= $category['category'] ?>">❌</button>
                    </span>
                <?php endforeach; ?>
                <div class="add-category">
                    <input type="text" id="new-category" placeholder="New category">
                    <button id="add-category">+ Add</button>
                </div>
            </div>
        </div>

        <!-- FAQ List Section -->
        <div class="faq-list">
            <h4>FAQs</h4>
            <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <div class="faq-header">
                        <select class="faq-category" data-id="<?= $faq['faq_id'] ?>">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['category'] ?>" <?= ($faq['category'] == $category['category']) ? 'selected' : '' ?>>
                                    <?= $category['category'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="checkbox" class="faq-active" data-id="<?= $faq['faq_id'] ?>" <?= $faq['is_active'] ? 'checked' : '' ?>>
                    </div>
                    <h5><?= htmlspecialchars($faq['question']) ?></h5>
                    <p><?= htmlspecialchars($faq['answer']) ?></p>
                    <!-- <div class="faq-actions">
                        <button class="edit-faq" data-id="<?= $faq['faq_id'] ?>">Edit</button>
                        <button class="delete-faq" data-id="<?= $faq['faq_id'] ?>">Delete</button>
                    </div> -->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="../../js/faqs.js"></script>
</body>
</html>
