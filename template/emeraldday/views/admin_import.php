<!-- admin_import.php — Vue admin avec mapping dynamique -->
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
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <!-- Upload CSV -->
        <form method="post" enctype="multipart/form-data" style="margin-bottom: 2rem;">
            <label><?= $lang->get('import_upload_label') ?> :
                <input type="file" name="csv_file" accept=".csv" required>
            </label>
            <button type="submit"><?= $lang->get('import_upload_button') ?></button>
        </form>

        <!-- Mapping dynamique -->
        <?php if (!empty($columns)): ?>
            <hr>
            <h2><?= $lang->get('import_columns_title') ?></h2>

            <form method="post" action="import.php">
                <input type="hidden" name="mapping_file" value="<?= htmlspecialchars($filename) ?>">

                <label><?= $lang->get('mapping_name_label') ?> :
                    <input type="text" name="mapping_name" required>
                </label>

                <table style="width:100%; border-collapse: collapse; margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th><?= $lang->get('csv_column') ?></th>
                            <th><?= $lang->get('odoo_field') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($columns as $col): ?>
                            <tr>
                                <td><?= htmlspecialchars($col) ?></td>
                                <td>
                                    <select name="mapping[<?= htmlspecialchars($col) ?>]">
                                        <option value=""><?= $lang->get('no_mapping') ?></option>
                                        <?php foreach ($odoo_fields as $field): ?>
                                            <option value="<?= $field ?>">
                                                <?= $lang->get('odoo_field_' . $field) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="install-actions" style="margin-top: 1.5rem;">
                    <button type="submit"><?= $lang->get('mapping_save_button') ?></button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>