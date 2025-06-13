<?php
// admin/users.php — Gestion des utilisateurs (admin uniquement)

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/loader.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/pdo.php';

// ✅ Liste des utilisateurs
$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Affichage
View::render('admin_users', [
    'title' => $lang->get('users_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'users' => $users
]);
