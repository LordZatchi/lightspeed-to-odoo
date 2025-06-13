<?php
// Vue admin_import_real.php — Importation réelle des CSV (Phase 4 Fusion V2.5)
?>

<h2><?= htmlspecialchars($lang->get('import_title')) ?></h2>

<?php if (!empty($message)): ?>
    <div class="import-error"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <label><?= htmlspecialchars($lang->get('import_user_file')) ?></label>
    <input type="file" name="csv_file" required>

    <label><?= htmlspecialchars($lang->get('import_user_mapping')) ?></label>
    <select name="selected_mapping" required>
        <?php foreach ($mappings as $map): ?>
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