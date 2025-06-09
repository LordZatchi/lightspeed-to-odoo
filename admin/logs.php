<?php
// admin/logs.php — Historique paginé des imports

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';

Guard::admin();

$lang = new Lang();
$pdo = getPDO();

$logsPerPage = 20;
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
    ? (int) $_GET['page']
    : 1;
$offset = ($currentPage - 1) * $logsPerPage;

// 🔢 Nombre total de logs
$totalStmt = $pdo->query("SELECT COUNT(*) FROM import_logs");
$totalLogs = $totalStmt->fetchColumn();
$totalPages = max(ceil($totalLogs / $logsPerPage), 1);

// 📥 Récupération des logs paginés
$stmt = $pdo->prepare("
    SELECT l.*, u.email, m.name AS mapping_name
    FROM import_logs l
    LEFT JOIN users u ON u.id = l.user_id
    LEFT JOIN mappings m ON m.id = l.mapping_id
    ORDER BY l.created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $logsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 🎨 Vue
View::render('admin_logs', [
    'title' => $lang->get('logs_title'),
    'logs' => $logs,
    'currentPage' => $currentPage,
    'totalPages' => $totalPages,
    'lang' => $lang
]);
