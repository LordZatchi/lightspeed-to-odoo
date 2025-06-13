<?php
// Vue admin_users.php — Liste des utilisateurs
?>

<h2><?= htmlspecialchars($lang->get('users_title')) ?></h2>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th><?= htmlspecialchars($lang->get('users_email')) ?></th>
            <th><?= htmlspecialchars($lang->get('users_role')) ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= (int) $user['id'] ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>