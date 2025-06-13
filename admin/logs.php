<?php
// admin/logs.php — Affichage de l'historique des imports vers Odoo

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

// Lecture des logs depuis la base
$pdo = getPDO();
$stmt = $pdo->query("
    SELECT logs.*, users.email AS user_email, mappings.name AS mapping_name
    FROM import_logs logs
    LEFT JOIN users ON users.id = logs.user_id
    LEFT JOIN mappings ON mappings.id = logs.mapping_id
    ORDER BY logs.created_at DESC
");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Affichage via View fusionnée
View::render('admin_logs', [
    'title' => $lang->get('logs_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'logs' => $logs
]);
