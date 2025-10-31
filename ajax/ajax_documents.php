<?php
require_once __DIR__ . '/../includes/mongo_connect.php';

$db = $_GET['db'] ?? '';
$coll = $_GET['collection'] ?? '';
if (!$db || !$coll) exit;

$query = new MongoDB\Driver\Query([]);
$cursor = $manager->executeQuery("$db.$coll", $query);

echo "<table><tr><th>ID</th><th>Document</th><th>Actions</th></tr>";
foreach ($cursor as $doc) {
    $id = (string) $doc->_id;
    $json = json_encode($doc, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "<tr>
            <td><code>$id</code></td>
            <td><pre>$json</pre></td>
            <td>
              <form method='post' action='actions/delete_document.php' style='display:inline'>
                <input type='hidden' name='db' value='$db'>
                <input type='hidden' name='collection' value='$coll'>
                <input type='hidden' name='id' value='$id'>
                <button type='submit'>🗑️ Supprimer</button>
              </form>
            </td>
          </tr>";
}
echo "</table>";
