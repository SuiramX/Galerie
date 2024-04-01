<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Modification d'une oeuvre</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<form method="post" action="modification.php">
    <?php
    include_once '../config.php';
    $conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
        , Config::UTILISATEUR, Config::MOTDEPASSE);

    $collec = $conn->prepare("SELECT oeuvres.id, titre, description, annee_crea, oeuvres.id_artiste FROM oeuvres WHERE oeuvres.id = :id");
    $collec->bindParam(':id', $_POST['idd']);
    $collec->execute();
    $valeur = $collec->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT DISTINCT artiste.nom_artiste, oeuvres.id_artiste 
            FROM artiste
            JOIN oeuvres
            ON artiste.id = oeuvres.id_artiste
';
    $statement = $conn->query($sql);
    $artistes = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input type="text" class="form-control" name="titre" id="titre" aria-describedby="titre" value="<?php echo $valeur[0]["titre"]; ?>">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description de l'oeuvre</label>
        <input type="text" class="form-control" name="description" id="description" aria-describedby="description" value="<?php echo $valeur[0]["description"]; ?>">
    </div>
    <div class="mb-3">
        <label for="annee_crea">Année de création</label>
        <input type="text" class="form-control" name="annee_crea" id="annee_crea" aria-describedby="annee_crea" value="<?php echo $valeur[0]["annee_crea"]; ?>">
    </div>
    <div class="mb-3">
        <label for="id_artiste" class="form-label">Nom de l'artiste</label>
        <select name="id_artiste" id="id_artiste" aria-describedby="id_artiste" required>
            <?php foreach ($artistes as $artiste): ?>
                <option value="<?= $artiste['id_artiste'] ?>"><?= $artiste['nom_artiste'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    </div>


    <input type="submit" name="submit" class="btn btn-warning" value="Modifier">
    <input value="<?php echo $valeur[0]['id'] ?>" name="id" type="hidden">
</form>
</body>
</html>
<?php
