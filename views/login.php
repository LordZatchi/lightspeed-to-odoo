<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= Lang::get('login_title') ?></title>
    <link rel="stylesheet" href="<?= $cssPath ?>base.css">
    <link rel="stylesheet" href="<?= $cssPath ?>layout.css">
    <link rel="stylesheet" href="<?= $cssPath ?>components.css">
    <link rel="stylesheet" href="<?= $cssPath ?>theme.css">
</head>

<body>
    <div class="container">
        <h1><?= Lang::get('login_title') ?></h1>

        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="email" name="email" placeholder="<?= Lang::get('email') ?>" required><br>
            <input type="password" name="password" placeholder="<?= Lang::get('password') ?>" required><br>
            <button type="submit"><?= Lang::get('login_button') ?></button>
        </form>
    </div>
</body>

</html>