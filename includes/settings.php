<?php
// includes/settings.php — Gestion des settings site
// ----------------------------------------------------

require_once __DIR__ . '/pdo.php';

/**
 * Récupère une clé settings depuis la table settings
 */
function getSetting($key)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT value FROM settings WHERE `key` = ?");
    $stmt->execute([$key]);
    return $stmt->fetchColumn();
}
