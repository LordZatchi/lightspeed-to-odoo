<?php
// /test/odoo_encrypt_tool.php — Générateur visuel d'encrypt AES pour odoo_pass

require_once __DIR__ . '/../includes/crypto.php';

$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clearText = trim($_POST['odoo_pass']);
    if (!empty($clearText)) {
        $crypted = encrypt($clearText);
        $result = $crypted;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Générateur AES Odoo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        input[type=text],
        input[type=password] {
            width: 400px;
            padding: 5px;
        }

        pre {
            background: #eee;
            padding: 10px;
        }
    </style>
</head>

<body>

    <h1>Générateur d’encrypt AES pour odoo_pass</h1>

    <form method="post">
        <label>Mot de passe Odoo à crypter :</label><br><br>
        <input type="password" name="odoo_pass" required>
        <br><br>
        <button type="submit">Générer</button>
    </form>

    <?php if (!empty($result)): ?>
        <h2>Résultat chiffré AES :</h2>
        <pre><?= htmlspecialchars($result) ?></pre>

        <p>⚠ Copie cette valeur et remplace-la manuellement dans la colonne <b>settings.odoo_pass</b> via phpMyAdmin.</p>
    <?php endif; ?>

</body>

</html>