<?php
// index.php — page d'accueil du site

// Redirige vers /install si le fichier config.php n'existe pas
if (!file_exists(__DIR__ . '/config.php')) {
    header('Location: /install/');
    exit;
}

// Chargement multilingue et rendu de la page d'accueil
require_once __DIR__ . '/includes/View.php';
require_once __DIR__ . '/includes/Lang.php';

$lang = new Lang(); // ✅ utilise la langue dynamique (via settings.lang)

View::render('home', [
    'title' => $lang->get('welcome_title'),
    'message' => $lang->get('welcome_message'),
    'lang' => $lang
]);
