<?php
// sae203/admin/reset.php
// Inclusion des constantes de connexion depuis config.php
include_once(__DIR__ . '/config.php');

// Création de la connexion PDO en utilisant les constantes définies dans config.php
try {
    $pdo = new PDO(DB, USER, PWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gérer les erreurs
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Mode de récupération des résultats
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

// Lire le fichier SQL contenant les instructions pour réinitialiser la base
$sqlFile = __DIR__ . '/init.sql';
if (!file_exists($sqlFile)) {
    die("Le fichier init.sql n'existe pas.");
}

$sql = file_get_contents($sqlFile);

try {
    // Exécuter l'ensemble des requêtes SQL contenues dans init.sql
    $pdo->exec($sql);
    echo "Réinitialisation réussie.";
} catch (PDOException $e) {
    echo "Erreur lors de la réinitialisation : " . $e->getMessage();
}
header("Location: /sae203/homepage.php");
exit();
?>
