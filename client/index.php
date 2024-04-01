<?php
include_once '../backend/config.php';
$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);
#Choisi les oeuvres
$sql = 'SELECT DISTINCT oeuvres.id, 
                titre, 
                description, 
                annee_crea, 
                likes, 
                dislikes, 
                nom_artiste, 
                image, 
                planning.id_oeuvres, 
                debut_expo, 
                fin_expo, 
                nom_agence 
FROM   oeuvres 
       JOIN artiste 
         ON oeuvres.id_artiste = artiste.id 
       LEFT JOIN (SELECT id_oeuvres, 
                         Min(fin_expo) AS premiere_date 
                  FROM   planning 
                  GROUP  BY id_oeuvres) AS premieres_dates 
              ON oeuvres.id = premieres_dates.id_oeuvres 
       LEFT JOIN planning 
              ON oeuvres.id = planning.id_oeuvres 
                 AND planning.fin_expo = premieres_dates.premiere_date 
       LEFT JOIN agence 
              ON planning.id_agence = agence.id;';
$statement = $conn->query($sql);
$oeuvres = $statement->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie d'Art</title>
    <script src="https://kit.fontawesome.com/da7397688c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<body>
<header>

    <img src="LOGO%20troublanc+signature_saison2_noir.svg" alt="Logo de la galerie">
    <div class="container-fluid">
    <form method="post" action="../frontend/index.php">
        <div>
            <input type="submit" class="btn btn-secondary" value="Passer à la version admin">
    </form>
    </div>
</header>
<div class="container">
    <div class="gallery">
        <?php $count = 0; ?>
        <?php foreach ($oeuvres as $oeuvre): ?>
        <?php if ($count % 6 == 0): ?>
    </div>
    <div class="gallery">
        <?php endif; ?>
        <div class="gallery">
            <a href='oeuvre.php?id="<?php echo $oeuvre['id']?>"'>
                <img src="../backend/image/<?php echo $oeuvre['image']?>" alt="L'oeuvre en question">
                <h3><?php echo $oeuvre['titre']?></h3>
                <p><?php echo $oeuvre['description']?></p>
                <p>Année de création : <?php echo $oeuvre['annee_crea']?></p>
                <p>Nom de l'artiste : <?php echo $oeuvre['nom_artiste']?></p>

                <span class="lieu">Exposition actuelle :
                        <?php if ($oeuvre['id'] == $oeuvre['id_oeuvres'] && $oeuvre['debut_expo'] <= date("Y-m-d") && $oeuvre['fin_expo'] > date("Y-m-d")): ?>
                            <?php echo $oeuvre['nom_agence']

                            ?>
                        <?php else: ?>
                            Cette oeuvre n'est pas actuellement exposée
                        <?php endif; ?>
                    </span>

                <span class="like">
                        <i class="fa-sharp fa-solid fa-heart"></i> <?php echo $oeuvre['likes']?>
                        <i class="fa-solid fa-heart-crack"></i> <?php echo $oeuvre['dislikes']?>
                    </span>
            </a>
        </div>
        <?php $count++; ?>
        <?php endforeach; ?>
    </div>
</div>



</body>
</html>


