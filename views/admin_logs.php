<?php
// Vue admin_logs.php — Historique des imports (V1)
// ----------------------------------------------------
?>

<h2><?= htmlspecialchars($lang->get('logs_title')) ?></h2>

<table class="logs-table">
    <thead>
        <tr>
            <th><?= htmlspecialchars($lang->get('logs_date')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_user')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_file')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_mapping')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_status')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_message')) ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= htmlspecialchars($log['created_at']) ?></td>
                <td><?= htmlspecialchars($log['user_email'] ?? '-') ?></td>
                <td><?= htmlspecialchars($log['file_name']) ?></td>
                <td><?= htmlspecialchars($log['mapping_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($log['status']) ?></td>
                <td><?= htmlspecialchars($log['message']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>