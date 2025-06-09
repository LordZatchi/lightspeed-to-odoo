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
            <p style="color: red; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <?php if (!empty($availableMappings)): ?>
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
                    <input type="file" name="csv_file" accept=".csv" required>
                </label><br><br>

                <button type="submit"><?= $lang->get('import_real_button') ?></button>
            </form>
        <?php else: ?>
            <p><?= $lang->get('no_mapping_available') ?></p>
        <?php endif; ?>

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