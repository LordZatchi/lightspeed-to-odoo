<?php
// install/index.php — page de démarrage de l'installation

require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';

$lang = new Lang(); // ✅ utilise la langue dynamique (via settings.lang)

View::render('install_view', [
    'title' => $lang->get('install_title'),
    'lang' => $lang
]);
