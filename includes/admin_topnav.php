<?php
// Get the current user information
// You can modify this to pull actual user data from the session or database
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin User';
$user_avatar = isset($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : '../../assets/images/brex.jpg';

// Determine base URL if not already set
if (!isset($base_url)) {
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
        $base_url = 'https://';
    } else {
        $base_url = 'http://';
    }
    $base_url .= $_SERVER['HTTP_HOST'];
    $folder = '/phicss/';
    if (strpos($_SERVER['REQUEST_URI'], '/phicss/') !== false) {
        $base_url .= $folder;
    } else {
        $folder = '/';
        $base_url .= $folder;
    }
}
?>

<div class="top-nav">
    <div class="top-nav-right">
        <div class="user-profile">
            <?php if (isset($_SESSION['account'])): 
                $first_letter = strtoupper(substr($_SESSION['account']['first_name'], 0, 1));
                $last_letter = strtoupper(substr($_SESSION['account']['last_name'], 0, 1));
            ?>
                <div class="profile-dropdown">
                    <div class="profile-trigger">
                        <div class="profile-avatar">
                            <span class="avatar-initials"><?= $first_letter . $last_letter ?></span>
                        </div>
                        <span class="user-greeting"><?= htmlspecialchars($_SESSION['account']['first_name']) ?></span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="profile-dropdown-menu">
                        <div class="profile-header">
                            <div class="profile-avatar large">
                                <span class="avatar-initials"><?= $first_letter . $last_letter ?></span>
                            </div>
                            <div class="profile-info">
                                <span class="profile-name"><?= htmlspecialchars($_SESSION['account']['first_name'] . ' ' . $_SESSION['account']['last_name']) ?></span>
                                <span class="profile-email"><?= htmlspecialchars($_SESSION['account']['email']) ?></span>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo $base_url ?? ''; ?>accounts/logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <span class="user-greeting">Hello, User!</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.top-nav {
    background: #fff;
    padding: 15px 30px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    justify-content: flex-end;
    align-items: center;
    width: 100%;
}

.top-nav-right {
    margin-left: auto;
}

.user-profile {
    position: relative;
}

.profile-dropdown {
    position: relative;
    cursor: pointer;
}

.profile-trigger {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px 10px;
    border-radius: 20px;
    transition: background-color 0.3s;
}

.profile-trigger:hover {
    background-color: #f5f5f5;
}

.profile-avatar {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

.profile-avatar.large {
    width: 50px;
    height: 50px;
    font-size: 1.2em;
}

.avatar-initials {
    font-size: 14px;
}

.user-greeting {
    font-weight: 500;
    color: #333;
}

.dropdown-icon {
    font-size: 12px;
    color: #666;
    transition: transform 0.3s;
}

.profile-dropdown-menu {
    position: absolute;
    right: 0;
    top: 100%;
    width: 250px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s;
    z-index: 1000;
    pointer-events: none;
}

.profile-dropdown:hover .profile-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
}

.profile-dropdown:hover .dropdown-icon {
    transform: rotate(180deg);
}

.profile-header {
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.profile-info {
    display: flex;
    flex-direction: column;
}

.profile-name {
    font-weight: 600;
    color: #333;
}

.profile-email {
    font-size: 12px;
    color: #666;
}

.dropdown-divider {
    height: 1px;
    background: #eee;
    margin: 5px 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    color: #333;
    text-decoration: none;
    transition: background-color 0.3s;
}

.dropdown-item:hover {
    background-color: #f5f5f5;
}

.dropdown-item i {
    color: #666;
    width: 20px;
    text-align: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // No event listeners needed for hover functionality
    // All handled by CSS
});
</script> 