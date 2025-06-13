<?php
// includes/loader.php — Loader central V2 sécurisé et factorisé
// ----------------------------------------------------
// Charge automatiquement :
// - Session utilisateur
// - Paramètres personnalisés utilisateur (lang / thème)
// - Variables $lang, $langCode, $theme injectées à chaque page
// ----------------------------------------------------

require_once __DIR__ . '/pdo.php';
require_once __DIR__ . '/settings.php';
require_once __DIR__ . '/Lang.php';

// ✅ Démarre session uniquement si pas encore démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {

    $userId = $_SESSION['user']['id'];
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $theme = $user['theme'] ?: getSetting('theme');
    $langCode = $user['lang'] ?: getSetting('lang');
    $lang = new Lang($langCode);
} else {
    $theme = getSetting('theme') ?: 'emeraldnight';
    $langCode = getSetting('lang') ?: 'fr';
    $lang = new Lang($langCode);
}
