<?php
session_start();
require_once '../../includes/auth_check.php';
require_once '../../classes/messageClass.php';
require_once '../../classes/accountClass.php';

// Initialize the MessageClass object
$messageObj = new MessageClass();

// Handle AJAX request to update the message status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'], $_POST['status'])) {
    $message_id = $_POST['message_id'];
    $status = $_POST['status'];
    $processed_by = $_SESSION['user_id'] ?? null;

    if ($status === 'Resolved') {
        $messageObj->updateStatus($message_id, $status, $processed_by);
    } else {
        $messageObj->updateStatus($message_id, $status, null);
    }

    echo json_encode(['status' => 'success']);
    exit;
}

// Fetch all messages
$messages = $messageObj->fetchAllMessages();

// Replace processed_by IDs with usernames
foreach ($messages as &$msg) {
    if (!empty($msg['processed_by'])) {
        $account = $messageObj->fetch($msg['processed_by']); // Reuse your fetch method
        $msg['processed_by'] = $account ? $account['username'] : 'Unknown';
    }
}
unset($msg); // Break reference loop
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <link rel="stylesheet" href="../../css/admin_messages.css">
</head>

<body>
    <div class="admin-container container-fluid">
        <!-- Include Sidebar -->
        <?php include '../../includes/admin_sidebar.php'; ?>

        <div class="content">
            <div class="page-header">
                <h1>Message Center</h1>
                <p>Manage and respond to user messages</p>
            </div>

            <div class="messages-table-container row">
                <div class="col-12">
                    <?php if (!empty($messages)): ?>
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Date Sent</th>
                                    <th>Status</th>
                                    <th>Processed By</th>
                                    <th>Date Resolved</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $msg): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($msg['message_id']) ?></td>
                                        <td><?= htmlspecialchars($msg['full_name']) ?></td>
                                        <td><?= htmlspecialchars($msg['email_address']) ?></td>
                                        <td><?= htmlspecialchars($msg['phone_number']) ?></td>
                                        <td><?= htmlspecialchars($msg['message']) ?></td>
                                        <td><?= htmlspecialchars($msg['date_sent']) ?></td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $msg['status'])) ?>">
                                                <?= htmlspecialchars($msg['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= $msg['status'] === 'Resolved' ? htmlspecialchars($msg['processed_by']) : 'Not yet resolved' ?></td>
                                        <td><?= $msg['status'] === 'Resolved' ? htmlspecialchars($msg['date_resolved']) : 'Not yet resolved' ?></td>
                                        <td class="action-buttons">
                                            <button class="edit-btn btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editStatusModal"
                                                data-id="<?= $msg['message_id'] ?>"
                                                data-status="<?= $msg['status'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?= $msg['message_id'] ?>" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this message?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="no-data">No messages found.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Status Modal -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="statusForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Message Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="message_id" id="modalMessageId">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="modalStatus" class="form-select" required>
                                <option value="Pending">Pending</option>
                                <option value="Received">Received</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Resolved">Resolved</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const editModal = document.getElementById('editStatusModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const messageId = button.getAttribute('data-id');
            const status = button.getAttribute('data-status');

            document.getElementById('modalMessageId').value = messageId;
            document.getElementById('modalStatus').value = status;
        });

        // Handle form submission via AJAX
        $('#statusForm').on('submit', function (e) {
            e.preventDefault();

            const messageId = $('#modalMessageId').val();
            const status = $('#modalStatus').val();

            $.ajax({
                url: 'message.php',
                method: 'POST',
                data: {
                    message_id: messageId,
                    status: status
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('Status updated successfully!');
                        location.reload();  // Reload to see changes
                    } else {
                        alert('Error updating status');
                    }
                },
                error: function () {
                    alert('An error occurred');
                }
            });
        });
    </script>
</body>

</html>
