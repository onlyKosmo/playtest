<?php
require_once __DIR__ . "/includes/header-exemple.php";
include_once(__DIR__ . "/admin/config.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    try {
        $pdo = new PDO(DB, USER, PWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base : " . $e->getMessage());
    }

    $stmt = $pdo->prepare("SELECT id, mot_de_passe FROM sae203_personnes WHERE email = ?");
    $stmt->execute([$email]);
    $utilisateur = $stmt->fetch();

    if ($utilisateur) {
        if ($mot_de_passe === $utilisateur['mot_de_passe']) {
            $_SESSION['user_id'] = $utilisateur['id'];
            header("Location: homepage.php");
            exit();
        } else {
            echo "Identifiants incorrects.";
        }
    } else {
        echo "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <title>Se connecter</title>
    <?php require_once __DIR__ . "/includes/load-css.php"; ?>
</head>
<body>
<div class="form-container">
    <form class="login-form" action="login.php" method="POST" id="login-form">
        <h2>Se connecter</h2>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required><br>

        <button type="submit">Se connecter</button>
    </form>
    <?php require_once __DIR__ . "/includes/load-js.php"; ?>
</div>
<p id="register">Pas encore de compte ? <a href="register.php" class="register-btn">Inscrivez-vous ici</a></p>
</body>
</html>
