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

        <?php if (empty($logs)): ?>
            <p><?= $lang->get('logs_none') ?></p>
        <?php else: ?>
            <table class="log-table">
                <thead>
                    <tr>
                        <th><?= $lang->get('logs_date') ?></th>
                        <th><?= $lang->get('logs_user') ?></th>
                        <th><?= $lang->get('logs_file') ?></th>
                        <th><?= $lang->get('logs_mapping') ?></th>
                        <th><?= $lang->get('logs_status') ?></th>
                        <th><?= $lang->get('logs_message') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['created_at']) ?></td>
                            <td><?= htmlspecialchars($log['email']) ?></td>
                            <td><?= htmlspecialchars($log['file_name']) ?></td>
                            <td><?= htmlspecialchars($log['mapping_name'] ?? '-') ?></td>
                            <td style="color:<?= $log['status'] === 'success' ? 'green' : 'red' ?>;">
                                <?= ucfirst($log['status']) ?>
                            </td>
                            <td><?= htmlspecialchars($log['message']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- 📄 Pagination -->
            <div style="margin-top: 2rem; text-align: center;">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?= $currentPage - 1 ?>"><?= $lang->get('pagination_prev') ?></a>
                <?php endif; ?>

                <span style="margin: 0 1rem;">
                    <?= $lang->get('pagination_page') ?> <?= $currentPage ?> / <?= $totalPages ?>
                </span>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?= $currentPage + 1 ?>"><?= $lang->get('pagination_next') ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>