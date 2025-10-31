<?php
require_once __DIR__ . '/../includes/mongo_connect.php';

$dbName = $_GET['db'] ?? '';
if (!$dbName) exit;

$command = new MongoDB\Driver\Command(["listCollections" => 1]);
try {
    $cursor = $manager->executeCommand($dbName, $command);
    $collections = array_map(fn($c) => $c->name, $cursor->toArray());
    echo json_encode($collections);
} catch (Exception $e) {
    echo json_encode([]);
}
