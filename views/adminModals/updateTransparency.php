<?php
// Include necessary files
require '../../classes/transparencyClass.php'

// Initialize the response array
$response = ['status' => 'error', 'message' => 'An unknown error occurred.'];

// Check if the required data is sent via POST
if (isset($_POST['sectionId'], $_POST['sectionTitle'], $_POST['linkIds'], $_POST['linkTitles'], $_POST['linkUrls'])) {
    // Sanitize input data
    $sectionId = intval($_POST['sectionId']);
    $sectionTitle = htmlspecialchars($_POST['sectionTitle']);
    $linkIds = $_POST['linkIds'];  // These are array of link IDs
    $linkTitles = $_POST['linkTitles'];  // These are array of link titles
    $linkUrls = $_POST['linkUrls'];  // These are array of link URLs
    $userId = 1;  // Replace this with actual user ID from session or authentication

    // Create instance of TransparencyClass
    $transparency = new TransparencyClass();

    // Update the section
    $sectionUpdated = $transparency->updateSection($sectionId, $sectionTitle, $userId);

    // Check if the section was updated successfully
    if ($sectionUpdated) {
        // Update links if the section was updated successfully
        $linksUpdated = $transparency->updateLinks($sectionId, $linkIds, $linkTitles, $userId);

        if ($linksUpdated) {
            $response['status'] = 'success';
            $response['message'] = 'Transparency updated successfully!';
        } else {
            $response['message'] = 'Error updating links.';
        }
    } else {
        $response['message'] = 'Error updating section.';
    }
} else {
    $response['message'] = 'Missing required parameters.';
}

// Return the response as JSON
echo json_encode($response);
exit();
