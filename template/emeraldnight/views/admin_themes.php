<!-- admin_themes.php — Vue sélection des thèmes -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/template/emeraldnight/css/base.css">
    <link rel="stylesheet" href="/template/emeraldnight/css/layout.css">
    <link rel="stylesheet" href="/template/emeraldnight/css/components.css">
    <link rel="stylesheet" href="/template/emeraldnight/css/theme.css">
</head>

<body>
    <div class="install-container">
        <h1><?= htmlspecialchars($title) ?></h1>

        <?php if (!empty($message)): ?>
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="theme-selector">
                <?php foreach ($themes as $theme): ?>
                    <label>
                        <input type="radio" name="theme" value="<?= $theme ?>" <?= $theme === $active ? 'checked' : '' ?>>
                        <img src="/template/<?= $theme ?>/preview.png" alt="<?= $theme ?>">
                        <span><?= htmlspecialchars(ucfirst($theme)) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="install-actions" style="margin-top: 2rem;">
                <button type="submit"><?= $lang->get('theme_submit') ?></button>
            </div>
        </form>
    </div>
</body>

</html>