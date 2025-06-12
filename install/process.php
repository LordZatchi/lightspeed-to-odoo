<?php
// install/process.php
// --------------------------------------------------
// Processus d'installation initiale sécurisée (avec AES)
// --------------------------------------------------

require_once __DIR__ . '/../includes/crypto.php';
require_once __DIR__ . '/../includes/Lang.php';

// Chargement langue par défaut FR au moment de l'installation
$lang = new Lang('fr');

// ✅ Récupération des données du formulaire d'installation
$db_host = trim($_POST['db_host'] ?? '');
$db_name = trim($_POST['db_name'] ?? '');
$db_user = trim($_POST['db_user'] ?? '');
$db_pass = trim($_POST['db_pass'] ?? '');
$odoo_url = trim($_POST['odoo_url'] ?? '');
$odoo_user = trim($_POST['odoo_user'] ?? '');
$odoo_pass = trim($_POST['odoo_pass'] ?? '');
$odoo_db = trim($_POST['odoo_db'] ?? '');
$site_title = trim($_POST['site_title'] ?? '');
$theme = trim($_POST['theme'] ?? 'emeraldnight');
$lang_choice = trim($_POST['lang'] ?? 'fr');

// ✅ Tentative de connexion MySQL
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit($lang->get('install_mysql_error') . ': ' . $e->getMessage());
}

// ✅ Génération du fichier config.php (chiffré)
$configContent = "<?php\nreturn [\n" .
    "'db_host' => '" . addslashes($db_host) . "',\n" .
    "'db_name' => '" . addslashes($db_name) . "',\n" .
    "'db_user' => '" . addslashes($db_user) . "',\n" .
    "'db_pass' => '" . encrypt($db_pass) . "',\n];";
file_put_contents(__DIR__ . '/../config.php', $configContent);

// ✅ Création des tables nécessaires (si non existantes)
$pdo->exec("CREATE TABLE IF NOT EXISTS settings (
    `key` VARCHAR(100) PRIMARY KEY,
    `value` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$pdo->exec("CREATE TABLE IF NOT EXISTS mappings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    data TEXT NOT NULL,
    csv_columns TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$pdo->exec("CREATE TABLE IF NOT EXISTS import_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    mapping_id INT,
    file_name VARCHAR(255),
    total_lines INT,
    success_lines INT,
    failed_lines INT,
    status VARCHAR(20),
    message TEXT,
    details LONGTEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// ✅ Enregistrement des paramètres dans settings
$settings = [
    'site_title' => $site_title,
    'theme' => $theme,
    'lang' => $lang_choice,
    'odoo_url' => $odoo_url,
    'odoo_user' => $odoo_user,
    'odoo_pass' => encrypt($odoo_pass),
    'odoo_db' => $odoo_db
];

// ✅ Upload du logo à l'installation
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

// ✅ Création du premier compte administrateur
$email_admin = trim($_POST['admin_email'] ?? '');
$password_admin = trim($_POST['admin_password'] ?? '');

if ($email_admin && $password_admin) {
    $hash = password_hash($password_admin, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'admin')");
    $stmt->execute([$email_admin, $hash]);
}

// ✅ Fin de l'installation → redirection vers l'accueil
header("Location: /index.php");
exit;
