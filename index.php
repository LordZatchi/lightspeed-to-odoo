<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Ici ton code habituel de dashboard
require_once __DIR__ . '/includes/settings.php';
require_once __DIR__ . '/includes/View.php';
require_once __DIR__ . '/includes/Lang.php';

$theme = getSetting('theme') ?: 'emeraldnight';
$langCode = getSetting('lang') ?: 'fr';
$lang = new Lang($langCode);
$title = getSetting('site_title') ?: $lang->get('default_title');

View::render('home', [
    'title' => $title,
    'lang' => $lang,
    'theme' => $theme
]);
