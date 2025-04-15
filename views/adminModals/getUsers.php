<?php
session_start();
require '../../classes/accountClass.php';

$accountClass = new Account();
$userList = $accountClass->getAllUsers();
?>

<?php if (!empty($userList)): ?>
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>User ID</th>
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
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="<?php echo $user['user_id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $user['user_id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center text-muted">No users found.</p>
<?php endif; ?>
