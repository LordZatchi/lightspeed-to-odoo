<?php
// Vue admin_mapping_create.php — Formulaire de création mapping CSV ↔ Odoo
?>

<h2><?= htmlspecialchars($lang->get('mappings_title')) ?></h2>

<?php if (!empty($message)): ?>
    <div class="success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (empty($columns)): ?>

    <!-- Étape 1 : upload du fichier -->
    <form method="post" enctype="multipart/form-data">
        <label><?= htmlspecialchars($lang->get('import_user_file')) ?></label>
        <input type="file" name="csv_file" required>
        <button type="submit"><?= htmlspecialchars($lang->get('import_user_button')) ?></button>
    </form>

<?php else: ?>

    <!-- Étape 2 : mapping des colonnes -->
    <form method="post">
        <label><?= htmlspecialchars($lang->get('mappings_name')) ?></label>
        <input type="text" name="mapping_name" required><br><br>

        <?php foreach ($columns as $column): ?>
            <label><?= htmlspecialchars($column) ?></label>
            <select name="mapping[<?= htmlspecialchars($column) ?>]">
                <option value="">-- <?= htmlspecialchars($lang->get('mappings_ignore')) ?> --</option>
                <?php foreach ($odoo_fields as $odoo_field): ?>
                    <option value="<?= $odoo_field ?>"><?= $odoo_field ?></option>
                <?php endforeach; ?>
            </select><br><br>
        <?php endforeach; ?>

        <button type="submit"><?= htmlspecialchars($lang->get('mappings_save')) ?></button>
    </form>

<?php endif; ?>