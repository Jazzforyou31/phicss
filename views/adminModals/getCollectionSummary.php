<?php
require_once '../../classes/collectionClass.php';

header('Content-Type: application/json');

$schoolYearId = isset($_GET['schoolYearId']) ? (int)$_GET['schoolYearId'] : null;

$collection = new CollectionClass();
$data = $collection->fetchAllCollections($schoolYearId);

// Return only the first match
echo json_encode($data[0] ?? []);
?>
