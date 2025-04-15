<?php
session_start();
include_once '../../includes/auth_check.php';

// Include TransparencyClass for data fetching
require_once '../../classes/transparencyClass.php';

// Instantiate TransparencyClass
$transparency = new TransparencyClass();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparency Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <link rel="stylesheet" href="../../css/admin_transparency.css">
</head>
<body>
<div class="admin-container">
    <!-- Include Sidebar Navigation -->
    <?php include '../../includes/admin_sidebar.php'; ?>


        <div class="content">
            <div class="page-header">
                <h1>Transparency Management</h1>
                <p>Manage Transparency Page</p>
            </div>

            <div class="search-and-button-container">
                <div class="search-container">
                    <input type="text" placeholder="Search">
                    <button><i class="fas fa-filter"></i> Filters</button>
                </div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTransparencyModal">Add Report</button>
            </div>

            <!-- Display Transparency Sections Dynamically -->
            <?php
            $sections = $transparency->fetchSections(); // Fetch sections using TransparencyClass

            if (!empty($sections)) {
                foreach ($sections as $section) {
                    echo '<div class="main-container">';
                    echo '<div class="icon-container">';
                    echo '<i class="fas fa-folder"></i>';
                    echo '</div>';

                    echo '<div class="action-icons">';
                    echo '<button class="edit-btn" data-id="' . htmlspecialchars($section['id']) . '"><i class="fas fa-pencil-alt"></i></button>';
                    echo '<button class="delete-btn" data-id="' . htmlspecialchars($section['id']) . '"><i class="fas fa-trash"></i></button>';
                    echo '</div>';

                    echo '<div class="inner-container">';
                    echo '<div class="section-title">';
                    echo '<h3>' . htmlspecialchars($section['section_title']) . '</h3>';
                    echo '</div>';
                    echo '<div class="subsection">';
                    echo '<p>This is a description or subsection of the section.</p>';
                    echo '</div>';
                    echo '<div class="content-links">';

                    $links = $transparency->fetchLinksBySection($section['id']); // Fetch links for the current section
                    if (!empty($links)) {
                        foreach ($links as $link) {
                            echo '<a href="' . htmlspecialchars($link['document_link']) . '" target="_blank">' . htmlspecialchars($link['document_title']) . '</a>';
                        }
                    } else {
                        echo '<p>No links available for this section.</p>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No transparency sections found.</p>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>