<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/admin/config.php";

try {
    $pdo = new PDO(DB, USER, PWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

$stmt = $pdo->prepare("
    SELECT j.id AS jeu_id, j.titre, j.image_url, n.note, r.commentaire
    FROM sae203_jeux j
    LEFT JOIN sae203_notes n ON j.id = n.jeux AND n.personne = ?
    LEFT JOIN sae203_reviews r ON j.id = r.jeux AND r.personne = ?
    WHERE n.personne = ? OR r.personne = ?
");
$stmt->execute([$_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id']]);
$jeux_utilisateur = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Notes - Playtest</title>
    <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/includes/load-css.php"; ?>
    <link rel="stylesheet" href="css/my_rate.css">
</head>
<body>
<div id="particles-js"></div>
<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/includes/header-exemple.php"; ?>

<h1>Mes Notes et Commentaires</h1>

<?php if (empty($jeux_utilisateur)): ?>
    <p>Vous n'avez pas encore noté ou commenté de jeux.</p>
<?php else: ?>
    <div class="jeux-container">
        <?php foreach ($jeux_utilisateur as $jeu): ?>
            <div class="jeu-card">
                <img src="/sae203/uploads/<?php echo htmlspecialchars($jeu['image_url']); ?>" alt="Image de <?php echo htmlspecialchars($jeu['titre']); ?>" width="150">
                <h3><?php echo htmlspecialchars($jeu['titre']); ?></h3>
                <p>Note : <?php echo htmlspecialchars($jeu['note']); ?>/5</p>
                <p>Commentaire :
                    <?php echo isset($jeu['commentaire']) && !empty($jeu['commentaire']) ? htmlspecialchars($jeu['commentaire']) : 'Aucun commentaire'; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php require_once __DIR__ . "/includes/load-js.php"; ?>
<?php endif; ?>

<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/includes/footer-exemple.php"; ?>

</body>
</html>
