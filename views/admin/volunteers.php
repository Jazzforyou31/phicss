<?php
session_start();
require_once '../../includes/auth_check.php';
require_once '../../classes/volunteerClass.php';
require_once '../../classes/accountClass.php';

// Initialize the VolunteerClass object
$volunteerObj = new VolunteerClass();

// Handle AJAX request to update the volunteer status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['volunteer_id'], $_POST['status'])) {
    $volunteer_id = $_POST['volunteer_id'];
    $status = $_POST['status'];
    $approved_by = $_SESSION['user_id'] ?? null;

    if ($status === 'approved') {
        $volunteerObj->updateStatus($volunteer_id, $status, $approved_by);
    } else {
        $volunteerObj->updateStatus($volunteer_id, $status, null);
    }

    echo json_encode(['status' => 'success']);
    exit;
}

// Fetch all volunteers
$volunteers = $volunteerObj->fetchAllVolunteers();

// Replace approved_by IDs with usernames
foreach ($volunteers as &$volunteer) {
    if (!empty($volunteer['approved_by'])) {
        $account = $volunteerObj->fetchApprover($volunteer['approved_by']);
        $volunteer['approved_by'] = $account ? $account['username'] : 'Unknown';
    }
}
unset($volunteer); // Break reference loop
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteers</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <link rel="stylesheet" href="../../css/admin_volunteers.css">
</head>

<body>
    <div class="admin-container container-fluid">
        <!-- Include Sidebar -->
        <?php include '../../includes/admin_sidebar.php'; ?>

        <div class="content">
            <div class="page-header">
                <h1>Volunteers Management</h1>
                <p>Manage and track volunteer applications</p>
            </div>

            <div class="volunteers-table-container row">
                <div class="col-12">
                    <?php if (!empty($volunteers)): ?>
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Year</th>
                                    <th>Interest</th>
                                    <th>Program</th>
                                    <th>Status</th>
                                    <th>Approved By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($volunteers as $volunteer): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($volunteer['id']) ?></td>
                                        <td><?= htmlspecialchars($volunteer['first_name']) . ' ' . 
                                            (!empty($volunteer['middle_name']) ? htmlspecialchars($volunteer['middle_name']) . ' ' : '') . 
                                            htmlspecialchars($volunteer['last_name']) ?></td>
                                        <td><?= htmlspecialchars($volunteer['school_email']) ?></td>
                                        <td><?= htmlspecialchars($volunteer['course']) ?></td>
                                        <td><?= htmlspecialchars($volunteer['year']) ?></td>
                                        <td><?= htmlspecialchars($volunteer['interest']) ?></td>
                                        <td><?= htmlspecialchars($volunteer['program']) ?></td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $volunteer['status'])) ?>">
                                                <?= htmlspecialchars($volunteer['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= $volunteer['status'] === 'approved' ? htmlspecialchars($volunteer['approved_by']) : 'Not yet approved' ?></td>
                                        <td class="action-buttons">
                                            <button class="edit-btn btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editStatusModal"
                                                data-id="<?= $volunteer['id'] ?>"
                                                data-status="<?= $volunteer['status'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?= $volunteer['id'] ?>" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this volunteer?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="no-data">No volunteers found.</div>
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
                        <h5 class="modal-title">Edit Volunteer Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="volunteer_id" id="modalVolunteerId">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="modalStatus" class="form-select" required>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="declined">Declined</option>
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
            const volunteerId = button.getAttribute('data-id');
            const status = button.getAttribute('data-status');

            document.getElementById('modalVolunteerId').value = volunteerId;
            document.getElementById('modalStatus').value = status;
        });

        // Handle form submission via AJAX
        $('#statusForm').on('submit', function (e) {
            e.preventDefault();

            const volunteerId = $('#modalVolunteerId').val();
            const status = $('#modalStatus').val();

            $.ajax({
                url: 'volunteers.php',
                method: 'POST',
                data: {
                    volunteer_id: volunteerId,
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