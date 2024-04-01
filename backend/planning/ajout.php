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


$dates = 'SELECT debut_expo, fin_expo FROM planning WHERE id_oeuvres = :id_oeuvres';
if (!$conn) {
    die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}
echo 'Connexion à la base de données effectuée avec succès.';

//Vérifie que les dates saisies sur l'interface ne soient pas déjà saisies
if (isset($_POST['submit'])) {

    $id_oeuvres = filter_input(INPUT_POST, "id_oeuvres", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $debut_expo = filter_input(INPUT_POST, "debut_expo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fin_expo = filter_input(INPUT_POST, "fin_expo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    foreach ($dates as $date) {
        if ($debut_expo >= $date['debut_expo'] && $debut_expo <= $date['fin_expo']) {
            echo 'La date de début d\'exposition est déjà saisie';
            exit;
        }
        if ($fin_expo >= $date['debut_expo'] && $fin_expo <= $date['fin_expo']) {
            echo 'La date de fin d\'exposition est déjà saisie';
            exit;
        }
    }
    $stmt = $conn->prepare($dates);
    $stmt->bindParam(':id_oeuvres', $id_oeuvres);
    $stmt->execute();
    $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

// Insérer dans la base de données
if (isset($_POST['submit'])) {

    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $titre= filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nom_agence = filter_input(INPUT_POST, "nom_agence", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $debut_expo = filter_input(INPUT_POST, "debut_expo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fin_expo = filter_input(INPUT_POST, "fin_expo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    var_dump($nom_agence);
    var_dump($debut_expo);
    var_dump($titre);


    // Insérer les données dans la base de données

    $stmt = $conn->prepare("INSERT INTO planning (id_oeuvres, id_agence, debut_expo, fin_expo) VALUES (:titre, :nom_agence, :debut_expo, :fin_expo)");

    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':nom_agence', $nom_agence);
    $stmt->bindParam(':debut_expo', $debut_expo);
    $stmt->bindParam(':fin_expo', $fin_expo);
    $stmt->execute();

} else {
    echo "ici";
}
header("Location: ../../frontend/plannings.php");
?>
