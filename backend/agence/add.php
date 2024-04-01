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

$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$conn) {
    die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}
echo 'Connexion à la base de données effectuée avec succès.';

// Insérer dans la base de données
if (isset($_POST['submit'])) {

    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nom_agence = filter_input(INPUT_POST, "nom_agence", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $adresse = filter_input(INPUT_POST, "adresse", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ville = filter_input(INPUT_POST, "ville", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nom_dirigeant = filter_input(INPUT_POST, "nom_dirigeant", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $numero = filter_input(INPUT_POST, "numero", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    echo"test";



    // Insérer les données dans la base de données


    $stmt = $conn->prepare("INSERT INTO agence (nom_agence, adresse, ville, email, nom_dirigeant, numero) VALUES (:nom_agence, :adresse, :ville, :email, :nom_dirigeant, :numero)");
    echo"test";
    $stmt->bindParam(':nom_agence', $nom_agence);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':ville', $ville);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nom_dirigeant', $nom_dirigeant);
    $stmt->bindParam(':numero', $numero);
    $stmt->execute();



} else {
    echo "ici";
}
header("Location: ../../frontend/lieu.php");
?>
