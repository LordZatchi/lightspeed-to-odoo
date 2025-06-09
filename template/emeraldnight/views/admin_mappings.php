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

        <?php if (empty($mappings)): ?>
            <p><?= $lang->get('mapping_none') ?></p>
        <?php else: ?>
            <table class="log-table">
                <thead>
                    <tr>
                        <th><?= $lang->get('mapping_name') ?></th>
                        <th><?= $lang->get('mapping_date') ?></th>
                        <th><?= $lang->get('mapping_actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mappings as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['name']) ?></td>
                            <td><?= htmlspecialchars($m['created_at']) ?></td>
                            <td>
                                <!-- ✏ Modifier -->
                                <a href="edit_mapping.php?id=<?= $m['id'] ?>"><?= $lang->get('mapping_edit') ?></a> |
                                <!-- 🗑 Supprimer -->
                                <a href="?delete=<?= $m['id'] ?>" onclick="return confirm('<?= $lang->get('mapping_confirm_delete') ?>');">
                                    <?= $lang->get('mapping_delete') ?>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>