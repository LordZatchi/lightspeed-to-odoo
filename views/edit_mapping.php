<?php
// Vue admin_edit_mapping.php — Edition d'un mapping CSV ↔ Odoo
?>

<h2><?= htmlspecialchars($lang->get('mappings_edit_title')) ?></h2>

<form method="post">
    <?php foreach ($csv_columns as $column): ?>
        <div>
            <label><?= htmlspecialchars($column) ?></label>
            <select name="mapping[<?= htmlspecialchars($column) ?>]">
                <option value="">-- <?= htmlspecialchars($lang->get('mappings_ignore')) ?> --</option>
                <?php foreach ($odoo_fields as $odoo_field): ?>
                    <option value="<?= $odoo_field ?>" <?= (isset($data[$column]) && $data[$column] === $odoo_field) ? 'selected' : '' ?>>
                        <?= $odoo_field ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endforeach; ?>
    <button type="submit"><?= htmlspecialchars($lang->get('mappings_save')) ?></button>
</form>