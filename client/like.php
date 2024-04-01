<?php
include_once '../config.php';

$pdo = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);


    $query = "UPDATE oeuvre SET likes = likes + 1 WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();

    $newLikes = getLikes($pdo, $id);

    echo json_encode(array('likes' => $newLikes));

function updateDislikes($pdo, $id) {
    $query = "UPDATE oeuvre SET dislike = dislike + 1 WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();

    $newDislikes = getDislikes($pdo, $id);

    echo json_encode(array('dislikes' => $newDislikes));
    exit; // Assurez-vous de sortir du script après l'envoi de la réponse JSON
}
?>