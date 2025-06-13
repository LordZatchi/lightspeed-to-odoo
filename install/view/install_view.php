<?php
// Vue install_view.php — Formulaire d'installation complet
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($langCode) ?>">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($lang->get('install_title')) ?></title>
</head>

<body>

    <h1><?= htmlspecialchars($lang->get('install_title')) ?></h1>

    <form method="post" action="process.php">

        <h2><?= htmlspecialchars($lang->get('db_section')) ?></h2>

        <label>MySQL Host :
            <input type="text" name="db_host" required>
        </label><br>

        <label>MySQL Database :
            <input type="text" name="db_name" required>
        </label><br>

        <label>MySQL User :
            <input type="text" name="db_user" required>
        </label><br>

        <label>MySQL Password :
            <input type="password" name="db_pass" required>
        </label><br>

        <h2><?= htmlspecialchars($lang->get('site_section')) ?></h2>

        <label><?= htmlspecialchars($lang->get('site_title')) ?> :
            <input type="text" name="site_title" required>
        </label><br>

        <label><?= htmlspecialchars($lang->get('site_theme')) ?> :
            <select name="theme">
                <?php foreach ($themes as $t): ?>
                    <option value="<?= $t ?>"><?= $t ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>

        <label><?= htmlspecialchars($lang->get('site_lang')) ?> :
            <select name="lang">
                <?php foreach ($langs as $code => $label): ?>
                    <option value="<?= $code ?>"><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>

        <h2><?= htmlspecialchars($lang->get('admin_section')) ?></h2>

        <label><?= htmlspecialchars($lang->get('admin_email')) ?> :
            <input type="email" name="admin_email" required>
        </label><br>

        <label><?= htmlspecialchars($lang->get('admin_pass')) ?> :
            <input type="password" name="admin_pass" required>
        </label><br>

        <button type="submit"><?= htmlspecialchars($lang->get('install_button')) ?></button>
    </form>

</body>

</html>