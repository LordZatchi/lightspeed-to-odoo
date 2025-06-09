<?php
// install/test.php — Teste les connexions MySQL et Odoo (avec champ odoo_db)

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/Lang.php';
$lang = new Lang(); // ✅ utilise la langue dynamique (via settings.lang)

// Vérification méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => $lang->get('install_network_error')]);
    exit;
}

// Récupération des données
$db_host   = $_POST['db_host'] ?? '';
$db_name   = $_POST['db_name'] ?? '';
$db_user   = $_POST['db_user'] ?? '';
$db_pass   = $_POST['db_pass'] ?? '';
$odoo_url  = rtrim($_POST['odoo_url'] ?? '', '/');
$odoo_db   = $_POST['odoo_db'] ?? '';
$odoo_user = $_POST['odoo_user'] ?? '';
$odoo_pass = $_POST['odoo_pass'] ?? '';

// Connexion MySQL
try {
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $lang->get('install_mysql_error') . ' : ' . $e->getMessage()]);
    exit;
}

// Connexion Odoo
$auth_payload = [
    'jsonrpc' => '2.0',
    'method'  => 'call',
    'params'  => [
        'service' => 'common',
        'method'  => 'login',
        'args'    => [$odoo_db, $odoo_user, $odoo_pass]
    ],
    'id' => 1
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => json_encode($auth_payload),
        'timeout' => 5
    ]
];

$response = @file_get_contents("$odoo_url/jsonrpc", false, stream_context_create($options));
$data = json_decode($response, true);

if (!$response || !isset($data['result'])) {
    echo json_encode(['success' => false, 'message' => $lang->get('install_odoo_error')]);
    exit;
}

echo json_encode(['success' => true]);
