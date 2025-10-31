<?php
require_once __DIR__ . '/../includes/mongo_connect.php';

$db = $_POST['db'] ?? '';
$coll = $_POST['collection'] ?? '';
$id = $_POST['id'] ?? '';
$docJson = $_POST['document'] ?? '';

if ($db && $coll && $id && $docJson) {
    $data = json_decode($docJson, true);
    if ($data) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => $data],
            ['multi' => false, 'upsert' => false]
        );
        $manager->executeBulkWrite("$db.$coll", $bulk);
    }
}
header("Location: ../index.php?db=$db&collection=$coll");
exit;
