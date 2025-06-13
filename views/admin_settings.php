<!DOCTYPE html>
<html lang="<?= $lang->getLangCode() ?>">

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
        <h1><?= htmlspecialchars($title) ?></h1>

        <?php if (!empty($message)): ?>
            <p style="color: <?= $success ? 'green' : 'red' ?>; font-weight: bold;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label><?= $lang->get('settings_site_title') ?> :
                <input type="text" name="site_title">
            </label><br><br>

            <label><?= $lang->get('settings_theme') ?> :
                <select name="theme">
                    <option value="emeraldnight">emeraldnight</option>
                    <option value="emeraldday">emeraldday</option>
                </select>
            </label><br><br>

            <label><?= $lang->get('settings_lang') ?> :
                <select name="lang">
                    <option value="fr">Français</option>
                    <option value="en">English</option>
                </select>
            </label><br><br>

            <label><?= $lang->get('settings_logo') ?> :
                <input type="file" name="logo" accept="image/*">
            </label><br><br>

            <fieldset>
                <legend><?= $lang->get('settings_odoo_section') ?></legend>
                <label><?= $lang->get('settings_odoo_url') ?> :
                    <input type="text" name="odoo_url">
                </label><br>
                <label><?= $lang->get('settings_odoo_user') ?> :
                    <input type="text" name="odoo_user">
                </label><br>
                <label><?= $lang->get('settings_odoo_db') ?> :
                    <input type="text" name="odoo_db">
                </label><br>
                <label><?= $lang->get('settings_odoo_pass') ?> :
                    <input type="password" name="odoo_pass" placeholder="<?= $lang->get('settings_password_placeholder') ?>">
                </label>
            </fieldset><br>

            <fieldset>
                <legend><?= $lang->get('settings_mysql_section') ?></legend>
                <label><?= $lang->get('settings_mysql_host') ?> :
                    <input type="text" name="db_host">
                </label><br>
                <label><?= $lang->get('settings_mysql_db') ?> :
                    <input type="text" name="db_name">
                </label><br>
                <label><?= $lang->get('settings_mysql_user') ?> :
                    <input type="text" name="db_user">
                </label><br>
                <label><?= $lang->get('settings_mysql_pass') ?> :
                    <input type="password" name="db_pass" placeholder="<?= $lang->get('settings_password_placeholder') ?>">
                </label>
            </fieldset><br>

            <br>
            <button type="submit" name="test_config"><?= $lang->get('settings_test_button') ?></button>
        </form>
    </div>
</body>

</html>