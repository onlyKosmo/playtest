<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header - Playtest</title>
    <link rel="stylesheet" type="text/css" href="/sae203/css/header.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link rel="icon" href="/sae203/uploads/favicon-16x16.png" sizes="16x16" type="image/png">
</head>
<body>
<header>
    <nav class="navbar">
        <!-- Logo -->
        <div id="logo-container">
            <a id="typo_logo" href="homepage.php">PLAYTEST</a>
        </div>

        <!-- Menu de navigation -->
        <ul>
            <li><a href="all_games.php">Jeux</a></li>
            <li><a href="my_rate.php">Mes notes</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Si l'utilisateur est connecté, afficher un lien pour se déconnecter -->
                <li><a href="logout.php">Déconnexion</a></li>
            <?php else: ?>
                <!-- Sinon, afficher un lien pour se connecter -->
                <li><a href="login.php">Connexion</a></li>
            <?php endif; ?>
        </ul>

        <!-- Formulaire de recherche -->
        <div id="search-container">
            <form action="search_results.php" method="GET">
                <input type="text" name="search" placeholder="Rechercher un jeu..." required>
                <button type="submit">Rechercher</button>
            </form>
        </div>
    </nav>
</header>