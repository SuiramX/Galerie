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
    $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lieu = filter_input(INPUT_POST, "lieu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telephone = filter_input(INPUT_POST, "telephone", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rs = filter_input(INPUT_POST, "rs", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $born = filter_input(INPUT_POST, "born", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nom_artiste = filter_input(INPUT_POST, "nom_artiste", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    echo "test";


    // Insérer les données dans la base de données


    $stmt = $conn->prepare("UPDATE artiste
SET nom = :nom, mail = :mail, prenom = :prenom, lieu = :lieu, telephone = :telephone, rs = :rs, born = :born, nom_artiste = :nom_artiste 
WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':lieu', $lieu);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':rs', $rs);
    $stmt->bindParam(':born', $born);
    $stmt->bindParam(':nom_artiste', $nom_artiste);
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
header("Location: ../../frontend/artiste.php");

