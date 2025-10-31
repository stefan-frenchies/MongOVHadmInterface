<?php
require_once __DIR__ . '/../includes/mongo_connect.php';

$db = $_POST['db'] ?? '';
$coll = $_POST['collection'] ?? '';
$docJson = $_POST['document'] ?? '';

if ($db && $coll && $docJson) {
    $data = json_decode($docJson, true);
    if ($data) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert($data);
        $manager->executeBulkWrite("$db.$coll", $bulk);
    }
}
header("Location: ../index.php?db=$db&collection=$coll");
exit;
