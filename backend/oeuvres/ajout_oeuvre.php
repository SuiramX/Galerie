<?php
include_once '../config.php';
$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);
#Choisi les artistes
$sql = 'SELECT * FROM artiste';
$statement = $conn->query($sql);
$artistes = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Ajout d'une oeuvre</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<form method="post" action="ajout.php" enctype="multipart/form-data" onsubmit="return validateDates()">
    <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input type="text" class="form-control" name="titre" id="titre" aria-describedby="titre" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description de l'oeuvre</label>
        <input type="text" class="form-control" name="description" id="description" aria-describedby="description" required>
    </div>
    <div class="mb-3">
        <label for="annee_crea">Année de création</label>
        <input type="text" class="form-control" name="annee_crea" id="annee_crea" aria-describedby="annee_crea" required>
    </div>
    <div class="mb-3">
        <label for="nom_artiste" class="form-label">Nom de l'artiste</label>
        <select name="nom_artiste" id="nom_artiste" aria-describedby="nom_artiste" required>
            <?php foreach ($artistes as $artiste):?>
                <option value="<?= $artiste['id']?>"><?= $artiste['nom_artiste']?></option>
            <?php endforeach; ?>
</select>

    </div>
    <div class="mb-3">
        <label for="oeuvre" class="form-label">L'oeuvre</label>
        <input type="file" class="form-control" name="oeuvre" id="oeuvre" aria-describedby="oeuvre" required>
    <input type="submit" name="submit" class="btn btn-primary" value="Ajouter">
    </div>
    <div class="mb-3">
        <label for="id_oeuvres" class="form-label"></label>
        <input type="hidden" name="id_oeuvres" class="form-control" value="id_oeuvres">
    </div>

</form>

<script>
    function validateDates() {
        var debutExpo = document.getElementById('debut_expo').value;
        var finExpo = document.getElementById('fin_expo').value;

        if (debutExpo > finExpo) {
            alert("La date de début d'exposition doit être avant la date de fin d'exposition.");
            return false; // Empêche la soumission du formulaire
        }
        return true; // Autorise la soumission du formulaire
    }
</script>
</body>
</html>
