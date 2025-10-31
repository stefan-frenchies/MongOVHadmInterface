
<?php
require_once __DIR__ . '/../includes/mongo_connect.php';

$db = $_POST['db'] ?? '';
$coll = $_POST['collection'] ?? '';
$id = $_POST['id'] ?? '';

if ($db && $coll && $id) {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(['_id' => new MongoDB\BSON\ObjectId($id)], ['limit' => 1]);
    $manager->executeBulkWrite("$db.$coll", $bulk);
}
header("Location: ../index.php?db=$db&collection=$coll");
exit;
