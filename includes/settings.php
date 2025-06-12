<?php
// ✅ Lecture sécurisée des paramètres depuis la table settings

require_once __DIR__ . '/crypto.php';

/**
 * Récupère une clé de configuration depuis la table settings
 *
 * @param string $key
 * @return string|null
 */
function getSetting(string $key): ?string
{
    static $cache = [];

    if (isset($cache[$key])) return $cache[$key];

    if (!file_exists(__DIR__ . '/../config.php')) return null;
    $config = include __DIR__ . '/../config.php';

    try {
        $pdo = new PDO(
            'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8mb4',
            $config['db_user'],
            decrypt($config['db_pass'])
        );
        $stmt = $pdo->prepare("SELECT value FROM settings WHERE `key` = ?");
        $stmt->execute([$key]);
        $value = $stmt->fetchColumn();
        $cache[$key] = $value ?: null;
        return $cache[$key];
    } catch (Exception $e) {
        return null;
    }
}
