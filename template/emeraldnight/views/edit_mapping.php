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
        <h1><?= htmlspecialchars($title) ?> : <?= htmlspecialchars($name) ?></h1>

        <?php if (!empty($message)): ?>
            <p style="color: red;"><?= htmlspecialchars($message) ?></p>
        <?php elseif (!empty($columns)): ?>
            <form method="post">
                <?php foreach ($columns as $csvColumn): ?>
                    <label>
                        <?= htmlspecialchars($csvColumn) ?> →
                        <select name="mapping[<?= htmlspecialchars($csvColumn) ?>]">
                            <option value=""><?= $lang->get('mapping_ignore') ?></option>
                            <?php foreach ($odoo_fields as $field): ?>
                                <option value="<?= $field ?>"
                                    <?= (isset($mapping[$csvColumn]) && $mapping[$csvColumn] === $field) ? 'selected' : '' ?>>
                                    <?= $field ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label><br><br>
                <?php endforeach; ?>

                <button type="submit"><?= $lang->get('mapping_save_button') ?></button>
                <a href="mappings.php"><?= $lang->get('back') ?></a>
            </form>
        <?php else: ?>
            <p><?= $lang->get('mapping_no_columns') ?></p>
        <?php endif; ?>
    </div>
</body>

</html>