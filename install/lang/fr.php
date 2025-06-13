<?php
// Langue FR de l'installateur

class LangInstall
{
    private $data;
    public function __construct($translations)
    {
        $this->data = $translations;
    }
    public function get($key)
    {
        return $this->data[$key] ?? $key;
    }
}

$translations = [
    'install_title' => 'Installation Lightspeed-Odoo',
    'db_section' => 'Paramètres MySQL',
    'site_section' => 'Paramètres du site',
    'site_title' => 'Nom du site',
    'site_theme' => 'Thème',
    'site_lang' => 'Langue',
    'admin_section' => 'Administrateur',
    'admin_email' => 'Email admin',
    'admin_pass' => 'Mot de passe admin',
    'install_button' => 'Installer'
];
