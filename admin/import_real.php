<?php
// admin/import_real.php — Import CSV vers Odoo (Fusion V2.5 sécurisé AES + logs)

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/odoo.php';
require_once __DIR__ . '/../includes/crypto.php';

// Chargement des mappings disponibles
$pdo = getPDO();
$stmt = $pdo->query("SELECT id, name FROM mappings ORDER BY created_at DESC");
$mappings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$message = '';
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {

    $mappingId = (int) $_POST['selected_mapping'];

    // Récupérer le mapping depuis la base
    $stmt = $pdo->prepare("SELECT data FROM mappings WHERE id = ?");
    $stmt->execute([$mappingId]);
    $mappingJson = $stmt->fetchColumn();

    if (!$mappingJson) {
        $message = $lang->get('mapping_not_found');
    } else {
        $mapping = json_decode($mappingJson, true);
        $tmpName = $_FILES['csv_file']['tmp_name'];

        // 🔐 Chargement des paramètres Odoo sécurisés
        $odoo_url  = getSetting('odoo_url');
        $odoo_db   = getSetting('odoo_db');
        $odoo_user = getSetting('odoo_user');
        $odoo_pass = decrypt(getSetting('odoo_pass'));

        if (($handle = fopen($tmpName, 'r')) !== false) {

            $firstLine = fgets($handle);
            $separator = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
            rewind($handle);

            $headers = fgetcsv($handle, 1000, $separator);

            while (($row = fgetcsv($handle, 1000, $separator)) !== false) {
                $data = [];
                foreach ($headers as $index => $csvCol) {
                    $odooField = $mapping[$csvCol] ?? null;
                    if ($odooField && isset($row[$index])) {
                        $data[$odooField] = $row[$index];
                    }
                }

                $results[] = sendToOdoo($odoo_url, $odoo_db, $odoo_user, $odoo_pass, $data);
            }

            fclose($handle);
        }

        // ✅ Enregistrement du log complet en base après l'import
        $total = count($results);
        $successCount = count(array_filter($results, fn($r) => $r['success']));
        $failCount = $total - $successCount;
        $status = ($failCount === 0) ? 'success' : 'error';

        $stmt = $pdo->prepare("
            INSERT INTO import_logs (user_id, mapping_id, file_name, total_lines, success_lines, failed_lines, status, message, details)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $_SESSION['user']['id'],
            $mappingId,
            $_FILES['csv_file']['name'],
            $total,
            $successCount,
            $failCount,
            $status,
            $lang->get('logs_import_message_' . $status),
            json_encode($results, JSON_UNESCAPED_UNICODE)
        ]);
    }
}

// Affichage via View Fusion
View::render('admin_import_real', [
    'title' => $lang->get('import_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'mappings' => $mappings,
    'results' => $results,
    'message' => $message
]);
