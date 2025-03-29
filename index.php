<?php
// Define the base URL
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $base_url = 'https://';
} else {
    $base_url = 'http://';
}

$base_url .= $_SERVER['HTTP_HOST'];

// Add project folder if it exists in the REQUEST_URI
$folder = '/phicss/';
if (strpos($_SERVER['REQUEST_URI'], '/phicss') !== false) {
    $base_url .= $folder;
} else {
    // If the project is in the webroot, just use a slash
    $folder = '/';
    $base_url .= $folder;
}

// Redirect to the landing page
header('Location: ' . $base_url . 'views/user/landing_page.php');
exit;
