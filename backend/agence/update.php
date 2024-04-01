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
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nom_dirigeant = filter_input(INPUT_POST, "nom_dirigeant", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $adresse = filter_input(INPUT_POST, "adresse", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $numero = filter_input(INPUT_POST, "numero", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    echo "test";


    // Insérer les données dans la base de données


    $stmt = $conn->prepare("UPDATE agence
SET nom_agence = :nom_agence, email = :email, nom_dirigeant = :nom_dirigeant, adresse = :adresse, numero = :numero
WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom_agence', $nom_agence);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nom_dirigeant', $nom_dirigeant);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':numero', $numero);
    $stmt->execute();


#vérifier que la requête s'est bien effectuée
//    if ($stmt->rowCount() == 1) {
//        //header("Location: ../frontend/index.php");
//    } else {
//        echo "Erreur lors de la création du post";
//        header("Refresh: 4;url=index.php");
//    }
//
//}
// Fermer la connexion
//    mysqli_close($conn);
} else {
    echo "ici";
}
header("Location: ../../frontend/lieu.php");

