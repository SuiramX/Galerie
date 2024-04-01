<?php
// Connexion à la base de données
include '../backend/config.php';

$servername = config::SERVEUR;
$username = config::UTILISATEUR;
$password = config::MOTDEPASSE;
$dbname = config::BASEDEDONNEES;

$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);

// Vérification des données POST
if(isset($_POST['oeuvre_id']) && isset($_POST['action'])) {
    $oeuvreId = $_POST['oeuvre_id'];
    $action = $_POST['action'];

    // Mise à jour des likes ou dislikes selon l'action
    if($action == 'like') {
        $sql = "UPDATE oeuvres SET likes = likes + 1 WHERE id = :oeuvreId";
    } elseif ($action == 'dislike') {
        $sql = "UPDATE oeuvres SET dislikes = dislikes + 1 WHERE id = :oeuvreId";
    }

    // Exécution de la requête préparée
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':oeuvreId', $oeuvreId);
    $stmt->execute();

    // Récupération des nouveaux nombres de likes et dislikes pour l'oeuvre
    $sql = "SELECT likes, dislikes FROM oeuvres WHERE id = :oeuvreId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':oeuvreId', $oeuvreId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Affichage des nouveaux nombres de likes et dislikes
    echo "<a href=\"#\" id=\"likeButton\"><i class=\"fa-sharp fa-solid fa-heart\"></i></a> " . $result['likes'] . " ";
    echo "<a href=\"#\" id=\"dislikeButton\"><i class=\"fa-solid fa-heart-crack\"></i></a> " . $result['dislikes'];
}
?>
