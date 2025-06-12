<?php
// includes/odoo.php
// --------------------------------------------------
// Gestion des interactions avec Odoo via JSON-RPC sécurisé
// --------------------------------------------------

require_once __DIR__ . '/crypto.php';
require_once __DIR__ . '/settings.php';
require_once __DIR__ . '/Lang.php';

// On récupère la langue active globalement
$langCode = getSetting('lang') ?: 'fr';
$lang = new Lang($langCode);

/**
 * Teste la connexion à Odoo (authentification simple)
 *
 * @param string $url   URL du serveur Odoo
 * @param string $user  Identifiant Odoo
 * @param string $pass  Mot de passe Odoo
 * @param string|null $db Base de données Odoo
 * @return bool
 */
function testOdooConnection(string $url, string $user, string $pass, ?string $db = null): bool
{
    if (!$url || !$user || !$pass || !$db) return false;

    $endpoint = rtrim($url, '/') . '/jsonrpc';

    $data = [
        'jsonrpc' => '2.0',
        'method' => 'call',
        'id' => 1,
        'params' => [
            'service' => 'common',
            'method' => 'login',
            'args' => [$db, $user, $pass]
        ]
    ];

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return false;

    $decoded = json_decode($response, true);
    return isset($decoded['result']) && is_numeric($decoded['result']);
}

/**
 * Authentifie l’utilisateur sur Odoo et récupère son UID
 *
 * @param string $url
 * @param string $db
 * @param string $user
 * @param string $pass
 * @return int|null
 */
function odooAuthenticate(string $url, string $db, string $user, string $pass): ?int
{
    $endpoint = rtrim($url, '/') . '/jsonrpc';

    $payload = [
        'jsonrpc' => '2.0',
        'method' => 'call',
        'id' => 1,
        'params' => [
            'service' => 'common',
            'method' => 'login',
            'args' => [$db, $user, $pass]
        ]
    ];

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($response, true);

    return isset($decoded['result']) ? intval($decoded['result']) : null;
}

/**
 * Envoie les données d’un produit vers Odoo
 *
 * @param string $url
 * @param string $db
 * @param string $user
 * @param string $pass
 * @param array $data
 * @return array Résultat avec success/message
 */
function sendToOdoo(string $url, string $db, string $user, string $pass, array $data): array
{
    global $lang;

    $uid = odooAuthenticate($url, $db, $user, $pass);
    if (!$uid) {
        return ['success' => false, 'message' => $lang->get('odoo_auth_failed')];
    }

    $endpoint = rtrim($url, '/') . '/jsonrpc';

    $payload = [
        'jsonrpc' => '2.0',
        'method' => 'call',
        'id' => 1,
        'params' => [
            'service' => 'object',
            'method' => 'execute_kw',
            'args' => [$db, $uid, $pass, 'product.template', 'create', [$data]]
        ]
    ];

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        return ['success' => false, 'message' => $lang->get('odoo_no_response')];
    }

    $decoded = json_decode($response, true);

    if (isset($decoded['result'])) {
        return ['success' => true, 'message' => $lang->get('odoo_create_success') . ' ID: ' . $decoded['result']];
    } elseif (isset($decoded['error'])) {
        return ['success' => false, 'message' => $decoded['error']['message']];
    }

    return ['success' => false, 'message' => $lang->get('odoo_unknown_error')];
}
