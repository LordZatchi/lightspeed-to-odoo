<!-- login.php — Vue du formulaire de connexion -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/template/<?= $theme ?>/css/base.css">
    <link rel="stylesheet" href="/template/<?= $theme ?>/css/layout.css">
    <link rel="stylesheet" href="/template/<?= $theme ?>/css/components.css">
    <link rel="stylesheet" href="/template/<?= $theme ?>/css/theme.css">
</head>

<body>
    <div class="install-container">
        <h1><?= $lang->get('login_title') ?></h1>

        <?php if (!empty($error)): ?>
            <div class="error-message" style="color: red; font-weight: bold; margin-bottom: 1rem;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/login.php">
            <label><?= $lang->get('login_email') ?> :
                <input type="email" name="email" required>
            </label>
            <label><?= $lang->get('login_password') ?> :
                <input type="password" name="password" required>
            </label>
            <div class="install-actions">
                <button type="submit"><?= $lang->get('login_submit') ?></button>
            </div>
        </form>
    </div>
</body>

</html>