<?php
// import.php — Import CSV utilisateur (Fusion V2.5 - Phase 4 démarrage)

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/loader.php';
require_once __DIR__ . '/includes/View.php';
require_once __DIR__ . '/includes/pdo.php';

// Variables d'état
$message = '';
$headers = [];
$previewRows = [];
$mappings = [];

// Chargement des mappings existants
$pdo = getPDO();
$stmt = $pdo->query("SELECT id, name FROM mappings ORDER BY created_at DESC");
$mappings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement de l'upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {

    $mappingId = (int) ($_POST['selected_mapping'] ?? 0);
    $tmpName = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($tmpName, 'r')) !== false) {

        // Tentative de détection du séparateur automatique
        $firstLine = fgets($handle);
        $separator = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
        rewind($handle);

        // Lecture de l'en-tête
        $headers = fgetcsv($handle, 1000, $separator);

        // Lecture des premières lignes (prévisualisation)
        $limit = 5;
        while (($data = fgetcsv($handle, 1000, $separator)) !== false && $limit-- > 0) {
            $previewRows[] = $data;
        }

        fclose($handle);
    } else {
        $message = $lang->get('import_failed');
    }
}

// Rendu via View Fusion
View::render('import_user', [
    'title' => $lang->get('import_user_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'mappings' => $mappings,
    'headers' => $headers,
    'previewRows' => $previewRows,
    'message' => $message
]);
