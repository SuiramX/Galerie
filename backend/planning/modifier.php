<?php

// Connexion à la base de données
#$host = 'localhost';
#$user = 'root';
#$password = '';
#$dbname = 'slam-bts-sn1-s2';

include '../config.php';
$servername = config::SERVEUR;
$username = config::UTILISATEUR;
$password = config::MOTDEPASSE;
$dbname = config::BASEDEDONNEES;

$conn = new PDO("mysql:host=" . Config::SERVEUR . ";dbname=" . Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$conn) {
    die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}
echo 'Connexion à la base de données effectuée avec succès.';

// Insérer dans la base de données
if (isset($_POST['submit'])) {
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nom_agence = filter_input(INPUT_POST, "nom_agence", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $debut_expo = filter_input(INPUT_POST, "debut_expo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fin_expo = filter_input(INPUT_POST, "fin_expo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    echo "test";
    var_dump($nom_agence);
    var_dump($debut_expo);
    var_dump($fin_expo);
    var_dump($titre);
    var_dump($id);


    // Insérer les données dans la base de données


    $stmt = $conn->prepare("UPDATE planning
SET id_agence = :id_agence, debut_expo = :debut_expo, fin_expo = :fin_expo, id_oeuvres = :id_oeuvres
WHERE id = :id");

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':id_agence', $nom_agence);
    $stmt->bindParam(':debut_expo', $debut_expo);
    $stmt->bindParam(':fin_expo', $fin_expo);
    $stmt->bindParam(':id_oeuvres', $titre);
    $stmt->execute();
#Vérifie que la requête s'est bien effectuée
    if ($stmt->rowCount() == 1) {
        echo 'planning modifié';
    } else {
        //Affiche le problème de la modification
        echo 'Erreur lors de la modification du planning';
    }
}
header("Location: ../../frontend/plannings.php");

