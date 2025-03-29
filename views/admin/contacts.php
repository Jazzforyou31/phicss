<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts | Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content {
            width: 100%; /* Take full viewport width */
            padding: 0;
        }

        .page-header {
            padding: 20px 0;
            margin-bottom: 20px;
        }

        .contact-section {
            margin-bottom: 20px;
        }

        .contact-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-top: 5px;
            background: #fff;
        }

        label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }

        .contact-grid {
            display: flex;
            gap: 20px;
        }

        .contact-grid .contact-section {
            flex: 1;
        }

        .time-input {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .contact-grid {
                flex-direction: column;
            }
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

        <div class="contact-section">
            <label>Location</label>
            <div class="contact-box">
                <p><i class="fas fa-map-marker-alt"></i> 123 Main Street, City, Country</p>
            </div>
        </div>

        <div class="contact-grid">
            <div class="contact-section">
                <label>Contact Emails</label>
                <div class="contact-box">
                    <label><i class="fas fa-envelope"></i> General Inquiries</label>
                    <input type="email" value="info@computing.edu.ph" readonly>
                    <label><i class="fas fa-envelope"></i> Admissions</label>
                    <input type="email" value="admissions@computing.edu.ph" readonly>
                </div>
            </div>

            <div class="contact-section">
                <label>Contact Number</label>
                <div class="contact-box">
                    <label><i class="fas fa-phone"></i> Main Office</label>
                    <input type="text" value="+123 456 7890" readonly>
                    <label><i class="fas fa-phone"></i> Student Affairs</label>
                    <input type="text" value="+987 654 3210" readonly>
                </div>
            </div>
        </div>

        <div class="contact-grid">
            <div class="contact-section">
                <label>Business Hours</label>
                <div class="time-input">
                    <label><i class="fas fa-clock"></i> Opening Time</label>
                    <input type="text" value="10:00 AM" readonly>
                </div>
            </div>
            <div class="contact-section">
                <label>&nbsp;</label>
                <div class="time-input">
                    <label><i class="fas fa-clock"></i> Closing Time</label>
                    <input type="text" value="05:00 PM" readonly>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
