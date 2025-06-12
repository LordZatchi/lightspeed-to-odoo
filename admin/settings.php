<?php
// admin/settings.php — Gestion des paramètres globaux

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/crypto.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';
require_once __DIR__ . '/../includes/odoo.php';
require_once __DIR__ . '/../includes/settings.php';

Guard::admin();

$lang = new Lang();
$message = '';
$success = false;

// ✅ Traitement du formulaire après test de configuration
if (isset($_POST['test_config'])) {

    $site_title = trim($_POST['site_title'] ?? '');
    $theme = trim($_POST['theme'] ?? '');
    $lang_choice = trim($_POST['lang'] ?? '');
    $db_host = $_POST['db_host'] ?? '';
    $db_name = $_POST['db_name'] ?? '';
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';
    $odoo_url = $_POST['odoo_url'] ?? '';
    $odoo_user = $_POST['odoo_user'] ?? '';
    $odoo_pass = $_POST['odoo_pass'] ?? '';
    $odoo_db = $_POST['odoo_db'] ?? '';

    // Test connexion MySQL
    try {
        new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
        $mysql_ok = true;
    } catch (PDOException $e) {
        $mysql_ok = false;
    }

    // Test connexion Odoo
    $odoo_ok = testOdooConnection($odoo_url, $odoo_user, $odoo_pass, $odoo_db);

    if ($mysql_ok && $odoo_ok) {

        // ✅ Mise à jour de config.php
        $configContent = "<?php\nreturn [\n" .
            "'db_host' => '" . addslashes($db_host) . "',\n" .
            "'db_name' => '" . addslashes($db_name) . "',\n" .
            "'db_user' => '" . addslashes($db_user) . "',\n" .
            "'db_pass' => '" . encrypt($db_pass) . "',\n];";
        file_put_contents(__DIR__ . '/../config.php', $configContent);

        // Connexion PDO avec les nouveaux identifiants
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);

        $settings = [
            'site_title' => $site_title,
            'theme' => $theme,
            'lang' => $lang_choice,
            'odoo_url' => $odoo_url,
            'odoo_user' => $odoo_user,
            'odoo_pass' => encrypt($odoo_pass),
            'odoo_db' => $odoo_db
        ];

        // Upload du logo (optionnel)
        if (!empty($_FILES['logo']['name'])) {
            $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $logo_path = '/uploads/logo.' . $ext;
            move_uploaded_file($_FILES['logo']['tmp_name'], __DIR__ . '/../' . $logo_path);
            $settings['logo_path'] = $logo_path;
        }

        foreach ($settings as $key => $value) {
            $stmt = $pdo->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
            $stmt->execute([$key, $value]);
        }

        $message = $lang->get('settings_saved');
        $success = true;
    } else {
        $message = $lang->get('settings_test_failed');
    }
}

// ✅ Lecture dynamique du thème actif pour l'affichage (correction principale ici)
$currentTheme = getSetting('theme') ?: 'emeraldnight';

View::render('admin_settings', [
    'title' => $lang->get('settings_title'),
    'message' => $message,
    'success' => $success,
    'lang' => $lang,
    'theme' => $currentTheme
]);
