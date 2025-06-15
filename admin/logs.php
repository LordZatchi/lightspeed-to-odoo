<?php
// admin/logs.php — Logs enrichis avec filtres avancés (Phase 5.5)

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

$pdo = getPDO();

// Chargement utilisateurs & mappings pour les filtres
$users = $pdo->query("SELECT id, email FROM users ORDER BY email ASC")->fetchAll(PDO::FETCH_ASSOC);
$mappings = $pdo->query("SELECT id, name FROM mappings ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Lecture des filtres GET
$userId = (int) ($_GET['user_id'] ?? 0);
$mappingId = (int) ($_GET['mapping_id'] ?? 0);
$date = trim($_GET['date'] ?? '');

// Construction de la requête dynamique
$where = [];
$params = [];

if ($userId > 0) {
    $where[] = 'logs.user_id = ?';
    $params[] = $userId;
}
if ($mappingId > 0) {
    $where[] = 'logs.mapping_id = ?';
    $params[] = $mappingId;
}
if (!empty($date)) {
    $where[] = 'DATE(logs.created_at) = ?';
    $params[] = $date;
}

$whereSql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$stmt = $pdo->prepare("
    SELECT logs.*, users.email AS user_email, mappings.name AS mapping_name
    FROM import_logs logs
    LEFT JOIN users ON users.id = logs.user_id
    LEFT JOIN mappings ON mappings.id = logs.mapping_id
    $whereSql
    ORDER BY logs.created_at DESC
");

$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Affichage
View::render('admin_logs', [
    'title' => $lang->get('logs_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'logs' => $logs,
    'users' => $users,
    'mappings' => $mappings,
    'filters' => compact('userId', 'mappingId', 'date')
]);
