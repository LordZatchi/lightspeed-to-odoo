<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';

Guard::admin();

$lang = new Lang();
$pdo = getPDO();
$odoo_fields = include __DIR__ . '/../includes/odoo_fields.php';

$message = null;
$mapping = [];
$columns = [];
$name = '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    // 🔄 Chargement du mapping
    $stmt = $pdo->prepare("SELECT name, data, csv_columns FROM mappings WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $message = $lang->get('mapping_not_found');
    } else {
        $name = $row['name'];
        $mapping = json_decode($row['data'], true);
        $columns = json_decode($row['csv_columns'], true) ?? [];
    }
} else {
    $message = $lang->get('mapping_invalid_id');
}

// 💾 Sauvegarde de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mapping']) && $id > 0) {
    $mapping = $_POST['mapping'];
    $stmt = $pdo->prepare("UPDATE mappings SET data = ? WHERE id = ?");
    $stmt->execute([json_encode($mapping, JSON_UNESCAPED_UNICODE), $id]);

    header("Location: mappings.php?updated=1");
    exit;
}

// Vue
View::render('edit_mapping', [
    'title' => $lang->get('mapping_edit_title'),
    'id' => $id,
    'name' => $name,
    'columns' => $columns,
    'mapping' => $mapping,
    'odoo_fields' => $odoo_fields,
    'message' => $message,
    'lang' => $lang
]);
