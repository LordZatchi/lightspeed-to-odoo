<?php
// ✅ Connexion PDO centralisée avec lecture du mot de passe AES

require_once __DIR__ . '/crypto.php';

/**
 * Établit une connexion PDO sécurisée à MySQL via config.php
 *
 * @return PDO
 * @throws Exception
 */
function getPDO()
{
    $configPath = __DIR__ . '/../config.php';
    if (!file_exists($configPath)) {
        throw new Exception('Fichier config.php manquant.');
    }

    $config = include $configPath;

    if (!isset($config['db_host'], $config['db_name'], $config['db_user'], $config['db_pass'])) {
        throw new Exception('Paramètres manquants dans config.php.');
    }

    $db_pass = decrypt($config['db_pass']);

    $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8mb4';

    try {
        $pdo = new PDO($dsn, $config['db_user'], $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception('Connexion PDO échouée : ' . $e->getMessage());
    }
}
