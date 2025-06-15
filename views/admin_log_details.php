<?php
// Vue admin_log_details.php — Détails ligne à ligne de l'import
?>

<h2><?= htmlspecialchars($fileName) ?></h2>

<table class="log-details-table">
    <thead>
        <tr>
            <th>#</th>
            <th><?= htmlspecialchars($lang->get('logs_status')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_message')) ?></th>
            <th>Odoo ID</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $index => $res): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $res['success'] ? '✅' : '❌' ?></td>
                <td><?= htmlspecialchars($res['message']) ?></td>
                <td><?= $res['odoo_id'] ?? '-' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="logs.php">⬅ <?= htmlspecialchars($lang->get('logs_back')) ?></a></p>