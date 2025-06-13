<?php
// includes/pdo.php — Connexion PDO sécurisée avec AES
// ----------------------------------------------------
// Gère la connexion MySQL via PDO
// Chiffre le mot de passe stocké dans config.php
// Utilise decrypt() depuis crypto.php pour sécuriser l'accès
// ----------------------------------------------------

require_once __DIR__ . '/crypto.php';

/**
 * Retourne une instance PDO sécurisée
 *
 * @return PDO
 * @throws Exception
 */
function getPDO()
{
    $configPath = __DIR__ . '/../config.php';
    if (!file_exists($configPath)) {
        throw new Exception('Fichier config.php introuvable');
    }

    $config = include $configPath;

    if (!isset($config['db_host'], $config['db_name'], $config['db_user'], $config['db_pass'])) {
        throw new Exception('Configuration MySQL incomplète');
    }

    $db_pass = decrypt($config['db_pass']);

    $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8mb4';

    return new PDO($dsn, $config['db_user'], $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
