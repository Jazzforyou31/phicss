<?php
session_start();
require '../../classes/announcementClass.php';

$announcementClass = new AnnouncementClass();

// Handle ADD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add_announcement') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $created_by = $_SESSION['user_id'] ?? 1;

    if (!empty($title) && !empty($content)) {
        try {
            $announcementClass->addAnnouncement($title, $content, $created_by);
            echo json_encode(['status' => 'success', 'message' => 'Announcement added successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Title and content are required']);
    }
    exit;
}

// Handle EDIT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit_announcement') {
    $announcement_id = $_POST['announcement_id'] ?? 0;
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $updated_by = $_SESSION['user_id'] ?? 1;

    if ($announcement_id && $title && $content) {
        try {
            $announcementClass->editAnnouncement($announcement_id, $title, $content, $updated_by);
            echo json_encode(['status' => 'success', 'message' => 'Announcement updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    }
    exit;
}

// Handle DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete_announcement') {
    $announcement_id = $_POST['announcement_id'] ?? 0;
    if ($announcement_id) {
        try {
            $announcementClass->deleteAnnouncement($announcement_id);
            echo json_encode(['status' => 'success', 'message' => 'Announcement deleted successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    }
    exit;
}

$announcements = $announcementClass->fetchAnnouncements();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Announcement Management</title>
  <link rel="stylesheet" href="../../css/admin_sidebar.css">
  <link rel="stylesheet" href="../../css/announcement.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="admin-container">
  <?php include '../../includes/admin_sidebar.php'; ?>

  <div class="content">
    <div class="page-header">
      <h1>Announcement Management</h1>
      <p>Manage announcements for your platform</p>
    </div>

    <div class="d-flex justify-content-end mb-3">
      <button class="btn btn-primary" id="addAnnouncementBtn" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
        <i class="fas fa-plus"></i> Add Announcement
      </button>
    </div>

    <div class="card p-3">
      <h5>List of Announcements</h5>
      <ul class="list-group" id="announcementList">
        <?php if (!empty($announcements)): ?>
          <?php foreach ($announcements as $a): ?>
            <li class="list-group-item border-top mb-4">
              <div class="d-flex justify-content-between align-items-center ">
                <h5><?= htmlspecialchars($a['announcement_title']) ?></h5>
                <div>
                  <button class="border-0 bg-transparent edit-announcement" data-id="<?= $a['announcement_id'] ?>">
                    <i class="fas fa-edit text-warning"></i>
                  </button>
                  <button class="border-0 bg-transparent delete-announcement" data-id="<?= $a['announcement_id'] ?>">
                    <i class="fas fa-trash text-danger"></i>
                  </button>
                </div>
              </div>
              <p class="text-muted"><?= nl2br(htmlspecialchars($a['message'])) ?></p>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li class="list-group-item">No announcements found.</li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="addAnnouncementForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Announcement</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" value="add_announcement">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" class="form-control" name="title" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Content</label>
          <textarea class="form-control" name="content" rows="4" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Add</button>
      </div>
    </form>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editAnnouncementForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Announcement</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="announcement_id" id="editAnnouncementId">
        <input type="hidden" name="action" value="edit_announcement">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" class="form-control" name="title" id="editTitle" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Content</label>
          <textarea class="form-control" name="content" id="editContent" rows="4" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
$(function () {
  // ADD
  $('#addAnnouncementForm').submit(function (e) {
    e.preventDefault();
    $.post('admin_announcement.php', $(this).serialize(), function (res) {
      const response = JSON.parse(res);
      alert(response.message);
      if (response.status === 'success') {
        $('#addAnnouncementModal').modal('hide');
        location.reload();
      }
    });
  });

  // POPULATE EDIT MODAL
  $('.edit-announcement').click(function () {
    const card = $(this).closest('li');
    $('#editAnnouncementId').val($(this).data('id'));
    $('#editTitle').val(card.find('h5').text().trim());
    $('#editContent').val(card.find('p').text().trim());
    $('#editAnnouncementModal').modal('show');
  });

  // SUBMIT EDIT
  $('#editAnnouncementForm').submit(function (e) {
    e.preventDefault();
    $.post('admin_announcement.php', $(this).serialize(), function (res) {
      const response = JSON.parse(res);
      alert(response.message);
      if (response.status === 'success') {
        $('#editAnnouncementModal').modal('hide');
        location.reload();
      }
    });
  });

  // DELETE
  $('.delete-announcement').click(function () {
    if (!confirm('Are you sure?')) return;
    $.post('admin_announcement.php', {
      action: 'delete_announcement',
      announcement_id: $(this).data('id')
    }, function (res) {
      const response = JSON.parse(res);
      alert(response.message);
      if (response.status === 'success') {
        location.reload();
      }
    });
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>







