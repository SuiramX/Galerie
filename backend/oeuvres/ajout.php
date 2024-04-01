<?php
// Inclusion du fichier de configuration
include '../config.php';

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BASEDEDONNEES, config::UTILISATEUR, config::MOTDEPASSE);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion à la base de données effectuée avec succès.';
} catch(PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Vérification de la soumission du formulaire
if (isset($_POST['submit'])) {
    // Nettoyage des données entrantes
    $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $annee_crea = filter_input(INPUT_POST, "annee_crea", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nom_artiste = filter_input(INPUT_POST, "nom_artiste", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Déplacement du fichier d'oeuvre vers le répertoire désigné
    $img_directory = "../image/";
    $extension = pathinfo($_FILES['oeuvre']['name'], PATHINFO_EXTENSION);
    $nom_image = "img_" . bin2hex(random_bytes(16)) . "." . $extension;
    $img_path = $img_directory . $nom_image;
    move_uploaded_file($_FILES['oeuvre']['tmp_name'], $img_path);

    // Préparation et exécution de la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO oeuvres (titre, description, annee_crea, id_artiste, image) VALUES (:titre, :description, :annee_crea, :nom_artiste, :oeuvre)");
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':annee_crea', $annee_crea);
    $stmt->bindParam(':nom_artiste', $nom_artiste);
    $stmt->bindParam(':oeuvre', $nom_image);
    $stmt->execute();

    // Redirection vers la page des oeuvres après l'insertion
    header("Location: ../../frontend/oeuvres.php");
    exit(); // Arrêt de l'exécution du script après la redirection
}

// Création du répertoire pour stocker les images si inexistant
if (!is_dir("../image")) {
    mkdir("../image");
}
?>
