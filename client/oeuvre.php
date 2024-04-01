<?php
include_once '../backend/config.php';
$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);
//
#Choisi les oeuvres
$co = $conn->query("SELECT id_oeuvres, image, oeuvres.id,titre,description, nom_artiste, likes, dislikes, nom_agence, debut_expo, fin_expo, agence.ville, artiste.lieu 
FROM oeuvres  
JOIN artiste
ON artiste.id=oeuvres.id_artiste
LEFT JOIN planning
ON planning.id_oeuvres=oeuvres.id
LEFT JOIN agence
ON agence.id = planning.id_agence
WHERE oeuvres.id = " . $_GET['id']);
$co->setFetchMode(PDO::FETCH_ASSOC);
$oeuvre = $co->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Détail de <?php echo $oeuvre[0]['titre']?></title>
    <script src="https://kit.fontawesome.com/da7397688c.js" crossorigin="anonymous"></script>
    <style>

    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <img src="LOGO%20troublanc+signature_saison2_noir.svg" alt="Logo de la galerie">
</header>

<div class="artwork">
    <img src="../backend/image/<?php echo $oeuvre[0]['image']?>" alt="L'oeuvre en question">
    <div class="artwork-details">
        <h2><?php echo $oeuvre[0]['titre']?></h2>
        <p><b>Artiste :</b> <?php echo $oeuvre[0]['nom_artiste']?></p>
        <p><span>Description :<?php echo $oeuvre[0]['description']?></span></p>
        <span class="lieu"> </span>
        <h3>Planning d'exposition</h3>
        <b class="exhibition-schedule">
            <?php foreach ($oeuvre as $planning):?>
            <?php if ($planning['id'] == $planning['id_oeuvres'] && $planning['debut_expo']  < date("Y-m-d") && $planning['fin_expo'] > date("Y-m-d")) { //vérifier pour les oeuvre si leurs date d'expo est dépassée
            ?> L'oeuvre est actuellement exposée à : <?php echo $planning['nom_agence']?>
                        <?php if ($planning['lieu'] == $planning['ville']) { ?>
                            <p><?php echo "Artiste Local !"?>
                    <?php } ?></p>

                    <li><?php echo "Jusqu'au " . $planning['fin_expo']?></li>
                <?php }else if ($planning['debut_expo'] == null) { ?>
                    <li>Cette oeuvre n'est pas encore exposée</li>
                 <?php } else { ?>
                    L'oeuvre sera exposée :
                    <li>Du <?= $planning['debut_expo']?> au <?= $planning['fin_expo']?> à <?= $planning['nom_agence']?></li>
                <?php } ?>
            <!-- Si l'oeuvre n'a pas de date d'exposition, afficher un message -->
            <?php endforeach; ?></b>

        </ul>
        <h4>Donnez votre avis sur cette oeuvre !</h4>
        <div class="votes">

            <!-- Lien de like -->

            <a href="#likeButton" id="likeButton" ><i class="fa-sharp fa-solid fa-heart"></i></a> <?php echo $oeuvre[0]['likes']?>
            <a href="#dislikeButton" id="dislikeButton"><i class="fa-solid fa-heart-crack"></i></a> <?php echo $oeuvre[0]['dislikes']?>

        </div>
        <!-- Ajoutez jQuery à votre page -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                // Lorsque l'utilisateur clique sur le bouton "like"
                $("#likeButton").click(function(e){
                    e.preventDefault(); // Empêche le comportement par défaut du lien

                    // Récupérer l'ID de l'oeuvre
                    var oeuvreId = <?php echo $oeuvre[0]['id']; ?>;

                    // Effectuer une requête AJAX pour mettre à jour les likes
                    $.ajax({
                        url: 'update_likes.php',
                        type: 'POST',
                        data: { oeuvre_id: oeuvreId, action: 'like' },
                        success: function(response){
                            // Mettre à jour l'affichage des likes sur la page
                            $(".votes").html(response);
                        }
                    });
                });

                // Lorsque l'utilisateur clique sur le bouton "dislike"
                $("#dislikeButton").click(function(e){
                    e.preventDefault(); // Empêche le comportement par défaut du lien

                    // Récupérer l'ID de l'oeuvre
                    var oeuvreId = <?php echo $oeuvre[0]['id']; ?>;

                    // Effectuer une requête AJAX pour mettre à jour les dislikes
                    $.ajax({
                        url: 'update_likes.php',
                        type: 'POST',
                        data: { oeuvre_id: oeuvreId, action: 'dislike' },
                        success: function(response){
                            // Mettre à jour l'affichage des dislikes sur la page
                            $(".votes").html(response);
                        }
                    });
                });
            });
        var canClick = true; // Variable de contrôle pour indiquer si le clic est autorisé
        var canDislikeClick = true; // Variable de contrôle pour indiquer si le clic sur dislike est autorisé

        document.querySelector(".fa-sharp").addEventListener("click", function(){
            console.log("Clic sur le bouton de like");
            if (canClick || canDislikeClick) { // Vérifie si le clic est autorisé
                canClick = false; // Désactive le clic temporairement
                canDislikeClick = false; // Désactive le clic sur dislike temporairement
                setTimeout(function() {
                    canClick = true; // Réactive le clic après 3 secondes
                    document.querySelector(".fa-sharp").style.pointerEvents = "auto";
                    document.querySelector(".fa-heart-crack").style.pointerEvents = "auto";
                }, 3000);

                $.ajax({
                    url: "update_likes.php",
                    type: "POST",
                    data: { action: "like", id_oeuvre: <?php echo $oeuvre[0]['id']; ?> },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        if (response.hasOwnProperty('likes')) {
                            $("#likesCount").text(response.likes);
                        } else if (response.hasOwnProperty('error')) {
                            alert("Erreur : " + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
        </script>


    </div>
</div>
<div class="retour">
    <a href="index.php">&lt; Retour à la galerie</a>
</body>
</html>
