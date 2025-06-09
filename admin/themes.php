<?php
// admin/themes.php — Sélection et activation d’un thème (admin uniquement)

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';

Guard::admin();

$lang = new Lang('fr');
$pdo  = getPDO();
$message = null;

// 📥 Traitement du formulaire de changement de thème
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    $theme = basename($_POST['theme']); // sécurise le nom

    if (is_dir(__DIR__ . '/../template/' . $theme)) {
        // met à jour dans la base
        $stmt = $pdo->prepare("REPLACE INTO settings (`key`, `value`) VALUES ('theme', ?)");
        $stmt->execute([$theme]);
        $message = $lang->get('theme_changed');
    } else {
        $message = $lang->get('theme_invalid');
    }
}

// 🔎 Lecture du thème actif actuel
$stmt = $pdo->prepare("SELECT value FROM settings WHERE `key` = 'theme' LIMIT 1");
$stmt->execute();
$currentTheme = $stmt->fetchColumn() ?: 'emeraldnight';

// 📂 Liste des thèmes disponibles
$themes = [];
$themeDir = __DIR__ . '/../template/';
foreach (scandir($themeDir) as $entry) {
    if ($entry === '.' || $entry === '..') continue;
    if (is_dir($themeDir . $entry) && file_exists($themeDir . $entry . '/preview.png')) {
        $themes[] = $entry;
    }
}

// 👁 Vue
View::render('admin_themes', [
    'title' => $lang->get('theme_title'),
    'themes' => $themes,
    'active' => $currentTheme,
    'message' => $message,
    'lang' => $lang
]);
