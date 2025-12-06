<link rel="stylesheet" href="/sae203/css/page_exemple.css">

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $message_connexion = "Vous devez être connecté pour laisser une note ou un commentaire.";
} else {
    $message_connexion = "";
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/includes/header-exemple.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/admin/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/php/my_functions.php";
require_once __DIR__ . "/includes/load-css.php";

if (isset($_GET['id'])) {
    $jeu_id = intval($_GET['id']);

    try {
        $pdo = new PDO(DB, USER, PWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base : " . $e->getMessage());
    }

    $stmt = $pdo->prepare("SELECT * FROM sae203_jeux WHERE id = ?");
    $stmt->execute([$jeu_id]);
    $jeu = $stmt->fetch();

    if ($jeu) {
        echo '<div class="jeu-details">';
        echo "<img src='/sae203/uploads/" . htmlspecialchars($jeu['image_details_url']) . "' alt='Image de " . htmlspecialchars($jeu['titre']) . "'>";
        echo '<h1>' . htmlspecialchars($jeu['titre']) . '</h1>';
        echo '<p>' . htmlspecialchars($jeu['description']) . '</p>';
        echo '<p class="creation">Créé le : ' . htmlspecialchars($jeu['creation']) . '</p>';
        echo '<p class="note">Note moyenne : ' . htmlspecialchars($jeu['note']) . '/5</p>';
        echo '<a href="' . htmlspecialchars($jeu['lien_steam']) . '" class="lien-steam" target="_blank">Voir sur Steam</a>';
        echo '</div>';
    } else {
        echo "<p>Le jeu n'existe pas ou l'ID est incorrect.</p>";
    }
} else {
    echo "<p>Identifiant du jeu manquant.</p>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $note = floatval($_POST['note']);
        $commentaire = htmlspecialchars($_POST['commentaire']);

        if ($note >= 0 && $note <= 5) {
            $stmt = $pdo->prepare("INSERT INTO sae203_notes (personne, jeux, note) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $jeu_id, $note]);

            $stmt = $pdo->prepare("SELECT AVG(note) as moyenne FROM sae203_notes WHERE jeux = ?");
            $stmt->execute([$jeu_id]);
            $result = $stmt->fetch();
            $nouvelle_moyenne = round($result['moyenne'], 1);

            $stmt = $pdo->prepare("UPDATE sae203_jeux SET note = ? WHERE id = ?");
            $stmt->execute([$nouvelle_moyenne, $jeu_id]);

            if (!empty($commentaire)) {
                $stmt = $pdo->prepare("INSERT INTO sae203_reviews (personne, jeux, date, commentaire) VALUES (?, ?, NOW(), ?)");
                $stmt->execute([$_SESSION['user_id'], $jeu_id, $commentaire]);
            }

            echo "<p>Votre note et votre commentaire ont été soumis !</p>";
        } else {
            echo "<p>La note doit être entre 0 et 5.</p>";
        }
    }
}
?>

<?php if (isset($_SESSION['user_id'])): ?>
    <form action="page_exemple.php?id=<?php echo $jeu_id; ?>" method="POST">
        <label for="note">Votre note (0-5) :</label>
        <input type="number" name="note" min="0" max="5" step="0.1" required><br>

        <label for="commentaire">Votre commentaire :</label>
        <textarea name="commentaire" required></textarea><br>

        <button type="submit" name="submit">Soumettre la note et le commentaire</button>
    </form>
<?php else: ?>
    <p class="centre"><?php echo $message_connexion; ?></p>
    <a id="centrer" href="login.php">Se connecter</a> pour laisser une note ou un commentaire.
<?php endif; ?>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/includes/footer-exemple.php"; ?>
