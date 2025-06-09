<?php
// includes/pdo.php — Connexion PDO centralisée à MySQL

/**
 * Crée et retourne une instance PDO connectée à la base MySQL définie dans config.php
 *
 * @return PDO
 * @throws Exception si config.php est absent ou invalide
 */
function getPDO()
{
    // Vérifie que le fichier config existe
    $configPath = __DIR__ . '/../config.php';
    if (!file_exists($configPath)) {
        throw new Exception('Fichier de configuration config.php manquant.');
    }

    // Charge la config
    include $configPath;

    // Vérifie les infos de connexion
    if (!isset($config['db_host'], $config['db_name'], $config['db_user'], $config['db_pass'])) {
        throw new Exception('Paramètres de base de données manquants dans config.php.');
    }

    // Décode le mot de passe stocké en base64
    $db_pass = base64_decode($config['db_pass']);

    // Connexion PDO
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
