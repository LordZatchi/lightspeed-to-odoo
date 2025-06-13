<?php
// admin/logs.php — Historique des imports Odoo

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

// ✅ Ici viendra l'affichage des logs d'import enrichis (avec filtres)
// ✅ Cette page sera développée en profondeur dans la Phase 5 Logs

View::render('admin_logs', [
    'title' => $lang->get('logs_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme
]);
