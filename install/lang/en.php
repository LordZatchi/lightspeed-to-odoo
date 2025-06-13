<?php
// Langue EN de l'installateur

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
    'install_title' => 'Lightspeed-Odoo Installation',
    'db_section' => 'MySQL Settings',
    'site_section' => 'Site Settings',
    'site_title' => 'Site Title',
    'site_theme' => 'Theme',
    'site_lang' => 'Language',
    'admin_section' => 'Administrator',
    'admin_email' => 'Admin Email',
    'admin_pass' => 'Admin Password',
    'install_button' => 'Install'
];
