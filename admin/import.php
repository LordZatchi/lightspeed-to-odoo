<?php
// admin/import.php — Import CSV administrateur avancé

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

// ✅ Ici viendra la logique de parsing CSV et de mapping pour l'admin
// (intégrée dans la future Phase 4 - Multi-Import avancé)

View::render('admin_import', [
    'title' => $lang->get('import_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme
]);
