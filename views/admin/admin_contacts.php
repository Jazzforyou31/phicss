<?php
require_once '../../classes/ContactsClass.php';

// Initialize ContactClass
$contacts = new ContactClass();

// Fetch contact data from the database
$contactList = $contacts->fetchAllContacts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts | Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin_contacts.css">
    <style>
        /* Styling for containers */
        .section-container {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two-column layout */
            gap: 20px; /* Space between columns */
        }

        .contact-box {
            display: flex;
            flex-direction: column; /* Stack labels and inputs vertically */
            gap: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="time"] {
            width: 100%;
            max-width: 400px;
            padding: 8px;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .contact-section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="content">
    <div class="container-fluid">
        <div class="page-header">
            <h1>Contacts</h1>
            <p>Manage PHICSS Contact Information</p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search..." id="searchBar">
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="editAboutBtn"><i class="fas fa-edit"></i> Edit About PHICSS</button>
        </div>

        <?php if (!empty($contactList)): ?>
            <?php foreach ($contactList as $contact): ?>

                <!-- Location Section -->
                <div class="section-container">
                    <div class="section-title">Location</div>
                    <div class="contact-grid">
                        <div class="contact-box">
                            <label><i class="fas fa-map-marker-alt"></i> Street</label>
                            <input type="text" name="street" value="<?php echo htmlspecialchars($contact['street']); ?>">
                        </div>
                        <div class="contact-box">
                            <label><i class="fas fa-building"></i> Campus</label>
                            <input type="text" name="campus" value="<?php echo htmlspecialchars($contact['campus']); ?>">
                        </div>
                        <div class="contact-box">
                            <label><i class="fas fa-university"></i> Building</label>
                            <input type="text" name="building" value="<?php echo htmlspecialchars($contact['building']); ?>">
                        </div>
                        <div class="contact-box">
                            <label><i class="fas fa-city"></i> City</label>
                            <input type="text" name="city" value="<?php echo htmlspecialchars($contact['city']); ?>">
                        </div>
                        <div class="contact-box">
                            <label><i class="fas fa-map"></i> Province</label>
                            <input type="text" name="province" value="<?php echo htmlspecialchars($contact['province']); ?>">
                        </div>
                        <div class="contact-box">
                            <label><i class="fas fa-flag"></i> Country</label>
                            <input type="text" name="country" value="<?php echo htmlspecialchars($contact['country']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="section-container">
                    <div class="section-title">Contact Information</div>
                    <div class="contact-grid">
                        <div class="contact-section">
                            <label>Contact Emails</label>
                            <div class="contact-box">
                                <label><i class="fas fa-envelope"></i> Primary Email</label>
                                <input type="email" value="<?php echo htmlspecialchars($contact['primary_email']); ?>" readonly>
                                <label><i class="fas fa-envelope"></i> Alternative Email</label>
                                <input type="email" value="<?php echo htmlspecialchars($contact['alternative_email']); ?>" readonly>
                            </div>
                        </div>

                        <div class="contact-section">
                            <label>Contact Numbers</label>
                            <div class="contact-box">
                                <label><i class="fas fa-phone"></i> Primary Number</label>
                                <input type="text" value="<?php echo htmlspecialchars($contact['primary_number']); ?>" readonly>
                                <label><i class="fas fa-phone"></i> Secondary Number</label>
                                <input type="text" value="<?php echo htmlspecialchars($contact['secondary_number']); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Hours Section -->
                <div class="contact-grid">
                    <div class="contact-section">
                        <label>Business Hours</label>
                        <div class="time-input">
                            <label><i class="fas fa-clock"></i> Opening Time</label>
                            <input type="time" name="opening_time" value="<?php echo htmlspecialchars(date('H:i', strtotime($contact['opening_time']))); ?>">
                        </div>
                    </div>
                    <div class="contact-section">
                        <label>&nbsp;</label>
                        <div class="time-input">
                            <label><i class="fas fa-clock"></i> Closing Time</label>
                            <input type="time" name="closing_time" value="<?php echo htmlspecialchars(date('H:i', strtotime($contact['closing_time']))); ?>">
                        </div>
                    </div>
                </div>


            <?php endforeach; ?>
        <?php else: ?>
            <p>No contact information available.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>