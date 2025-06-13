<?php
// profil.php — Gestion du profil utilisateur V3 (centralisé via loader)

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/pdo.php';
require_once __DIR__ . '/includes/settings.php';
require_once __DIR__ . '/includes/View.php';
require_once __DIR__ . '/includes/loader.php';

// ✅ Connexion PDO
$pdo = getPDO();
$message = '';

// ✅ Récupère l'ID utilisateur depuis la session
$userId = $_SESSION['user']['id'];

// ✅ Charge les infos utilisateur depuis la base
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ Traitement de la modification du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $newPass = trim($_POST['new_password'] ?? '');
    $langUser = trim($_POST['lang'] ?? '');
    $themeUser = trim($_POST['theme'] ?? '');

    // ✅ Mise à jour email, langue et thème
    $stmt = $pdo->prepare("UPDATE users SET email = ?, lang = ?, theme = ? WHERE id = ?");
    $stmt->execute([$email, $langUser, $themeUser, $userId]);

    // ✅ Mise à jour mot de passe uniquement si fourni
    if (!empty($newPass)) {
        $hash = password_hash($newPass, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hash, $userId]);
    }

    // ✅ Met à jour la session email
    $_SESSION['user']['email'] = $email;
    $message = $lang->get('profil_saved');

    // Recharge user après modification
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ✅ Recharge aussi langue et thème dynamiquement après modif
    $theme = $user['theme'] ?: getSetting('theme');
    $langCode = $user['lang'] ?: getSetting('lang');
    $lang = new Lang($langCode);
}

// ✅ Liste des choix possibles
$availableThemes = ['emeraldnight', 'emeraldday'];
$availableLangs = ['fr' => 'Français', 'en' => 'English'];

// ✅ Affichage via View centralisé
View::render('profil', [
    'title' => $lang->get('profil_title'),
    'logo' => getSetting('logo_path'),
    'lang' => $lang,
    'langCode' => $langCode,
    'theme' => $theme,
    'user' => $user,
    'availableThemes' => $availableThemes,
    'availableLangs' => $availableLangs,
    'message' => $message
]);
