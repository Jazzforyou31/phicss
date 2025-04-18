

// Handle ADD FAQ submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_faq') {
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $created_by = $_SESSION['user_id'] ?? 1; // fallback to 1 if session not available

    if (!empty($question) && !empty($answer)) {
        try {
            $stmt = $faqsClass->connection->prepare("INSERT INTO faqs (question, answer, created_at, created_by) VALUES (?, ?, NOW(), ?)");
            $stmt->execute([$question, $answer, $created_by]);
            echo json_encode(['status' => 'success', 'message' => 'FAQ added successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Question and Answer are required']);
    }
    exit;

}





?>