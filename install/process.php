<?php
// install/process.php — Traite l'installation initiale et génère config + base

require_once __DIR__ . '/../includes/Lang.php';
$lang = new Lang(); // ✅ utilise la langue dynamique (via settings.lang)

// Sécurité
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die($lang->get('install_network_error'));
}

// Récupération des données
$db_host   = trim($_POST['db_host'] ?? '');
$db_name   = trim($_POST['db_name'] ?? '');
$db_user   = trim($_POST['db_user'] ?? '');
$db_pass   = trim($_POST['db_pass'] ?? '');
$odoo_url  = trim($_POST['odoo_url'] ?? '');
$odoo_db = trim($_POST['odoo_db'] ?? '');
$odoo_user = trim($_POST['odoo_user'] ?? '');
$odoo_pass = trim($_POST['odoo_pass'] ?? '');
$odoo_api  = trim($_POST['odoo_api'] ?? '');
$site_name = trim($_POST['site_name'] ?? '');
$site_theme = trim($_POST['site_theme'] ?? 'emeraldnight');
$admin_email = trim($_POST['admin_email'] ?? '');
$admin_pass  = $_POST['admin_pass'] ?? '';

// Vérification minimale
if (!$db_host || !$db_name || !$db_user || !$odoo_url || !$odoo_db || !$odoo_user || !$odoo_pass || !$site_name || !$admin_email || !$admin_pass) {
    die($lang->get('install_network_error'));
}

// Test MySQL
try {
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die($lang->get('install_mysql_error') . ' : ' . $e->getMessage());
}

// Création du fichier config.php
$config = [
    'db_host'   => $db_host,
    'db_name'   => $db_name,
    'db_user'   => $db_user,
    'db_pass'   => base64_encode($db_pass),
    'odoo_url'  => $odoo_url,
    'odoo_db'   => $odoo_db,
    'odoo_user' => $odoo_user,
    'odoo_pass' => base64_encode($odoo_pass),
    'odoo_api'  => base64_encode($odoo_api),
    'theme'     => $site_theme,
    'lang'      => 'fr',
];

$configContent = "<?php\n\$config = " . var_export($config, true) . ";\n";
file_put_contents(__DIR__ . '/../config.php', $configContent);

// Création des tables
$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) DEFAULT 'admin',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        `key` VARCHAR(100) UNIQUE NOT NULL,
        `value` TEXT
    );
");

// Table des logs d'import CSV (historique)
$pdo->exec("
    CREATE TABLE IF NOT EXISTS import_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        mapping_id INT DEFAULT NULL,
        file_name VARCHAR(255) NOT NULL,
        total_lines INT DEFAULT 0,
        success_lines INT DEFAULT 0,
        failed_lines INT DEFAULT 0,
        status VARCHAR(20) DEFAULT 'pending',
        message TEXT,
        details TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
");

// Table de stockage des modèles de mapping CSV ↔ Odoo
$pdo->exec("
    CREATE TABLE IF NOT EXISTS mappings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        data TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
");

// Insertion de l'admin
$hash = password_hash($admin_pass, PASSWORD_DEFAULT);

// Vérifie si l'utilisateur admin existe déjà
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
$stmt->execute([$admin_email]);
if ($stmt->fetchColumn() == 0) {
    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'admin')");
    $stmt->execute([$admin_email, $hash]);
}

// Enregistrement des settings initiaux
$settings = [
    'site_name' => $site_name,
    'theme' => $site_theme
];

foreach ($settings as $key => $value) {
    $stmt = $pdo->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?)");
    $stmt->execute([$key, $value]);
}

// Upload du logo
if (!empty($_FILES['site_logo']['tmp_name'])) {
    if (!is_dir(__DIR__ . '/../uploads')) {
        mkdir(__DIR__ . '/../uploads', 0755, true);
    }
    move_uploaded_file($_FILES['site_logo']['tmp_name'], __DIR__ . '/../uploads/logo.png');
}

// Définition de la langue par défaut ('fr') dans les paramètres globaux
$stmt = $pdo->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)");
$stmt->execute(['lang', 'fr']);

// Fin
header('Location: ../index.php');
exit;
