<?php
// admin/log_details.php — Affichage des lignes détaillées d'un import

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

$pdo = getPDO();
$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT details, file_name FROM import_logs WHERE id = ?");
$stmt->execute([$id]);
$log = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$log) {
    die("Log introuvable.");
}

$details = json_decode($log['details'], true);

// Affichage View Fusion
View::render('admin_log_details', [
    'title' => $lang->get('logs_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'fileName' => $log['file_name'],
    'details' => $details
]);
