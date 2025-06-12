<!-- views/login.php -->

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($langCode) ?>">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Le CSS est automatiquement géré via ton thème -->
</head>

<body class="login-page">

    <div class="login-container">

        <?php if (!empty($logo)): ?>
            <div class="logo">
                <img src="<?= htmlspecialchars($logo) ?>" alt="Logo" style="max-height: 120px;">
            </div>
        <?php endif; ?>

        <h1><?= htmlspecialchars($title) ?></h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="login-form">
            <label>
                <?= htmlspecialchars($lang->get('login_email')) ?>
                <input type="email" name="email" required>
            </label>

            <label>
                <?= htmlspecialchars($lang->get('login_password')) ?>
                <input type="password" name="password" required>
            </label>

            <button type="submit"><?= htmlspecialchars($lang->get('login_button')) ?></button>
        </form>

    </div>

</body>

</html>