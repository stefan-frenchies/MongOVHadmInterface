<?php
require_once __DIR__ . '/../includes/mongo_connect.php';

$db = $_GET['db'] ?? '';
$coll = $_GET['collection'] ?? '';
if (!$db || !$coll) exit;

$query = new MongoDB\Driver\Query([], ['limit' => 1]);
$cursor = $manager->executeQuery("$db.$coll", $query);
$docs = $cursor->toArray();

if (count($docs)) {
    $template = json_encode($docs[0], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo $template;
} else {
    echo '';
}
