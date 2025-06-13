<?php
// install/index.php — Interface principale d'installation
// ---------------------------------------------------------

// Chargement dynamique de la langue
$langCode = $_GET['lang'] ?? 'fr';
$langFile = __DIR__ . '/lang/' . $langCode . '.php';

if (!file_exists($langFile)) {
    die("Langue inconnue");
}

require_once $langFile;
$lang = new LangInstall($translations);

// Liste des thèmes et langues disponibles
$themes = ['emeraldnight', 'emeraldday'];
$langs = ['fr' => 'Français', 'en' => 'English'];

// Affichage du formulaire
include __DIR__ . '/views/install_view.php';
