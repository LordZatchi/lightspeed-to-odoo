<?php
// views/import_user.php — Import CSV utilisateur classique (Fusion V2.5)
// ----------------------------------------------------
?>

<h2><?= htmlspecialchars($lang->get('import_user_title')) ?></h2>

<form method="post" enctype="multipart/form-data">
    <label><?= htmlspecialchars($lang->get('import_user_file')) ?></label>
    <input type="file" name="csv_file" required>

    <label><?= htmlspecialchars($lang->get('import_user_mapping')) ?></label>
    <select name="selected_mapping">
        <?php foreach ($availableMappings as $map): ?>
            <option value="<?= $map['id'] ?>"><?= htmlspecialchars($map['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit"><?= htmlspecialchars($lang->get('import_user_button')) ?></button>
</form>

<?php if (!empty($results)): ?>
    <h3><?= htmlspecialchars($lang->get('import_user_results')) ?></h3>
    <ul>
        <?php foreach ($results as $res): ?>
            <li><?= $res['success'] ? '✅ ' : '❌ ' ?><?= htmlspecialchars($res['message']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>