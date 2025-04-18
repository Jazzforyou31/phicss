<?php
session_start();
require_once '../../classes/transparencyClass.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sectionId = $_POST['section_id'] ?? null;

    if ($sectionId) {
        $transparency = new TransparencyClass();
        $section = $transparency->fetchSectionById($sectionId);

        if ($section) {
            echo json_encode(['success' => true, 'section' => $section]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Section not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No section ID']);
    }
}
