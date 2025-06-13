<?php
// includes/crypto.php — Chiffrement AES sécurisé
// ----------------------------------------------------
// Fournit encrypt() et decrypt() pour les mots de passe Odoo & MySQL
// Utilise la clé stockée dans includes/secret.php
// ----------------------------------------------------

require_once __DIR__ . '/secret.php';

/**
 * Chiffre une valeur avec AES-256-CBC
 */
function encrypt($data)
{
    $iv = random_bytes(16);
    $cipher = openssl_encrypt($data, 'aes-256-cbc', AES_KEY, 0, $iv);
    return base64_encode($iv . $cipher);
}

/**
 * Déchiffre une valeur AES-256-CBC
 */
function decrypt($data)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $cipher = substr($data, 16);
    return openssl_decrypt($cipher, 'aes-256-cbc', AES_KEY, 0, $iv);
}
