<?php
// includes/Lang.php — gestion multilingue
// ----------------------------------------------------

class Lang
{
    private $data;

    public function __construct($langCode)
    {
        $file = __DIR__ . '/../lang/' . $langCode . '.php';
        if (!file_exists($file)) {
            throw new Exception("Fichier langue introuvable : $file");
        }
        $this->data = include $file;
    }

    public function get($key)
    {
        return $this->data[$key] ?? $key;
    }
}
