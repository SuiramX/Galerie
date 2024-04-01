<?php

$id = filter_input(INPUT_POST, 'idd', FILTER_SANITIZE_NUMBER_INT);

include '../config.php';
$servername = config::SERVEUR;
$username = config::UTILISATEUR;
$password = config::MOTDEPASSE;
$dbname = config::BASEDEDONNEES;

$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);

$co = $conn->prepare("DELETE FROM agence WHERE id = :id");
$co->bindParam(':id', $id);

$co->execute();

header('Location: ../../frontend/lieu.php');