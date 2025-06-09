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
        if (file_exists(__DIR__ . '/../config.php')) {
            include __DIR__ . '/../config.php';
            return isset($config['theme']) ? $config['theme'] : 'emeraldnight';
        }
        return 'emeraldnight';
    }
}
