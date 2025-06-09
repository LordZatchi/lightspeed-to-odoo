<?php
// import.php — Import CSV pour utilisateur (simple)

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/pdo.php';
require_once __DIR__ . '/includes/View.php';
require_once __DIR__ . '/includes/Lang.php';
require_once __DIR__ . '/includes/odoo.php';

Guard::user(); // Accès utilisateurs simples

$lang = new Lang();
$pdo = getPDO();
$message = null;
$results = [];

// 📋 Liste des mappings disponibles
$stmt = $pdo->query("SELECT id, name FROM mappings ORDER BY created_at DESC");
$availableMappings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 📥 Traitement de l'import utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file']) && isset($_POST['selected_mapping'])) {
    $mappingId = (int) $_POST['selected_mapping'];

    $stmt = $pdo->prepare("SELECT data FROM mappings WHERE id = ?");
    $stmt->execute([$mappingId]);
    $mappingData = $stmt->fetchColumn();

    if (!$mappingData) {
        $message = $lang->get('import_mapping_not_found');
    } else {
        $mapping = json_decode($mappingData, true);

        $tmpName = $_FILES['csv_file']['tmp_name'];
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

                // Envoi vers Odoo
                $results[] = sendToOdoo($data, $lang);
            }
            fclose($handle);
            // ✅ Comptage des succès / erreurs
            $successCount = count(array_filter($results, fn($r) => $r['success']));
            $failCount = count($results) - $successCount;
            $total = count($results);
            $status = $failCount === 0 ? 'success' : 'error';

            // 💾 Insertion dans import_logs
            $stmt = $pdo->prepare("
    INSERT INTO import_logs (user_id, mapping_id, file_name, total_lines, success_lines, failed_lines, status, message, details)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

            $stmt->execute([
                $_SESSION['user_id'],
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
}

// 👁 Affichage
View::render('import_user', [
    'title' => $lang->get('import_user_title'),
    'message' => $message,
    'availableMappings' => $availableMappings,
    'results' => $results,
    'lang' => $lang
]);
