<?php
// includes/odoo.php — Communication sécurisée avec Odoo (V2.5.5.1 blindée et stabilisée)

require_once __DIR__ . '/crypto.php';
require_once __DIR__ . '/settings.php';
require_once __DIR__ . '/Lang.php';

/**
 * Authentifie l’utilisateur Odoo (login)
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
    return $decoded['result'] ?? null;
}

/**
 * Envoi d'un produit vers Odoo (enrichi avec gestion blindée des erreurs)
 */
function sendToOdoo(string $url, string $db, string $user, string $pass, array $data): array
{
    $lang = new Lang(getSetting('lang'));

    $uid = odooAuthenticate($url, $db, $user, $pass);
    if (!$uid) {
        return [
            'success' => false,
            'message' => $lang->get('odoo_auth_failed'),
            'odoo_error' => 'Invalid login or credentials'
        ];
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
        return [
            'success' => false,
            'message' => $lang->get('odoo_no_response'),
            'odoo_error' => 'No response from Odoo'
        ];
    }

    $decoded = json_decode($response, true);

    if (isset($decoded['result'])) {
        return [
            'success' => true,
            'message' => $lang->get('odoo_create_success') . ' ID: ' . $decoded['result'],
            'odoo_id' => $decoded['result']
        ];
    } elseif (isset($decoded['error'])) {

        // Analyse sécurisée et blindée de l'erreur Odoo
        $errorRaw = $decoded['error']['data']['message'] ?? $decoded['error']['message'] ?? 'Unknown Odoo error';

        // Toujours forcer à du texte safe
        if (is_array($errorRaw)) {
            $errorData = json_encode($errorRaw, JSON_UNESCAPED_UNICODE);
        } else {
            $errorData = (string)$errorRaw;
        }

        return [
            'success' => false,
            'message' => $lang->get('odoo_failed') . ': ' . $errorData,
            'odoo_error' => $errorData
        ];
    }

    return [
        'success' => false,
        'message' => $lang->get('odoo_unknown_error'),
        'odoo_error' => 'Unknown error'
    ];
}
