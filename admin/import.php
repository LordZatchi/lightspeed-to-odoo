<?php
// admin/import.php — Upload CSV et mapping dynamique (admin)

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';

Guard::admin();

$lang = new Lang();
$pdo = getPDO();
$columns = [];
$filename = null;
$message = null;

// 📥 Traitement de l'upload CSV
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    if (!is_dir(__DIR__ . '/../data')) {
        mkdir(__DIR__ . '/../data', 0755, true);
    }

    $tmpName = $_FILES['csv_file']['tmp_name'];
    $originalName = basename($_FILES['csv_file']['name']);
    $filename = uniqid('csv_', true) . '.csv';
    $destination = __DIR__ . '/../data/' . $filename;

    if (move_uploaded_file($tmpName, $destination)) {
        if (($handle = fopen($destination, 'r')) !== false) {
            $columns = fgetcsv($handle, 1000, ';');
            fclose($handle);
        }
        $message = $lang->get('import_success');
    } else {
        $message = $lang->get('import_failed');
    }
}

// 💾 Traitement de l'enregistrement du modèle de mapping
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mapping']) && isset($_POST['mapping_name'])) {
    $mappingName = trim($_POST['mapping_name']);
    $mappingData = $_POST['mapping']; // tableau colonne => champ Odoo

    if ($mappingName && is_array($mappingData)) {
        $stmt = $pdo->prepare("INSERT INTO mappings (name, data) VALUES (?, ?)");
        $stmt->execute([
            $mappingName,
            json_encode($mappingData, JSON_UNESCAPED_UNICODE)
        ]);
        $message = $lang->get('mapping_saved');
    } else {
        $message = $lang->get('mapping_invalid');
    }

    // on vide colonnes après sauvegarde
    $columns = [];
}

// 🔁 Chargement des champs mappables Odoo
$odoo_fields = include __DIR__ . '/../includes/odoo_fields.php';

// 👁 Affichage de la vue
View::render('admin_import', [
    'title' => $lang->get('import_title'),
    'message' => $message,
    'columns' => $columns,
    'filename' => $filename,
    'odoo_fields' => $odoo_fields,
    'lang' => $lang
]);
