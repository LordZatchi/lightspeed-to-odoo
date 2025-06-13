<?php
// includes/menu.php — Menu dynamique V2 (fusionné loader + view)
// ------------------------------------------------------------
// Utilise directement la variable $lang injectée depuis le View::render()
// Ne recharge plus la langue manuellement
// ------------------------------------------------------------

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) return;

$userRole = $_SESSION['user']['role'] ?? 'user';

echo '<nav class="menu"><ul>';

echo '<li><a href="/index.php">' . $lang->get('menu_home') . '</a></li>';
echo '<li><a href="/import.php">' . $lang->get('menu_import') . '</a></li>';

if ($userRole === 'admin') {
    echo '<li><a href="/admin/import.php">' . $lang->get('menu_admin_import') . '</a></li>';
    echo '<li><a href="/admin/settings.php">' . $lang->get('menu_settings') . '</a></li>';
    echo '<li><a href="/admin/mappings.php">' . $lang->get('menu_mappings') . '</a></li>';
}

echo '<li><a href="/profil.php">' . $lang->get('menu_profil') . '</a></li>';
echo '<li><a href="/logout.php">' . $lang->get('menu_logout') . '</a></li>';

echo '</ul></nav>';
