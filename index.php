<?php
require_once __DIR__ . '/includes/mongo_connect.php';

$command = new MongoDB\Driver\Command(["listDatabases" => 1]);
$cursor = $manager->executeCommand("admin", $command);
$allDatabases = $cursor->toArray()[0]->databases;
$databases = array_filter($allDatabases, fn($db) => !in_array($db->name, ['admin', 'local', 'config']));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>MongoDB Admin</title>
  <link rel="stylesheet" href="assets/style.css">
  <script src="assets/script.js" defer></script>
  <style>
    body { font-family: Arial; padding: 20px; background: #f9f9f9; }
    select, button, textarea, input { padding: 5px; margin: 5px 0; width: 100%; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; background: #fff; }
    th, td { border: 1px solid #ccc; padding: 10px; vertical-align: top; }
    th { background-color: #eee; }
    pre { white-space: pre-wrap; word-wrap: break-word; }
  </style>
</head>
<body>
  <h1>🛠️ MongoDB Admin Interface</h1>

  <!-- Créer une base -->
  <form id="createBaseForm">
    <label>➕ Créer une base :</label>
    <input type="text" id="newDbName" placeholder="Nom de la base" required>
    <button type="submit">Créer</button>
  </form>

  <!-- Créer une collection -->
  <form id="createCollectionForm">
    <label>📁 Créer une collection :</label>
    <select id="collectionDbSelect" required>
      <?php foreach ($databases as $db): ?>
        <option value="<?= htmlspecialchars($db->name) ?>"><?= htmlspecialchars($db->name) ?></option>
      <?php endforeach; ?>
    </select>
    <input type="text" id="newCollectionName" placeholder="Nom de la collection" required>
    <button type="submit">Créer</button>
  </form>

  <!-- Sélection base et collection -->
  <label>🗄️ Base :</label>
  <select id="dbSelect">
    <option value="">-- Choisir une base --</option>
    <?php foreach ($databases as $db): ?>
      <option value="<?= htmlspecialchars($db->name) ?>"><?= htmlspecialchars($db->name) ?></option>
    <?php endforeach; ?>
  </select>

  <label>📁 Collection :</label>
  <select id="collSelect">
    <option value="">-- Choisir une collection --</option>
  </select>

  <!-- Ajouter un document -->
  <h2>📄 Ajouter un document</h2>
  <form id="insertDocumentForm">
    <textarea id="documentJson" rows="4" placeholder='{"champ":"valeur"}' required></textarea>
    <button type="submit">Insérer</button>
  </form>

  <!-- Affichage des documents -->
  <h2>📄 Documents</h2>
  <div id="documents"></div>
</body>
</html>
