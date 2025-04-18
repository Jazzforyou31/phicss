<?php
require_once '../../classes/DatabaseClass.php';

function addFeedback($rating, $feedback) {
    try {
        $db = new Database();
        $connection = $db->connect();

        $query = "INSERT INTO feedback (rating, feedback) VALUES (:rating, :feedback)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':feedback', $feedback, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Thank you for your feedback!'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to submit your feedback. Please try again.'];
        }
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => 'An error occurred: ' . htmlspecialchars($e->getMessage())];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? null;
    $feedback = $_POST['feedback'] ?? null;

    if ($rating && is_numeric($rating) && $rating >= 1 && $rating <= 5) {
        $response = addFeedback($rating, $feedback);
    } else {
        $response = ['status' => 'error', 'message' => 'Please select a valid rating.'];
    }

    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Feedback</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .feedback-section {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }
        .feedback-section h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #333333;
        }
        .feedback-section p {
            margin-bottom: 20px;
            color: #6c757d;
            font-size: 1rem;
        }

        /* Rating Stars */
        .rating-stars {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .rating-stars label {
            cursor: pointer;
        }
        .rating-stars input[type="radio"] {
            display: none; /* Hides the radio buttons */
        }
        .rating-stars span {
            font-size: 2rem;
            color: #e4e5e9; /* Default gray for inactive stars */
        }
        .rating-stars input[type="radio"]:checked + span {
            color: #ffc107; /* Gold for active stars */
        }

        /* Feedback Form */
        textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 20px;
            resize: none;
        }
        button {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }

        /* Success/Error Messages */
        #feedbackMessage {
            font-weight: bold;
            font-size: 1rem;
            margin-top: 20px;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .feedback-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="feedback-section">
        <h2>We Value Your Feedback</h2>
        <p>How was your experience with our website? Please let us know!</p>

        <form id="feedbackForm" class="feedback-form" method="post">
            <!-- Rating Stars -->
            <div class="rating-stars">
                <label><input type="radio" name="rating" value="1"><span>★</span></label>
                <label><input type="radio" name="rating" value="2"><span>★</span></label>
                <label><input type="radio" name="rating" value="3"><span>★</span></label>
                <label><input type="radio" name="rating" value="4"><span>★</span></label>
                <label><input type="radio" name="rating" value="5"><span>★</span></label>
            </div>

            <!-- Feedback Textarea -->
            <textarea name="feedback" rows="4" placeholder="Leave a comment (optional)..."></textarea>

            <!-- Submit Button -->
            <button type="submit">Submit Feedback</button>
        </form>

        <!-- Feedback Message -->
        <div id="feedbackMessage"></div>
    </div>

    <script>
        // Handle feedback submission
        document.querySelector('#feedbackForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch('inputFeedback.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                const feedbackMessage = document.querySelector('#feedbackMessage');
                feedbackMessage.textContent = data.message;
                feedbackMessage.className = data.status === 'success' ? 'success' : 'error';

                if (data.status === 'success') {
                    form.style.display = 'none'; // Hide the form after successful submission
                }
            })
            .catch(() => {
                const feedbackMessage = document.querySelector('#feedbackMessage');
                feedbackMessage.textContent = 'An unexpected error occurred. Please try again.';
                feedbackMessage.className = 'error';
            });
        });

        // Highlight stars on selection
        document.querySelectorAll('.rating-stars input[type="radio"]').forEach((input, index) => {
            input.addEventListener('change', function () {
                const stars = document.querySelectorAll('.rating-stars span');

                stars.forEach((star, i) => {
                    star.style.color = i <= index ? '#ffc107' : '#e4e5e9'; // Gold for selected stars
                });
            });
        });
    </script>
</body>
</html>

