<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Modification d'un Artiste</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<form method="post" action="modifier.php">
    <?php
    include_once '../config.php';
    $conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
        , Config::UTILISATEUR, Config::MOTDEPASSE);

    $collec = $conn->prepare("SELECT * FROM artiste WHERE id = :id");
    $collec->bindParam(':id', $_POST['idd']);
    $collec->execute();
    $valeur = $collec->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="mb-3">
        <label for="nom" class="form-label">Nom de l'artiste</label>
        <input type="text" class="form-control" name="nom" id="nom" aria-describedby="nom" value="<?php echo $valeur[0]['nom']; ?>">
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom de l'artiste</label>
        <input type="text" class="form-control" name="prenom" id="prenom" aria-describedby="prenom" value="<?php echo $valeur[0]["prenom"]; ?>">
    </div>
    <div class="mb-3">
        <label for="born">Date de naissance</label> <!-- Correction ici -->
        <input type="date" class="form-control" name="born" id="born" aria-describedby="born" value="<?php echo $valeur[0]["born"]; ?>">
    </div>
    <div class="mb-3">
        <label for="mail" class="form-label">Adresse mail</label>
        <input type="text" class="form-control" name="mail" id="mail" aria-describedby="mail" value="<?php echo $valeur[0]["mail"]; ?>">
    </div>
    <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudonyme de l'artiste</label>
        <input type="text" class="form-control" name="nom_artiste" id="pseudo" aria-describedby="pseudo" value="<?php echo $valeur[0]["nom_artiste"]; ?>">
    </div>
    <div class="mb-3">
        <label for="lieu" class="form-label">Lieu de l'artiste</label>
        <input type="text" class="form-control" name="lieu" id="lieu" aria-describedby="lieu" value="<?php echo $valeur[0]["lieu"]; ?>">
    </div>
    <div class="mb-3">
        <label for="rs" class="form-label">Réseau social</label>
        <input type="text" class="form-control" name="rs" id="rs" aria-describedby="rs" value="<?php echo $valeur[0]["rs"]; ?>">
    </div>
    <div class="mb-3">
        <label for="telephone" class="form-label">Numéro de téléphone ( ATTENTION A COLLER TOUT LES NUMEROS ) </label>
        <input type="text" class="form-control" name="telephone" id="telephone" aria-describedby="telephone" value="<?php echo $valeur[0]["telephone"]; ?>">
    </div>
    <input type="submit" name="submit" class="btn btn-warning" value="Modifier">
    <input value="<?php echo $valeur[0]['id']; ?>" name="id" type="hidden">
</form>
</body>
</html>
<?php
