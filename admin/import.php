<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';
require_once __DIR__ . '/../includes/odoo.php';

Guard::admin();

$lang = new Lang();
$pdo = getPDO();

$message = null;
$columns = [];
$filename = '';
$results = [];

// 📤 Traitement : Upload CSV pour analyse des colonnes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $tmpName = $_FILES['csv_file']['tmp_name'];
    if (($handle = fopen($tmpName, 'r')) !== false) {
        $header = fgetcsv($handle, 1000, ';');
        if ($header) {
            $columns = array_map('trim', $header);
            $filename = $_FILES['csv_file']['name'];
        }
        fclose($handle);
    }
}

// 💾 Traitement : Enregistrement du mapping CSV ↔ Odoo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mapping']) && isset($_POST['mapping_name'])) {
    $mapping = $_POST['mapping'];
    $name = trim($_POST['mapping_name']);
    $csv_columns = array_keys($mapping);

    $stmt = $pdo->prepare("INSERT INTO mappings (name, data, csv_columns, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([
        $name,
        json_encode($mapping, JSON_UNESCAPED_UNICODE),
        json_encode($csv_columns, JSON_UNESCAPED_UNICODE)
    ]);
    $message = $lang->get('mapping_saved_success');
}

// 🚀 Import réel vers Odoo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import_real']) && isset($_FILES['csv_real_file'])) {
    $mappingId = (int) $_POST['selected_mapping'];

    $stmt = $pdo->prepare("SELECT data FROM mappings WHERE id = ?");
    $stmt->execute([$mappingId]);
    $mappingData = $stmt->fetchColumn();

    if ($mappingData) {
        $mapping = json_decode($mappingData, true);
        $tmpName = $_FILES['csv_real_file']['tmp_name'];
        if (($handle = fopen($tmpName, 'r')) !== false) {
            $headers = fgetcsv($handle, 1000, ';');
            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                $data = [];
                foreach ($headers as $index => $columnName) {
                    $odooField = $mapping[$columnName] ?? null;
                    if ($odooField && isset($row[$index])) {
                        $data[$odooField] = $row[$index];
                    }
                }

                $results[] = sendToOdoo($data, $lang);
            }
            fclose($handle);

            // ✅ Enregistrement dans import_logs
            $successCount = count(array_filter($results, fn($r) => $r['success']));
            $failCount = count($results) - $successCount;
            $total = count($results);
            $status = $failCount === 0 ? 'success' : 'error';

            $stmt = $pdo->prepare("
                INSERT INTO import_logs (user_id, mapping_id, file_name, total_lines, success_lines, failed_lines, status, message, details)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $_SESSION['user_id'],
                $mappingId,
                $_FILES['csv_real_file']['name'],
                $total,
                $successCount,
                $failCount,
                $status,
                $lang->get('logs_import_message_' . $status),
                json_encode($results, JSON_UNESCAPED_UNICODE)
            ]);
        }
    } else {
        $message = $lang->get('import_mapping_not_found');
    }
}

// 🔁 Champs Odoo disponibles
$odoo_fields = include __DIR__ . '/../includes/odoo_fields.php';

// 🔄 Mappings existants
$stmt = $pdo->query("SELECT id, name FROM mappings ORDER BY created_at DESC");
$availableMappings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 🎨 Rendu
View::render('admin_import', [
    'title' => $lang->get('import_title'),
    'message' => $message,
    'columns' => $columns,
    'filename' => $filename,
    'odoo_fields' => $odoo_fields,
    'availableMappings' => $availableMappings,
    'results' => $results,
    'lang' => $lang
]);
