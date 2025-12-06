<?php
session_start();
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <title>Playtest - Tous les jeux</title>
    <?php require_once __DIR__ . "/includes/load-css.php"; ?>
</head>
<body>
<div id="particles-js"></div>
<?php require_once __DIR__ . "/includes/header-exemple.php"; ?>

<h1 class="h1">Tous les jeux référencés sur Playtest</h1>

<!-- Filter Dropdown -->
<select id="ratingFilter">
    <option value="all" <?php echo (!isset($_GET['filter']) || $_GET['filter'] == 'all') ? 'selected' : ''; ?>>Tous les jeux</option>
    <option value="above4" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'above4') ? 'selected' : ''; ?>>Note au dessus de 4</option>
</select>

<?php
require_once __DIR__ . "/admin/config.php";

// Get the filter value from the request (default is 'all')
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

try {
    $pdo = new PDO(DB, USER, PWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

// Modify the query based on the filter
if ($filter == 'above4') {
    $stmt = $pdo->prepare("SELECT id, titre, image_url, note as note_moyenne FROM sae203_jeux WHERE note > 4");
} else {
    $stmt = $pdo->prepare("SELECT id, titre, image_url, note as note_moyenne FROM sae203_jeux");
}

$stmt->execute();
$jeux = $stmt->fetchAll();

if (empty($jeux)) {
    echo "<p>Aucun jeu trouvé dans la base de données.</p>";
} else {
    echo '<table id="gamesTable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th onclick="sortTable(0)">Jeu</th>';
    echo '<th onclick="sortTable(1)">Note moyenne</th>';
    echo '<th>Illustration</th>';
    echo '<th>+</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($jeux as $jeu) {
        echo '<tr>';
        echo '<td class="police-jeux" >' . htmlspecialchars($jeu['titre']) . '</td>';
        echo '<td class="color-rate" >' . htmlspecialchars($jeu['note_moyenne']) . '/5</td>';
        echo '<td><img src="/sae203/uploads/' . htmlspecialchars($jeu['image_url']) . '" alt="Image de ' . htmlspecialchars($jeu['titre']) . '" style="width: 100px; height: auto;"></td>';
        echo '<td><a href="/sae203/page_exemple.php?id=' . $jeu['id'] . '" class="btn-details">Voir les détails</a></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
?>

<?php require_once __DIR__ . "/includes/footer-exemple.php"; ?>
<?php require_once __DIR__ . "/includes/load-js.php"; ?>

<script>
    // JavaScript to handle filter selection and page reload
    document.getElementById("ratingFilter").addEventListener("change", function() {
        var filterValue = this.value;
        window.location.href = "all_games.php?filter=" + filterValue;  // Reload page with filter
    });
</script>

</body>
</html>
