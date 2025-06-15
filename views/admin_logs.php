<?php
// Vue admin_logs.php — Logs enrichis avec filtres (Phase 5.5)
?>

<h2><?= htmlspecialchars($lang->get('logs_title')) ?></h2>

<!-- Formulaire de filtres -->
<form method="get" class="logs-filters">

    <label>Utilisateur :</label>
    <select name="user_id">
        <option value="0">Tous</option>
        <?php foreach ($users as $u): ?>
            <option value="<?= $u['id'] ?>" <?= $filters['userId'] == $u['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($u['email']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Mapping :</label>
    <select name="mapping_id">
        <option value="0">Tous</option>
        <?php foreach ($mappings as $m): ?>
            <option value="<?= $m['id'] ?>" <?= $filters['mappingId'] == $m['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($m['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Date :</label>
    <input type="date" name="date" value="<?= htmlspecialchars($filters['date']) ?>">

    <button type="submit">Filtrer</button>
</form>

<!-- Tableau des logs -->
<table class="logs-table">
    <thead>
        <tr>
            <th><?= htmlspecialchars($lang->get('logs_date')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_user')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_file')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_mapping')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_status')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_total')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_success')) ?></th>
            <th><?= htmlspecialchars($lang->get('logs_failed')) ?></th>
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
                <td><?= (int) $log['total_lines'] ?></td>
                <td><?= (int) $log['success_lines'] ?></td>
                <td><?= (int) $log['failed_lines'] ?></td>
                <td>
                    <a href="log_details.php?id=<?= (int) $log['id'] ?>">
                        <?= htmlspecialchars($log['message']) ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>