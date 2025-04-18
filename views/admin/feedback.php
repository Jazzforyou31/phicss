<?php
require_once '../../classes/DatabaseClass.php'; // Include database connection logic

// Fetch all feedback for the admin dashboard
try {
    $db = new Database(); // Adjust this line for your database connection logic
    $connection = $db->connect();

    // Query to fetch feedback
    $query = "SELECT feedback_id, rating, feedback, date_submitted FROM feedback ORDER BY date_submitted DESC";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $feedbackList = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all feedback
} catch (PDOException $e) {
    $errorMessage = 'An error occurred while fetching feedback: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead {
            background-color: #f1f3f5;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }
        .error {
            color: red;
            text-align: center;
        }
        .stars {
            color: #f39c12;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Feedback Dashboard</h1>
        <?php if (!empty($errorMessage)): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php elseif (!empty($feedbackList)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rating</th>
                        <th>Feedback</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbackList as $feedback): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($feedback['feedback_id']); ?></td>
                            <td>
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $feedback['rating']): ?>
                                            <i class="fas fa-star"></i> <!-- Filled star -->
                                        <?php else: ?>
                                            <i class="far fa-star"></i> <!-- Empty star -->
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($feedback['feedback']) ?: 'No comment'; ?></td>
                            <td><?php echo htmlspecialchars($feedback['date_submitted']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No feedback has been submitted yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>