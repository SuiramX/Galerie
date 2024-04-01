<?php
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Ajout d'un Artiste</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<form method="post" action="add.php">
    <div class="mb-3">
        <label for="nom_agence" class="form-label">Agence</label>
        <input type="text" class="form-control" name="nom_agence" id="nom_agence" aria-describedby="nom_agence">
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" class="form-control" name="adresse" id="adresse" aria-describedby="adresse">
    </div>
    <div class="mb-3">
        <label for="ville">Ville</label>
        <input type="text" class="form-control" name="ville" id="ville" aria-describedby="ville">
    </div>
    <div class="mb-3">
        <label for="numero">Numéro</label>
        <input type="text" class="form-control" name="numero" id="numero" aria-describedby="numero">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Mail</label>
        <input type="text" class="form-control" name="email" id="email" aria-describedby="email">
    </div>
    <div class="mb-3">
        <label for="nom_dirigeant" class="form-label">Nom du dirigeant</label>
        <input type="text" class="form-control" name="nom_dirigeant" id="nom_dirigeant" aria-describedby="nom_dirigeant">
    </div>
    <input type="submit" name="submit" class="btn btn-primary" value="Ajouter">

</form>
</body>
</html>
