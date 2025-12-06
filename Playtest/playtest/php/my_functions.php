<?php
// sae203/php/myfunctions.php

// Inclusion du fichier de configuration pour récupérer les constantes de connexion à la base
include_once(__DIR__ . '/../admin/config.php');

try {
    // Création de la connexion PDO en utilisant les constantes définies dans config.php
    $pdo = new PDO(DB, USER, PWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Mode de récupération des résultats
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

// Exemple d'une fonction qui pourrait être utilisée dans myfunctions.php
function ajouterNote($jeu_id, $note, $personne_id) {
    global $pdo; // On utilise la connexion PDO définie plus haut

    // Insertion de la note dans la table sae203_notes
    $stmt = $pdo->prepare("INSERT INTO sae203_notes (personne, jeux, note) VALUES (?, ?, ?)");
    $stmt->execute([$personne_id, $jeu_id, $note]);

    // Recalculer la note moyenne du jeu
    $stmt = $pdo->prepare("SELECT AVG(note) as moyenne FROM sae203_notes WHERE jeux = ?");
    $stmt->execute([$jeu_id]);
    $result = $stmt->fetch();
    $nouvelle_moyenne = round($result['moyenne'], 1);

    // Mettre à jour la note dans la table sae203_jeux
    $stmt = $pdo->prepare("UPDATE sae203_jeux SET note = ? WHERE id = ?");
    $stmt->execute([$nouvelle_moyenne, $jeu_id]);

    return $nouvelle_moyenne; // Retourne la nouvelle note moyenne
}
?>
