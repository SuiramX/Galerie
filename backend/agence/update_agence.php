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

<form method="post" action="update.php">
    <?php
    include_once '../config.php';
    $conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
        , Config::UTILISATEUR, Config::MOTDEPASSE);

    $collec = $conn->prepare("SELECT * FROM agence WHERE id = :id");
    $collec->bindParam(':id', $_POST['idd']);
    $collec->execute();
    $valeur = $collec->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" class="form-control" name="adresse" id="adresse" aria-describedby="adresse" value="<?php echo $valeur[0]['adresse']; ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" name="email" id="email" aria-describedby="email" value="<?php echo $valeur[0]["email"]; ?>">
    </div>
    <div class="mb-3">
        <label for="nom_agence">Nom de l'agence</label> <!-- Correction ici -->
        <input type="text" class="form-control" name="nom_agence" id="nom_agence" aria-describedby="nom_agence" value="<?php echo $valeur[0]["nom_agence"]; ?>">
    </div>
    <div class="mb-3">
        <label for="nom_dirigeant" class="form-label">Nom du dirigeant</label>
        <input type="text" class="form-control" name="nom_dirigeant" id="nom_dirigeant" aria-describedby="nom_dirigeant" value="<?php echo $valeur[0]["nom_dirigeant"]; ?>">
    </div>
    <div class="mb-3">
        <label for="numero" class="form-label">Numero</label>
        <input type="text" class="form-control" name="numero" id="numero" aria-describedby="numero" value="<?php echo $valeur[0]["numero"]; ?>">
    </div>

    <input type="submit" name="submit" class="btn btn-warning" value="Modifier">
    <input value="<?php echo $valeur[0]['id']; ?>" name="id" type="hidden">
</form>
</body>
</html>
<?php
