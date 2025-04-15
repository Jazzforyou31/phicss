<?php
session_start();
include_once '../../includes/auth_check.php';
require '../../classes/accountClass.php';

$accountObj = new Account();
$userList = $accountObj->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/admin_sidebar.css">
    <link rel="stylesheet" href="../../css/admin_users.css">
</head>
<body>
<div class="admin-container">
    <!-- Include Sidebar Navigation -->
    <?php include '../../includes/admin_sidebar.php'; ?>

    <div class="content">
        <div class="page-header">
            <h1>Users Management</h1>
            <p>Manage user accounts and permissions</p>
        </div>

        <div class="search-and-button-container">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search users by name or email...">
                <button id="filterBtn" data-bs-toggle="modal" data-bs-target="#filterModal"><i class="fas fa-filter"></i> Filter</button>
            </div>
            <button class="add-user-btn" id="addNewUserBtn"><i class="fas fa-plus"></i> Add New User</button>
        </div>

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Users</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="roleFilter" class="form-label">Role</label>
                            <select class="form-select" id="roleFilter">
                                <option value="">All Roles</option>
                                <option value="Admin">Admin</option>
                                <option value="Moderator">Moderator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="clearFilters">Clear Filters</button>
                        <button type="button" class="btn btn-primary" id="applyFilters" data-bs-dismiss="modal">Apply</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display Users Table -->
        <div class="users-table-container">
            <div id="userTable">
                <!-- User list will be loaded here via AJAX -->
                <?php if (!empty($userList)): ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userList as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="role-badge role-<?php echo strtolower($user['role']); ?>"><?php echo htmlspecialchars($user['role']); ?></span>
                            </td>
                            <td class="action-buttons">
                                <button class="edit-btn" data-id="<?php echo $user['user_id']; ?>" title="Edit User"><i class="fas fa-edit"></i></button>
                                <button class="delete-btn" data-id="<?php echo $user['user_id']; ?>" title="Delete User"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="no-data">No users found. Click the "Add New User" button to add your first user.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="../../js/users.js"></script>
</body>
</html>