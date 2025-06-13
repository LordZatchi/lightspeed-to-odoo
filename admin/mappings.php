<?php
// admin/mappings.php — Gestion des modèles de mapping CSV ↔ Odoo

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

// ✅ Ici viendra la gestion CRUD complète des mappings CSV
// ✅ Refonte prévue complète lors de la Phase 4

View::render('admin_mappings', [
    'title' => $lang->get('mappings_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme
]);
