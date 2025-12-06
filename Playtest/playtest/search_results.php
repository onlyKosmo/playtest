<?php
session_start();

// Vérifier si une requête de recherche est envoyée
if (isset($_GET['search'])) {
    $searchQuery = htmlspecialchars($_GET['search']); // Sécuriser l'entrée

    // Connexion à la base de données
    require_once __DIR__ . "/admin/config.php";

    try {
        $pdo = new PDO(DB, USER, PWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base : " . $e->getMessage());
    }

    // Requête pour rechercher des jeux en fonction du titre
    $stmt = $pdo->prepare("SELECT id, titre, image_url, note FROM sae203_jeux WHERE titre LIKE ?");
    $stmt->execute(['%' . $searchQuery . '%']); // Recherche partielle
    $jeux = $stmt->fetchAll();
} else {
    // Si aucun terme de recherche n'est envoyé, rediriger
    header("Location: homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Résultats de recherche - Playtest</title>
    <?php require_once __DIR__ . "/includes/load-css.php"; ?>
</head>
<body>

<?php require_once __DIR__ . "/includes/header-exemple.php"; ?>

<h1>Résultats pour : "<?php echo htmlspecialchars($searchQuery); ?>"</h1>

<?php
if (empty($jeux)) {
    echo "<p>Aucun jeu trouvé pour cette recherche.</p>";
} else {
    echo '<section class="jeux-container">';
    foreach ($jeux as $jeu) {
        echo '<article class="jeu-card">';
        echo '<img src="/sae203/uploads/' . htmlspecialchars($jeu['image_url']) . '" alt="Image de ' . htmlspecialchars($jeu['titre']) . '">';
        echo '<h2>' . htmlspecialchars($jeu['titre']) . '</h2>';
        echo '<p>Note moyenne : ' . htmlspecialchars($jeu['note']) . '/5</p>';
        echo '<a href="/sae203/page_exemple.php?id=' . $jeu['id'] . '">Voir les détails</a>';
        echo '</article>';
    }
    echo '</section>';
}
?>

<?php require_once __DIR__ . "/includes/footer-exemple.php"; ?>
<?php require_once __DIR__ . "/includes/load-js.php"; ?>

</body>
</html>
