<?php
// views/login.php — Formulaire de connexion utilisateur (Fusion V2.5)
// ----------------------------------------------------
// Vue centrale de connexion. S'intègre dans layout.php via View Fusion.
// Utilise $error pour afficher les messages d'erreur.
// ----------------------------------------------------
?>

<h2><?= htmlspecialchars($lang->get('login_title')) ?></h2>

<?php if (!empty($error)): ?>
    <div class="login-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" class="login-form">
    <label><?= htmlspecialchars($lang->get('login_email')) ?></label>
    <input type="email" name="email" required>

    <label><?= htmlspecialchars($lang->get('login_password')) ?></label>
    <input type="password" name="password" required>

    <button type="submit"><?= htmlspecialchars($lang->get('login_button')) ?></button>
</form>