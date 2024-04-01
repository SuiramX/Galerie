<?php

$id = filter_input(INPUT_POST, 'idd', FILTER_SANITIZE_NUMBER_INT);

var_dump($id);

include '../config.php';
$servername = config::SERVEUR;
$username = config::UTILISATEUR;
$password = config::MOTDEPASSE;
$dbname = config::BASEDEDONNEES;

$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);

$co = $conn->prepare("DELETE FROM planning WHERE planning.id = :id");
$co->bindParam(':id', $id);
$co->execute();
if ($co->rowCount() == 1) {
    echo 'planning supprimé';
} else {
    echo 'erreur';
}

header('Location: ../../frontend/plannings.php');