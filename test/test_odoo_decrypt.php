<?php
// test_odoo_decrypt.php — Test de déchiffrement de ton odoo_pass

require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/settings.php';
require_once __DIR__ . '/../includes/crypto.php';

try {
    $crypted = getSetting('odoo_pass');
    echo "<h2>Valeur chiffrée stockée en base :</h2>";
    echo "<pre>" . htmlspecialchars($crypted) . "</pre>";

    $decrypted = decrypt($crypted);

    echo "<h2>Résultat du décryptage :</h2>";
    echo "<pre>" . htmlspecialchars($decrypted) . "</pre>";
} catch (Exception $e) {
    echo "<h2>❌ ERREUR :</h2>";
    echo htmlspecialchars($e->getMessage());
}
