<?php
// admin/settings.php — Paramètres système et connexion Odoo/MySQL

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/crypto.php';

// ✅ Ici viendra la logique de modification des paramètres globaux
// ✅ Cette page sera revue en profondeur dans les prochaines phases

View::render('admin_settings', [
    'title' => $lang->get('settings_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme
]);
