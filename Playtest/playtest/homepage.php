<?php
session_start();
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <title>Playtest - Nos jeux du moment</title>
    <?php require_once __DIR__ . "/includes/load-css.php"; ?>
</head>
<body>

<!-- Conteneur des particules -->
<div id="particles-js"></div>

<?php require_once __DIR__ . "/includes/header-exemple.php"; ?>

<h1 class="h1">Nos jeux du moment</h1>

<?php
require_once __DIR__ . "/admin/config.php";

try {
    $pdo = new PDO(DB, USER, PWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT id, titre, image_url, note as note_moyenne FROM sae203_jeux LIMIT 4");
$stmt->execute();
$jeux = $stmt->fetchAll();

if (empty($jeux)) {
    echo "<p>Aucun jeu trouvé dans la base de données.</p>";
} else {
    echo '<section class="jeux-container">';
    foreach ($jeux as $jeu) {
        echo '<article class="jeu-card">';
        echo '<img src="/sae203/uploads/' . htmlspecialchars($jeu['image_url']) . '" alt="Image de ' . htmlspecialchars($jeu['titre']) . '">';
        echo '<h2>' . htmlspecialchars($jeu['titre']) . '</h2>';
        echo '<p>Note moyenne : ' . htmlspecialchars($jeu['note_moyenne']) . '/5</p>';
        echo '<a href="/sae203/page_exemple.php?id=' . $jeu['id'] . '">Voir les détails</a>';
        echo '</article>';
    }
    echo '</section>';
}
echo '<br>';
?>

<?php require_once __DIR__ . "/includes/footer-exemple.php"; ?>
<?php require_once __DIR__ . "/includes/load-js.php"; ?>

</body>
</html>
