<?php
require_once __DIR__ . '/../includes/mongo_connect.php';

$db = $_POST['db'] ?? '';
$coll = $_POST['collection'] ?? '';
if ($db && $coll) {
    $command = new MongoDB\Driver\Command(['create' => $coll]);
    $manager->executeCommand($db, $command);
}
header("Location: ../index.php?db=$db&collection=$coll");
exit;
