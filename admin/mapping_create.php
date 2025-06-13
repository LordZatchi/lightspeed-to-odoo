<?php
// admin/mapping_create.php — Création d'un mapping dynamique (Phase 4 Fusion V2.5)

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

// Chargement des champs Odoo
$odoo_fields = include __DIR__ . '/../includes/odoo_fields.php';

// Variables d'état
$message = '';
$columns = [];
$filename = '';

// 📥 Traitement de l'upload CSV pour analyse des colonnes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {

    $tmpName = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($tmpName, 'r')) !== false) {

        // Détection du séparateur intelligent
        $firstLine = fgets($handle);
        $separator = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
        rewind($handle);

        $header = fgetcsv($handle, 1000, $separator);
        if ($header) {
            $columns = array_map('trim', $header);
            $filename = $_FILES['csv_file']['name'];
        }
        fclose($handle);
    }
}

// 📥 Traitement de l'enregistrement final du mapping
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mapping_name']) && isset($_POST['mapping'])) {

    $mappingName = trim($_POST['mapping_name']);
    $mappingData = $_POST['mapping'];
    $csv_columns = array_keys($mappingData);

    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT INTO mappings (name, data, csv_columns, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([
        $mappingName,
        json_encode($mappingData, JSON_UNESCAPED_UNICODE),
        json_encode($csv_columns, JSON_UNESCAPED_UNICODE)
    ]);

    $message = $lang->get('mapping_saved');
}

// ✅ Affichage fusionné
View::render('admin_mapping_create', [
    'title' => $lang->get('mappings_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'columns' => $columns,
    'odoo_fields' => $odoo_fields,
    'message' => $message
]);
