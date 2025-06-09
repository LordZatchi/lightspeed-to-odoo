<?php
// includes/Lang.php
class Lang
{
    private $strings = [];

    public function __construct($lang = 'fr')
    {
        $file = __DIR__ . "/../lang/{$lang}.php";
        if (file_exists($file)) {
            $this->strings = include $file;
        }
    }

    public function get($key)
    {
        return isset($this->strings[$key]) ? $this->strings[$key] : $key;
    }
}
