<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/admin/config.php";

    try {
        $pdo = new PDO(DB, USER, PWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base : " . $e->getMessage());
    }

    $stmt = $pdo->prepare("SELECT id FROM sae203_personnes WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO sae203_personnes (prenom, nom, email, mot_de_passe, inscription) VALUES (?, ?, ?, ?, NOW())");

        if ($stmt->execute([$prenom, $nom, $email, $mot_de_passe])) {
            echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/includes/load-css.php"; ?>
</head>
<body>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/includes/header-exemple.php"; ?>

<div class="form-container">
    <form class="login-form" action="register.php" method="POST">
        <h2>Inscription</h2>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required><br>

        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required><br>

        <button type="submit">S'inscrire</button>
    </form>
    <?php require_once __DIR__ . "/includes/load-js.php"; ?>
</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/sae203/includes/footer-exemple.php"; ?>

</body>
</html>
