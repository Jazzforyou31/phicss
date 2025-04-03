<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin_faqs.css">
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="admin-container">
    <?php include '../../includes/admin_sidebar.php'; ?>
    
    <div class="content">
        <div class="page-header">
            <h1>FAQs Management</h1>
            <p>Manage Frequently Asked Questions</p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search FAQs..." id="searchBar">
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="addFaqBtn"><i class="fas fa-plus"></i> Add FAQ</button>
        </div>

        <!-- FAQ Categories Section -->
        <div class="card p-3 mb-3">
            <h5>Categories</h5>
            <div id="categoryChips" class="d-flex flex-wrap gap-2">
                <span class="badge bg-primary category-chip">General <button class="btn-close btn-close-white remove-category" data-category="General"></button></span>
                <span class="badge bg-secondary category-chip">Inquiries <button class="btn-close btn-close-white remove-category" data-category="Inquiries"></button></span>
                <span class="badge bg-success category-chip">Admission <button class="btn-close btn-close-white remove-category" data-category="Admission"></button></span>
                <!-- Add Category Chip Button -->
                <span class="badge bg-success category-chip" id="add-category-chip">
                    + Add Category
                </span>
            </div>
            <div class="mt-3" id="new-category-section" style="display:none;">
                <input type="text" id="new-category" class="form-control d-inline-block w-75" placeholder="New category">
                <button id="save-category" class="btn btn-success">Save</button>
            </div>
        </div>

        <!-- FAQ List Section -->
        <div class="card p-3" id="faqListContainer">
            <h5>Manage FAQs</h5>
            <ul class="list-group" id="faqList">
                <li class="list-group-item border-top mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-1"> What is the admission process? </h5>
                        <div class="d-flex gap-3">
                            <button class="border-0 bg-transparent edit-faq" data-id="1">
                                <i class="fas fa-edit text-warning"></i>
                            </button>
                            <button class="border-0 bg-transparent delete-faq" data-id="1">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </div>
                    </div>
                    <p class="mb-1 text-muted"> The admission process includes filling out an application form, submitting required documents, and attending an interview. </p>
                    <small class="text-secondary">
                        Category: 
                        <select class="faq-category" data-id="1">
                            <option value="General">General</option>
                            <option value="Inquiries">Inquiries</option>
                            <option value="Admission" selected>Admission</option>
                        </select>
                        | Active: <input type="checkbox" class="faq-active" data-id="1" checked>
                    </small>
                </li>
            </ul>
        </div>
    </div>
</div>

<script src="../../js/faqs.js"></script>
<link rel="stylesheet" href="../../css/faqs_styles.css">
</body>
</html>
