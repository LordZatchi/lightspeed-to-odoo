<?php
// index.php — Accueil utilisateur après connexion

require_once __DIR__ . '/includes/auth.php';      // Protection d'accès
require_once __DIR__ . '/includes/loader.php';    // Chargement des préférences utilisateur
require_once __DIR__ . '/includes/View.php';      // Moteur de rendu centralisé

// ✅ Affichage de la vue home
View::render('home', [
    'title' => $lang->get('home_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme
]);
