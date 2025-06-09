<?php
// admin/logs.php — Historique des imports CSV

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';

Guard::admin();

$lang = new Lang();
$pdo = getPDO();

// 📦 Récupération des derniers logs
$stmt = $pdo->query("
    SELECT l.*, u.email, m.name AS mapping_name
    FROM import_logs l
    LEFT JOIN users u ON u.id = l.user_id
    LEFT JOIN mappings m ON m.id = l.mapping_id
    ORDER BY l.created_at DESC
    LIMIT 100
");

$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 👁 Vue
View::render('admin_logs', [
    'title' => $lang->get('logs_title'),
    'logs' => $logs,
    'lang' => $lang
]);
