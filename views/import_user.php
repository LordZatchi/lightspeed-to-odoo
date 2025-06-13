<?php
// views/import_user.php — Import CSV avancé Phase 4 V3
// ----------------------------------------------------
// Cette vue gère :
// - Upload du CSV
// - Sélection du modèle de mapping existant
// - Prévisualisation automatique des colonnes CSV
// - Affichage des premières lignes du fichier pour contrôle
// ----------------------------------------------------
?>

<h2><?= htmlspecialchars($lang->get('import_user_title')) ?></h2>

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

<?php if (!empty($headers)): ?>
    <h3><?= htmlspecialchars($lang->get('import_user_preview_title')) ?></h3>

    <table class="preview-table">
        <thead>
            <tr>
                <?php foreach ($headers as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($previewRows as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= htmlspecialchars($cell) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>