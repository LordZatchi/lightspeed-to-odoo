<?php
// admin/users.php — Gestion des utilisateurs (admin uniquement)

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';

Guard::admin(); // accès réservé

$lang = new Lang(); // ✅ utilise la langue dynamique (via settings.lang)
$pdo = getPDO();
$message = null;

// ✏️ Traitement d’ajout d’un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if ($email && $pass && in_array($role, ['user', 'admin'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() == 0) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hash, $role]);
            $message = $lang->get('users_add_success');
        } else {
            $message = $lang->get('users_add_exists');
        }
    } else {
        $message = $lang->get('users_add_error');
    }
}

// 🗑 Suppression d’un utilisateur (sauf soi-même)
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if ($id !== (int) $_SESSION['user']['id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $message = $lang->get('users_deleted');
    }
}

// 📋 Récupération des utilisateurs
$users = $pdo->query("SELECT id, email, role FROM users ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

// 👁 Vue
View::render('admin_users', [
    'title' => $lang->get('users_title'),
    'users' => $users,
    'message' => $message,
    'lang' => $lang
]);
