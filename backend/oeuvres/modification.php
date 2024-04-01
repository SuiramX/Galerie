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
    $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $annee_crea = filter_input(INPUT_POST, "annee_crea", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_artiste = filter_input(INPUT_POST, "id_artiste", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    echo "test";

    // Insérer les données dans la base de données
    $stmt = $conn->prepare("
UPDATE oeuvres
JOIN artiste ON artiste.id = oeuvres.id_artiste
SET oeuvres.titre = :titre, 
    oeuvres.description = :description, 
    oeuvres.annee_crea = :annee_crea, 
    oeuvres.id_artiste = artiste.id,
    oeuvres.id_artiste = :id_artiste
WHERE oeuvres.id = :id
    ;");
    var_dump($titre);
    var_dump($description);
    var_dump($annee_crea);
    var_dump($id_artiste);
    var_dump($id);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':annee_crea', $annee_crea);
    $stmt->bindParam(':id_artiste', $id_artiste);
    $stmt->bindParam(':id', $id);

    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        echo 'oeuvre modifiée';
    }
    else {
        //Affiche le problème de la modification
        echo 'Erreur lors de la modification de l\'oeuvre';
    }
}
else {
    echo "ici";
}
header("Location: ../../frontend/oeuvres.php");