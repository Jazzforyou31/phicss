<?php
session_start();
include_once '../../includes/auth_check.php';
require '../../classes/faqsClass.php';

$faqsClass = new FaqsClass();

// Handle ADD FAQ submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_faq') {
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $category = $_POST['category'] ?? '';
    $created_by = $_SESSION['user_id'] ?? 1; // fallback to 1 if session not available

    if (!empty($question) && !empty($answer)) {
        try {
            $stmt = $faqsClass->connection->prepare("INSERT INTO faqs (question, answer, category, created_at, created_by) VALUES (?, ?, ?, NOW(), ?)");
            $stmt->execute([$question, $answer, $category, $created_by]);
            echo json_encode(['status' => 'success', 'message' => 'FAQ added successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Question and Answer are required']);
    }
    exit;
}

// Handle EDIT FAQ submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_faq') {
    $faq_id = $_POST['faq_id'] ?? 0;
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $category = $_POST['category'] ?? '';
    $updated_by = $_SESSION['user_id'] ?? 1;

    if ($faq_id && !empty($question) && !empty($answer) && !empty($category)) {
        try {
            $faqsClass->editFAQ($faq_id, $question, $answer, $category, $updated_by);
            echo json_encode(['status' => 'success', 'message' => 'FAQ updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    }
    exit;
}

// Handle DELETE FAQ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_faq') {
    $faq_id = $_POST['faq_id'] ?? 0;

    if ($faq_id) {
        try {
            $faqsClass->deleteFAQ($faq_id);
            echo json_encode(['status' => 'success', 'message' => 'FAQ deleted successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'FAQ ID is required']);
    }
    exit;
}


$faqList = $faqsClass->fetchFAQs();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FAQs Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/admin_faqs.css">
  <link rel="stylesheet" href="../../css/admin_sidebar.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
      <button type="button" class="btn btn-primary" id="addFaqBtn" data-bs-toggle="modal" data-bs-target="#addFaqModal">
        <i class="fas fa-plus"></i> Add FAQ
      </button>
    </div>

    <!-- FAQ List Section -->
    <div class="card p-3" id="faqListContainer">
      <h5>Manage FAQs</h5>
      <ul class="list-group" id="faqList">
        <?php if (!empty($faqList)): ?>
          <?php foreach ($faqList as $faq): ?>
            <li class="list-group-item border-top mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-1"><?= htmlspecialchars($faq['question']) ?></h5>
                <div class="d-flex gap-3">
                  <button class="border-0 bg-transparent edit-faq" data-id="<?= $faq['faq_id'] ?>">
                    <i class="fas fa-edit text-warning"></i>
                  </button>
                  <button class="border-0 bg-transparent delete-faq" data-id="<?= $faq['faq_id'] ?>">
                    <i class="fas fa-trash text-danger"></i>
                  </button>
                </div>
              </div>
              <p class="mb-1 text-muted"><?= htmlspecialchars($faq['answer']) ?></p>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li class="list-group-item">No FAQs found.</li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<!-- ADD FAQ MODAL -->
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addFaqForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFaqModalLabel">Add FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="question" class="form-label">Question</label>
          <input type="text" class="form-control" name="question" required>
        </div>
        <div class="mb-3">
          <label for="answer" class="form-label">Answer</label>
          <textarea class="form-control" name="answer" rows="4" required></textarea>
        </div>
        <div class="mb-3">
          <label for="category" class="form-label">Category</label>
          <textarea class="form-control" name="category" rows="4" required></textarea>
        </div>
        <input type="hidden" name="action" value="add_faq">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add FAQ</button>
      </div>
    </form>
  </div>
</div>



<!-- EDIT FAQ MODAL -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editFaqForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editFaqModalLabel">Edit FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="faq_id" id="editFaqId">
        <div class="mb-3">
          <label for="editQuestion" class="form-label">Question</label>
          <input type="text" class="form-control" name="question" id="editQuestion" required>
        </div>
        <div class="mb-3">
          <label for="editAnswer" class="form-label">Answer</label>
          <textarea class="form-control" name="answer" id="editAnswer" rows="4" required></textarea>
        </div>
        <div class="mb-3">
          <label for="editCategory" class="form-label">Category</label>
          <textarea class="form-control" name="category" id="editCategory" rows="4" required></textarea>
        </div>
        <input type="hidden" name="action" value="edit_faq">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Update FAQ</button>
      </div>
    </form>
  </div>
</div>


<script>
$(document).ready(function () {
    // ADD FAQ
    $('#addFaqForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.post('faqs.php', formData, function (response) {
            let res = JSON.parse(response);
            if (res.status === 'success') {
                alert(res.message);
                $('#addFaqModal').modal('hide');
                location.reload();
            } else {
                alert(res.message);
            }
        });
    });

    // EDIT FAQ - populate modal
    $('.edit-faq').click(function () {
        var faqId = $(this).data('id');
        var question = $(this).closest('li').find('h5').text().trim();
        var answer = $(this).closest('li').find('p').text().trim();

        $('#editFaqId').val(faqId);
        $('#editQuestion').val(question);
        $('#editAnswer').val(answer);
        $('#editCategory').val(category);
        $('#editFaqModal').modal('show');
    });

    // SUBMIT Edit FAQ
    $('#editFaqForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.post('faqs.php', formData, function (response) {
            let res = JSON.parse(response);
            if (res.status === 'success') {
                alert(res.message);
                $('#editFaqModal').modal('hide');
                location.reload();
            } else {
                alert(res.message);
            }
        });
    });

    // DELETE FAQ
    $('.delete-faq').click(function () {
        if (!confirm('Are you sure you want to delete this FAQ?')) return;

        var faqId = $(this).data('id');
        $.post('faqs.php', { action: 'delete_faq', faq_id: faqId }, function (response) {
            let res = JSON.parse(response);
            if (res.status === 'success') {
                alert(res.message);
                location.reload();
            } else {
                alert(res.message);
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../../css/faqs_styles.css">
</body>
</html>
