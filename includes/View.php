<?php
// includes/View.php
class View
{
    public static function render($view, $vars = [])
    {
        $theme = self::getTheme();
        extract($vars);
        include __DIR__ . '/../template/' . $theme . '/views/' . $view . '.php';
    }

    private static function getTheme()
    {
        // 1. Tente via settings (base de données)
        try {
            require_once __DIR__ . '/pdo.php';
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT value FROM settings WHERE `key` = 'theme' LIMIT 1");
            $stmt->execute();
            $theme = $stmt->fetchColumn();
            if ($theme && is_dir(__DIR__ . '/../template/' . $theme)) {
                echo '<!-- Thème actif : ' . $theme . ' -->';
                return $theme;
            }
        } catch (Exception $e) {
            // fallback
        }

        // 2. Sinon via config.php (fallback si base inaccessible)
        if (file_exists(__DIR__ . '/../config.php')) {
            include __DIR__ . '/../config.php';
            return isset($config['theme']) ? $config['theme'] : 'emeraldnight';
        }

        // 3. Défaut absolu
        return 'emeraldnight';
    }
}
