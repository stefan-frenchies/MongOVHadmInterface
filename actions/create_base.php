<?php
require_once __DIR__ . '/../includes/mongo_connect.php';

$db = $_POST['db'] ?? '';
if ($db) {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->insert(['init' => true]);
    $manager->executeBulkWrite("$db._init", $bulk);
}
header("Location: ../index.php?db=$db");
exit;
