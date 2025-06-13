<?php
// admin/edit_mapping.php — Edition d'un mapping CSV ↔ Odoo

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

// ✅ Chargement du mapping existant
$pdo = getPDO();
$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM mappings WHERE id = ?");
$stmt->execute([$id]);
$mapping = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mapping) {
    die("Mapping introuvable.");
}

$data = json_decode($mapping['data'], true);
$csv_columns = json_decode($mapping['csv_columns'], true);
$odoo_fields = include __DIR__ . '/../includes/odoo_fields.php';

// ✅ Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newMapping = $_POST['mapping'] ?? [];
    $stmt = $pdo->prepare("UPDATE mappings SET data = ? WHERE id = ?");
    $stmt->execute([json_encode($newMapping, JSON_UNESCAPED_UNICODE), $id]);
    header("Location: mappings.php");
    exit;
}

// ✅ Affichage
View::render('admin_edit_mapping', [
    'title' => $lang->get('mappings_edit_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'mapping' => $mapping,
    'data' => $data,
    'csv_columns' => $csv_columns,
    'odoo_fields' => $odoo_fields
]);
