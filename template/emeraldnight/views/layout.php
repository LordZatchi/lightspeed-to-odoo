<?php
// layout.php — EmeraldNight — View Fusion
// ----------------------------------------------------
// Structure de page pour le thème EmeraldNight
// Applique automatiquement le moteur View fusionné
// ----------------------------------------------------

$themeDir = '/template/' . htmlspecialchars($theme);
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($langCode) ?>">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Chargement dynamique des CSS -->
    <link rel="stylesheet" href="<?= $themeDir ?>/css/base.css">
    <link rel="stylesheet" href="<?= $themeDir ?>/css/layout.css">
    <link rel="stylesheet" href="<?= $themeDir ?>/css/components.css">
    <link rel="stylesheet" href="<?= $themeDir ?>/css/theme.css">
</head>

<body>

    <header class="site-header">
        <div class="logo-title">
            <?php if (!empty($logo)): ?>
                <img src="<?= htmlspecialchars($logo) ?>" alt="Logo" style="max-height:60px;">
            <?php endif; ?>
            <h1><?= htmlspecialchars($title) ?></h1>
        </div>
    </header>

    <?php include __DIR__ . '/../../../includes/menu.php'; ?>

    <main class="site-content">
        <?php include __DIR__ . '/../../../views/' . $view . '.php'; ?>
    </main>

    <footer class="site-footer">
        <p>© Lightspeed to Odoo</p>
    </footer>

</body>

</html>