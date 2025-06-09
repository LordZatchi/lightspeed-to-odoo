<!-- home.php — Vue de base après installation -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/template/emeraldnight/css/base.css">
    <link rel="stylesheet" href="/template/emeraldnight/css/layout.css">
    <link rel="stylesheet" href="/template/emeraldnight/css/components.css">
    <link rel="stylesheet" href="/template/emeraldnight/css/theme.css">
</head>

<body>
    <div class="install-container">
        <h1><?= htmlspecialchars($title) ?></h1>
        <p><?= htmlspecialchars($message) ?></p>
    </div>
</body>

</html>