<?php
// includes/odoo.php — Envoi JSON-RPC vers Odoo (multilingue via $lang)

/**
 * Envoie un produit vers Odoo via JSON-RPC
 * @param array $data — Données du produit format Odoo
 * @param Lang $lang — Instance de Lang (multilingue)
 * @return array — [success => true/false, message => string]
 */
function sendToOdoo(array $data, Lang $lang): array
{
    $configPath = __DIR__ . '/../config.php';
    if (!file_exists($configPath)) {
        return ['success' => false, 'message' => $lang->get('odoo_config_missing')];
    }

    include $configPath;

    if (
        empty($config['odoo_url']) ||
        empty($config['odoo_user']) ||
        empty($config['odoo_pass']) ||
        empty($config['odoo_db'])
    ) {
        return ['success' => false, 'message' => $lang->get('odoo_config_incomplete')];
    }

    $url  = rtrim($config['odoo_url'], '/') . '/jsonrpc';
    $user = $config['odoo_user'];
    $pass = base64_decode($config['odoo_pass']);
    $db   = $config['odoo_db'];

    // Authentification
    $authPayload = [
        'jsonrpc' => '2.0',
        'method' => 'call',
        'params' => [
            'service' => 'common',
            'method' => 'login',
            'args' => [$db, $user, $pass]
        ],
        'id' => 1
    ];

    $authContext = stream_context_create([
        'http' => [
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode($authPayload),
            'timeout' => 5
        ]
    ]);

    $authResponse = @file_get_contents($url, false, $authContext);
    $authData = json_decode($authResponse, true);

    if (!isset($authData['result'])) {
        return ['success' => false, 'message' => $lang->get('odoo_auth_failed')];
    }

    $uid = $authData['result'];

    // Requête de création produit
    $payload = [
        'jsonrpc' => '2.0',
        'method' => 'call',
        'params' => [
            'service' => 'object',
            'method' => 'execute_kw',
            'args' => [
                $db,
                $uid,
                $pass,
                'product.template',
                'create',
                [$data]
            ]
        ],
        'id' => 2
    ];

    $context = stream_context_create([
        'http' => [
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode($payload),
            'timeout' => 5
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    $result = json_decode($response, true);

    if (isset($result['result'])) {
        return [
            'success' => true,
            'message' => $lang->get('odoo_create_success') . ' (ID ' . $result['result'] . ')'
        ];
    }

    $errorMsg = $result['error']['message'] ?? $lang->get('odoo_create_unknown_error');
    return ['success' => false, 'message' => $errorMsg];
}
