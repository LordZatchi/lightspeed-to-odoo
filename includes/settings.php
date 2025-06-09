<?php
// includes/settings.php

class Settings
{
    private static $data = [];

    public static function load()
    {
        if (!file_exists(__DIR__ . '/../config.php')) return;
        include __DIR__ . '/../config.php';

        $pdo = getPDO();
        $stmt = $pdo->query("SELECT `key`, `value` FROM settings");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            self::$data[$row['key']] = $row['value'];
        }
    }

    public static function get($key)
    {
        return self::$data[$key] ?? null;
    }
}
