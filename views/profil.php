<?php
// views/profil.php — Formulaire modification profil utilisateur (Fusion V2.5)
// ----------------------------------------------------
?>

<h2><?= htmlspecialchars($lang->get('profil_title')) ?></h2>

<?php if (!empty($message)): ?>
    <div class="success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" class="profil-form">
    <label><?= htmlspecialchars($lang->get('profil_email')) ?></label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <label><?= htmlspecialchars($lang->get('profil_password')) ?></label>
    <input type="password" name="new_password" placeholder="<?= htmlspecialchars($lang->get('profil_password_placeholder')) ?>">

    <label><?= htmlspecialchars($lang->get('profil_lang')) ?></label>
    <select name="lang">
        <?php foreach ($availableLangs as $code => $label): ?>
            <option value="<?= $code ?>" <?= $user['lang'] == $code ? 'selected' : '' ?>><?= $label ?></option>
        <?php endforeach; ?>
    </select>

    <label><?= htmlspecialchars($lang->get('profil_theme')) ?></label>
    <select name="theme">
        <?php foreach ($availableThemes as $t): ?>
            <option value="<?= $t ?>" <?= $user['theme'] == $t ? 'selected' : '' ?>><?= $t ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit"><?= htmlspecialchars($lang->get('profil_save')) ?></button>
</form>