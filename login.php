<?php
// login.php — Page de connexion centralisée (V2 sécurisée)

require_once __DIR__ . '/includes/pdo.php';
require_once __DIR__ . '/includes/settings.php';
require_once __DIR__ . '/includes/View.php';
require_once __DIR__ . '/includes/Lang.php';

// 🔧 Chargement dynamique des paramètres globaux
$theme = getSetting('theme') ?: 'emeraldnight';
$langCode = getSetting('lang') ?: 'fr';
$site_title = getSetting('site_title') ?: 'Lightspeed to Odoo';
$logoPath = getSetting('logo_path') ?: '/uploads/logo.png';

// Multilingue
$lang = new Lang($langCode);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pass, $user['password'])) {
            session_start();
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'email' => $user['email'],
                'role'  => $user['role']
            ];
            header('Location: index.php');
            exit;
        } else {
            $error = $lang->get('login_invalid');
        }
    } catch (Exception $e) {
        $error = $lang->get('login_error') . ' : ' . $e->getMessage();
    }
}

// Rendu avec View centralisée
View::render('login', [
    'title' => $site_title,
    'logo' => $logoPath,
    'error' => $error,
    'lang' => $lang,
    'langCode' => $langCode, // <-- tu ajoutes ça
    'theme' => $theme
]);
