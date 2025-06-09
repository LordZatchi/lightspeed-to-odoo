<!-- admin_users.php — Vue gestion des utilisateurs -->
<!DOCTYPE html>
<html lang="fr">

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

        <form method="post" style="margin-bottom: 2rem;">
            <input type="hidden" name="add_user" value="1">
            <label><?= $lang->get('users_email') ?> :
                <input type="email" name="email" required>
            </label>
            <label><?= $lang->get('users_password') ?> :
                <input type="password" name="password" required>
            </label>
            <label><?= $lang->get('users_role') ?> :
                <select name="role">
                    <option value="user"><?= $lang->get('users_role_user') ?></option>
                    <option value="admin"><?= $lang->get('users_role_admin') ?></option>
                </select>
            </label>
            <button type="submit"><?= $lang->get('users_add_button') ?></button>
        </form>

        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><?= $lang->get('users_email') ?></th>
                    <th><?= $lang->get('users_role') ?></th>
                    <th><?= $lang->get('users_actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($lang->get('users_role_' . $u['role'])) ?></td>
                        <td>
                            <?php if ($u['id'] != $_SESSION['user']['id']): ?>
                                <a href="?delete=<?= $u['id'] ?>" onclick="return confirm('<?= $lang->get('users_confirm_delete') ?>')">
                                    <?= $lang->get('users_delete_button') ?>
                                </a>
                            <?php else: ?>
                                <em><?= $lang->get('users_self') ?></em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>