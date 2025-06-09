<!-- install_view.php — Vue d'installation complète (corrigée avec odoo_db) -->
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
        <form id="install-form" method="post" action="process.php" enctype="multipart/form-data">
            <fieldset>
                <legend><?= $lang->get('install_mysql_title') ?></legend>
                <label><?= $lang->get('install_mysql_host') ?> :
                    <input type="text" name="db_host" required>
                </label>
                <label><?= $lang->get('install_mysql_name') ?> :
                    <input type="text" name="db_name" required>
                </label>
                <label><?= $lang->get('install_mysql_user') ?> :
                    <input type="text" name="db_user" required>
                </label>
                <label><?= $lang->get('install_mysql_pass') ?> :
                    <input type="password" name="db_pass">
                </label>
            </fieldset>

            <fieldset>
                <legend><?= $lang->get('install_odoo_title') ?></legend>
                <label><?= $lang->get('install_odoo_url') ?> :
                    <input type="text" name="odoo_url" required>
                </label>
                <label><?= $lang->get('install_odoo_db') ?> :
                    <input type="text" name="odoo_db" required>
                </label>
                <label><?= $lang->get('install_odoo_login') ?> :
                    <input type="text" name="odoo_user" required>
                </label>
                <label><?= $lang->get('install_odoo_pass') ?> :
                    <input type="password" name="odoo_pass" required>
                </label>
                <label><?= $lang->get('install_odoo_api') ?> :
                    <input type="text" name="odoo_api">
                </label>
            </fieldset>

            <fieldset>
                <legend><?= $lang->get('install_appearance_title') ?></legend>
                <label><?= $lang->get('install_site_name') ?> :
                    <input type="text" name="site_name" required>
                </label>
                <label><?= $lang->get('install_site_logo') ?> :
                    <input type="file" name="site_logo" accept="image/png, image/jpeg">
                </label>

                <div class="theme-selector">
                    <label>
                        <input type="radio" name="site_theme" value="emeraldnight" checked>
                        <img src="/template/emeraldnight/preview.png" alt="Emerald Night">
                        <span><?= $lang->get('install_theme_night') ?></span>
                    </label>
                    <label>
                        <input type="radio" name="site_theme" value="emeraldday">
                        <img src="/template/emeraldday/preview.png" alt="Emerald Day">
                        <span><?= $lang->get('install_theme_day') ?></span>
                    </label>
                </div>
            </fieldset>

            <fieldset>
                <legend><?= $lang->get('install_admin_title') ?></legend>
                <label><?= $lang->get('install_admin_email') ?> :
                    <input type="email" name="admin_email" required>
                </label>
                <label><?= $lang->get('install_admin_pass') ?> :
                    <input type="password" name="admin_pass" required>
                </label>
            </fieldset>

            <div class="install-actions">
                <button type="button" onclick="testConnections()"><?= $lang->get('install_test_button') ?></button>
                <button type="submit"><?= $lang->get('install_submit_button') ?></button>
            </div>
            <div id="install-status"></div>
        </form>
    </div>

    <script>
        const installLang = {
            testing: "<?= $lang->get('install_testing') ?>",
            mysql_error: "<?= $lang->get('install_mysql_error') ?>",
            odoo_error: "<?= $lang->get('install_odoo_error') ?>",
            success: "<?= $lang->get('install_success') ?>",
            network_error: "<?= $lang->get('install_network_error') ?>"
        };
    </script>
    <script src="/install/install.js"></script>
</body>

</html>