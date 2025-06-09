<?php
// login.php — Connexion utilisateur

require_once __DIR__ . '/includes/pdo.php';
require_once __DIR__ . '/includes/Lang.php';
require_once __DIR__ . '/includes/View.php';
require_once __DIR__ . '/includes/auth.php';

$lang = new Lang('fr');
$error = null;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!$email || !$pass) {
        $error = $lang->get('login_missing_fields');
    } else {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($pass, $user['password'])) {
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'email' => $user['email'],
                    'role'  => $user['role']
                ];
                header('Location: index.php');
                exit;
            } else {
                $error = $lang->get('login_invalid_credentials');
            }
        } catch (Exception $e) {
            $error = $lang->get('login_error') . ' : ' . $e->getMessage();
        }
    }
}

// Affichage du formulaire
View::render('login', [
    'title' => $lang->get('login_title'),
    'error' => $error,
    'lang'  => $lang
]);
