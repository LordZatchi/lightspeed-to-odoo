<?php
// ✅ Fonctions de chiffrement/déchiffrement AES-256

require_once __DIR__ . '/secret.php';

/**
 * Chiffre une chaîne de caractères avec AES-256
 */
function encrypt($data)
{
    $key = ENCRYPTION_KEY;
    $iv = random_bytes(16);
    $cipher = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $cipher);
}

/**
 * Déchiffre une chaîne AES-256
 */
function decrypt($data)
{
    $key = ENCRYPTION_KEY;
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $cipher = substr($data, 16);
    return openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
}
