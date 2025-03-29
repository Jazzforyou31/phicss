<?php
session_start();
require '../../classes/accountClass.php';

// Get search parameters
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$role = isset($_GET['role']) ? trim($_GET['role']) : '';

// Create an instance of AccountClass
$accountClass = new AccountClass();

// Get filtered users
$userList = $accountClass->searchUsers($searchTerm, $role);

// Return the user list HTML using the same format as in users.php
?>

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
<div class="no-data">No users found matching your search criteria.</div>
<?php endif; ?> 