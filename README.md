# playtest
Playtest est une plateforme en ligne permettant aux utilisateurs de découvrir, noter et commenter des jeux vidéo. Les utilisateurs peuvent s'inscrire, se connecter, et interagir avec une base de données de jeux classés par des notes et des critiques. Le site propose de consulter des jeux, soumettre des avis et explorer de nouveaux titres.

Fonctionnalités du site :

1. Page d'accueil (homepage.php)
   Présentation des jeux récents : Sur la page d'accueil, les utilisateurs peuvent voir une sélection de jeux populaires, avec une note moyenne et une image d'illustration pour chaque jeu.

Barre de recherche : En haut à droite de la page, une barre de recherche permet de rechercher un jeu par titre. Les résultats sont affichés sur une page dédiée (search\_results.php).

Styles dynamiques : Le site utilise des effets visuels tels que des particules en fond pour améliorer l'expérience utilisateur.

2. Page des jeux (all\_games.php)
   Liste des jeux : Cette page présente tous les jeux référencés sur la plateforme. Chaque jeu est accompagné de son titre, de son image et de sa note moyenne.

Fonctionnalité de tri : Les utilisateurs peuvent trier les jeux en fonction de leur titre ou de leur note en cliquant sur le haut du tableau "Jeu" ordre alphabétique et "Note moyenne" ordre croissant des notes .

3. Inscription et Connexion (register.php et login.php)
   Inscription : Les utilisateurs peuvent créer un compte en renseignant leur prénom, nom, email et mot de passe. Les informations sont stockées dans la base de données.

Connexion : Les utilisateurs peuvent se connecter avec leur adresse e-mail et leur mot de passe. Une fois connectés, ils ont accès à leurs propres notes et commentaires sur les jeux.
Utilisateur de test (optionnel, car possibilité d'en créer un) : Utilisateur : Djibril	Lamroussi	Email : djibril.lamroussi@dbd.com	Mot de passe : chef

4. Page de détails des jeux (page\_exemple.php)
   Description détaillée : Chaque jeu a sa propre page de détails, affichant une description complète, la date de création, le lien vers Steam, et sa note moyenne.

Système de notation : Les utilisateurs connectés peuvent attribuer une note de 0 à 5 et laisser un commentaire sur le jeu. Ces notes sont ensuite utilisées pour calculer la note moyenne du jeu.

5. Mes notes (my\_rate.php)
   Liste des jeux notés : Les utilisateurs peuvent voir tous les jeux qu'ils ont notés et commentés.

Gestion des notes : Les utilisateurs peuvent consulter et modifier leurs critiques et notes existantes pour les jeux qu'ils ont évalués.

6. Déconnexion (logout.php)
   Gestion de session : Les utilisateurs peuvent se déconnecter du site à tout moment, ce qui met fin à leur session et les redirige vers la page de connexion.
7. Réinitialisation du site (admin/reset.php)
   Réinitialisation des données : La page reset.php permet de restaurer le site à son état initial, utile pour les tests ou la gestion des données pendant le développement.
   De plus, un bouton "Restaurer le site" est prêsent dans le footer ayant la même utilité.

Technologies utilisées :
PHP : Le backend du site est développé avec PHP, permettant la gestion des utilisateurs, des jeux, des notes et des commentaires.

MySQL : La base de données MySQL est utilisée pour stocker toutes les informations sur les jeux, les utilisateurs, les notes, et les commentaires.

HTML/CSS : La structure et le design du site sont réalisés avec HTML et CSS, offrant une interface claire et moderne.

JavaScript : Des scripts JavaScript (comme particles.js) sont utilisés pour ajouter des effets visuels et dynamiser l'interaction sur le site.

Résumé des principales fonctionnalités :
Gestion des utilisateurs : Inscription, connexion et déconnexion des utilisateurs.

Système de notation et commentaires : Possibilité d'attribuer des notes et de laisser des commentaires sur les jeux.

Exploration des jeux : Recherche, consultation, et affichage des jeux avec leurs informations et critiques (barre de recherche en haut à droite).

