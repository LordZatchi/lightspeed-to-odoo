<?php
// install/process.php — Traitement de l'installation sécurisée (Fusion V2.5)
// ---------------------------------------------------------------------
// Crée la base MySQL, installe les tables, génère config.php avec cryptage AES.
// ---------------------------------------------------------------------

require_once __DIR__ . '/../includes/crypto.php';

// ✅ Lecture des données du formulaire
$db_host = trim($_POST['db_host']);
$db_name = trim($_POST['db_name']);
$db_user = trim($_POST['db_user']);
$db_pass = trim($_POST['db_pass']);

$site_title = trim($_POST['site_title']);
$theme = trim($_POST['theme']);
$lang = trim($_POST['lang']);

// ✅ Connexion brute MySQL (avant PDO)
$mysqli = new mysqli($db_host, $db_user, $db_pass);

if ($mysqli->connect_error) {
    die("Erreur MySQL: " . $mysqli->connect_error);
}

// ✅ Création de la base si inexistante
$mysqli->query("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
$mysqli->select_db($db_name);

// ✅ Création des tables USERS
$mysqli->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','user') DEFAULT 'user',
    lang VARCHAR(10) DEFAULT NULL,
    theme VARCHAR(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ✅ Création des tables SETTINGS
$mysqli->query("
CREATE TABLE IF NOT EXISTS settings (
    `key` VARCHAR(50) PRIMARY KEY,
    `value` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ✅ Création des tables MAPPINGS
$mysqli->query("
CREATE TABLE IF NOT EXISTS mappings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    data TEXT,
    csv_columns TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ✅ Création des tables IMPORT_LOGS
$mysqli->query("
CREATE TABLE IF NOT EXISTS import_logs (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ✅ Insertion de l'utilisateur administrateur initial
$admin_email = trim($_POST['admin_email']);
$admin_pass = password_hash(trim($_POST['admin_pass']), PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("INSERT INTO users (email, password, role, lang, theme) VALUES (?, ?, 'admin', ?, ?)");
$stmt->bind_param("ssss", $admin_email, $admin_pass, $lang, $theme);
$stmt->execute();

// ✅ Insertion des paramètres globaux
$stmt = $mysqli->prepare("REPLACE INTO settings (`key`, `value`) VALUES (?, ?)");
$stmt->bind_param("ss", $k, $v);

$k = 'site_title';
$v = $site_title;
$stmt->execute();
$k = 'theme';
$v = $theme;
$stmt->execute();
$k = 'lang';
$v = $lang;
$stmt->execute();
$k = 'logo_path';
$v = '';
$stmt->execute();  // Prévu pour gestion future du logo

// ✅ Génération du fichier config.php chiffré AES
$config = "<?php\nreturn [\n" .
    "'db_host' => '$db_host',\n" .
    "'db_name' => '$db_name',\n" .
    "'db_user' => '$db_user',\n" .
    "'db_pass' => '" . encrypt($db_pass) . "'\n];";

file_put_contents(__DIR__ . '/../config.php', $config);

// ✅ Redirection après succès
header("Location: ../login.php");
exit;
