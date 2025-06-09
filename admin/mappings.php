<?php
// admin/mappings.php — Gestion des modèles de mapping

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pdo.php';
require_once __DIR__ . '/../includes/View.php';
require_once __DIR__ . '/../includes/Lang.php';

Guard::admin();

$lang = new Lang();
$pdo = getPDO();
$message = null;

// 🗑 Suppression d’un mapping
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM mappings WHERE id = ?");
    $stmt->execute([$id]);

    $message = $lang->get('mapping_deleted');
    header("Location: mappings.php?success=1");
    exit;
}

// 📄 Lecture des mappings existants
$stmt = $pdo->query("SELECT id, name, created_at FROM mappings ORDER BY created_at DESC");
$mappings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 🎨 Vue
View::render('admin_mappings', [
    'title' => $lang->get('mappings_title'),
    'message' => $message ?? ($_GET['success'] ?? false ? $lang->get('mapping_deleted') : ''),
    'mappings' => $mappings,
    'lang' => $lang
]);
