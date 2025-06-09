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

        <!-- 📥 Upload fichier CSV -->
        <form method="post" enctype="multipart/form-data" style="margin-bottom: 2rem;">
            <label><?= $lang->get('import_upload_label') ?> :
                <input type="file" name="csv_file" accept=".csv" required>
            </label>
            <button type="submit"><?= $lang->get('import_upload_button') ?></button>
        </form>

        <!-- 🧩 Mapping CSV vers Odoo -->
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

        <!-- 🔁 Import réel vers Odoo -->
        <?php if (!empty($availableMappings)): ?>
            <hr>
            <h2><?= $lang->get('import_real_title') ?></h2>

            <form method="post" enctype="multipart/form-data">
                <label><?= $lang->get('import_real_mapping_label') ?> :
                    <select name="selected_mapping" required>
                        <option value=""><?= $lang->get('choose_mapping') ?></option>
                        <?php foreach ($availableMappings as $m): ?>
                            <option value="<?= $m['id'] ?>">
                                <?= htmlspecialchars($m['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label><br><br>

                <label><?= $lang->get('import_upload_label') ?> :
                    <input type="file" name="csv_real_file" accept=".csv" required>
                </label><br><br>

                <button type="submit" name="import_real"><?= $lang->get('import_real_button') ?></button>
            </form>
        <?php endif; ?>

        <!-- ✅ Résultats d'envoi ligne par ligne -->
        <?php if (!empty($results)): ?>
            <hr>
            <h2><?= $lang->get('import_results_title') ?></h2>
            <ul>
                <?php foreach ($results as $i => $res): ?>
                    <li style="color: <?= $res['success'] ? 'green' : 'red' ?>;">
                        <?= $lang->get('import_row') . ' ' . ($i + 1) ?> : <?= htmlspecialchars($res['message']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>

</html>