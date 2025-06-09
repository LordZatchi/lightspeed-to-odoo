<?php
// includes/auth.php — Gestion de l'authentification (session + rôle)

require_once __DIR__ . '/pdo.php';

// ⚠️ Démarrage de la session si ce n’est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vérifie si un utilisateur est connecté
 *
 * @return bool
 */
function isLogged(): bool
{
    return isset($_SESSION['user']);
}

/**
 * Vérifie si l'utilisateur actuel est administrateur
 *
 * @return bool
 */
function isAdmin(): bool
{
    return isLogged() && ($_SESSION['user']['role'] ?? '') === 'admin';
}

/**
 * Classe utilitaire pour restreindre l'accès à certaines pages
 */
class Guard
{
    /**
     * Empêche l'accès aux utilisateurs non connectés
     */
    public static function user()
    {
        if (!isLogged()) {
            header('Location: /login.php');
            exit;
        }
    }

    /**
     * Empêche l'accès aux utilisateurs non administrateurs
     */
    public static function admin()
    {
        if (!isAdmin()) {
            header('Location: /index.php');
            exit;
        }
    }
}
