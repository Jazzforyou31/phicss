<?php
session_start();
include_once '../../includes/auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/officers.css">
    <title>Document</title>
</head>
<body>
<section class="officers-section">
    <div class="container">
        <h2 class="section-title">Manage Officers</h2>
        
        <button class="add-officer-btn" onclick="openModal()">+ Add Officer</button>
        
        <div class="officers-grid">
            <!-- Sample Officer Card -->
            <div class="officer-card">
                <div class="officer-image">
                    <img src="<?php echo $base_url; ?>assets/images/lak.jpg" alt="Officer">
                </div>
                <div class="officer-info">
                    <h3>John Doe</h3>
                    <p class="position">President</p>
                    <div class="actions">
                        <button class="edit-btn" onclick="openModal()">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Form for Adding/Editing Officers -->
<div id="officerModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Add/Edit Officer</h2>
        <form id="officerForm">
            <label for="officer-name">Name:</label>
            <input type="text" id="officer-name" placeholder="Enter name" required>

            <label for="officer-position">Position:</label>
            <input type="text" id="officer-position" placeholder="Enter position" required>

            <label for="officer-image">Upload Image:</label>
            <input type="file" id="officer-image">

            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("officerModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("officerModal").style.display = "none";
    }

    window.onclick = function(event) {
        let modal = document.getElementById("officerModal");
        if (event.target === modal) {
            closeModal();
        }
    };
</script>

</body>
</html>