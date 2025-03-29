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

<div class="top-bar">
    <div class="user-info">
        <span><?php echo $user_name; ?></span>
        <img src="<?php echo $user_avatar; ?>" alt="Admin Avatar">
    </div>
</div> 