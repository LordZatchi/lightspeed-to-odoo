<?php
// includes/View.php — Moteur de rendu View V2 Fusion
// ----------------------------------------------------
// Gère :
// - layout.php spécifique par thème
// - vues métier communes dans /views/
// - injection dynamique des variables
// ----------------------------------------------------

require_once __DIR__ . '/settings.php';

class View
{
    public static function render($view, $vars = [])
    {
        extract($vars);

        $theme = $vars['theme'] ?? (getSetting('theme') ?: 'emeraldnight');
        $layoutFile = __DIR__ . '/../template/' . $theme . '/views/layout.php';
        $pageView = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($layoutFile)) {
            throw new Exception("Layout introuvable : $layoutFile");
        }
        if (!file_exists($pageView)) {
            throw new Exception("Vue introuvable : $pageView");
        }

        include $layoutFile;
    }
}
