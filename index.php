<?php
// index.php — page d'accueil du site

if (!file_exists(__DIR__ . '/config.php')) {
    header('Location: /install/');
    exit;
}

require_once __DIR__ . '/includes/settings.php';
require_once __DIR__ . '/includes/View.php';
require_once __DIR__ . '/includes/Lang.php';

$langCode = getSetting('lang') ?: 'fr';
$lang = new Lang($langCode);
$title = getSetting('site_title') ?: $lang->get('default_title');

View::render('home', [
    'title' => $title,
    'lang' => $lang
]);
