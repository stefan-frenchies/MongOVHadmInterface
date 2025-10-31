document.addEventListener('DOMContentLoaded', () => {
  const dbSelect = document.getElementById('dbSelect');
  const collSelect = document.getElementById('collSelect');
  const documentsDiv = document.getElementById('documents');
  const documentJson = document.getElementById('documentJson');

  function updateURL(db, coll) {
    const url = new URL(window.location.href);
    url.searchParams.set('db', db);
    url.searchParams.set('collection', coll);
    window.history.replaceState({}, '', url);
  }

  function loadCollections(selectedCollection = null) {
    const db = dbSelect.value;
    fetch(`ajax/ajax_collections.php?db=${encodeURIComponent(db)}`)
      .then(res => res.json())
      .then(data => {
        collSelect.innerHTML = '<option value="">-- Choisir une collection --</option>';
        data.forEach(name => {
          const opt = document.createElement('option');
          opt.value = name;
          opt.textContent = name;
          if (name === selectedCollection) opt.selected = true;
          collSelect.appendChild(opt);
        });
        if (selectedCollection) loadDocuments();
      });
  }

  function loadDocuments() {
    const db = dbSelect.value;
    const coll = collSelect.value;
    updateURL(db, coll);

    // Charger les documents
    fetch(`ajax/ajax_documents.php?db=${encodeURIComponent(db)}&collection=${encodeURIComponent(coll)}`)
      .then(res => res.text())
      .then(html => {
        documentsDiv.innerHTML = html;
      });

    // Charger le template
    fetch(`ajax/template_document.php?db=${encodeURIComponent(db)}&collection=${encodeURIComponent(coll)}`)
      .then(res => res.text())
      .then(template => {
        if (template.trim()) {
          documentJson.value = template;
        } else {
          documentJson.value = '';
        }
      });
  }

  dbSelect.addEventListener('change', () => loadCollections());
  collSelect.addEventListener('change', () => loadDocuments());

  // Restauration de la sélection à partir de l'URL
  const urlParams = new URLSearchParams(window.location.search);
  const db = urlParams.get('db');
  const coll = urlParams.get('collection');
  if (db) {
    dbSelect.value = db;
    loadCollections(coll);
  }

  // Création de base
  document.getElementById('createBaseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const db = document.getElementById('newDbName').value;
    fetch('actions/create_base.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'db=' + encodeURIComponent(db)
    }).then(() => location.href = `index.php?db=${encodeURIComponent(db)}`);
  });

  // Création de collection
  document.getElementById('createCollectionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const db = document.getElementById('collectionDbSelect').value;
    const coll = document.getElementById('newCollectionName').value;
    fetch('actions/create_collection.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'db=' + encodeURIComponent(db) + '&collection=' + encodeURIComponent(coll)
    }).then(() => location.href = `index.php?db=${encodeURIComponent(db)}&collection=${encodeURIComponent(coll)}`);
  });

  // Insertion de document
  document.getElementById('insertDocumentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const db = dbSelect.value;
    const coll = collSelect.value;
    const doc = documentJson.value;
    fetch('actions/insert_document.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'db=' + encodeURIComponent(db) + '&collection=' + encodeURIComponent(coll) + '&document=' + encodeURIComponent(doc)
    }).then(() => loadDocuments());
  });
});
