<?php
// includes/Lang.php — Chargement multilingue intelligent (via settings.lang)

require_once __DIR__ . '/pdo.php';

class Lang
{
    private $strings = [];
    private $langCode = 'fr';

    /**
     * Constructeur principal : charge la langue depuis la base ou utilise le fallback
     */
    public function __construct(?string $forcedLang = null)
    {
        $this->langCode = $forcedLang;

        if (!$this->langCode) {
            try {
                $pdo = getPDO();
                $stmt = $pdo->prepare("SELECT value FROM settings WHERE `key` = 'lang' LIMIT 1");
                $stmt->execute();
                $this->langCode = $stmt->fetchColumn() ?: 'fr';
            } catch (Exception $e) {
                $this->langCode = 'fr';
            }
        }

        $file = __DIR__ . '/../lang/' . $this->langCode . '.php';
        if (!file_exists($file)) {
            $file = __DIR__ . '/../lang/fr.php';
            $this->langCode = 'fr';
        }

        $this->strings = include $file;
    }

    /**
     * Récupère une clé de langue
     */
    public function get(string $key): string
    {
        return $this->strings[$key] ?? $key;
    }

    /**
     * Récupère le code langue courant (fr, en, etc.)
     */
    public function getLangCode(): string
    {
        return $this->strings['__lang_code'] ?? $this->langCode;
    }
}
