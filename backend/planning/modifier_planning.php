<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Modification d'un planning</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<form method="post" action="modifier.php" onsubmit="return validateDates()">
    <?php
    include_once '../config.php';
    $conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
        , Config::UTILISATEUR, Config::MOTDEPASSE);

    $collec = $conn->prepare("SELECT planning.id, debut_expo, fin_expo, nom_agence, titre, oeuvres.id 
FROM planning 
JOIN agence
ON agence.id=planning.id_agence
JOIN oeuvres
ON oeuvres.id=planning.id_oeuvres
WHERE planning.id = :id");
    $collec->bindParam(':id', $_POST['idd']);
    $collec->execute();
    $valeurs = $collec->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT agence.id, nom_agence FROM agence';
    $statement = $conn->query($sql);
    $agences = $statement->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT oeuvres.id, titre FROM oeuvres';
    $statement = $conn->query($sql);
    $oeuvres = $statement->fetchAll(PDO::FETCH_ASSOC);

    $sql ='SELECT planning.id FROM planning';
    $statement = $conn->query($sql);
    $plannings = $statement->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <div class="mb-3">
        <label for="titre" class="form-label">Titre de l'oeuvre</label>
        <select name="titre" id="titre" aria-describedby="titre" required>
            <?php foreach ($oeuvres as $oeuvre):?>
                <option value="<?= $oeuvre['id']?>"><?= $oeuvre['titre']?></option>
            <?php endforeach; ?>
        </select>

    </div>
    <div class="mb-3">
        <label for="nom_agence" class="form-label">Lieu d'exposition</label>
        <select name="nom_agence" id="nom_agence" aria-describedby="nom_agence" required>
            <?php foreach ($agences as $agence):?>
                <option value="<?= $agence['id']?>"><?= $agence['nom_agence']?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="debut_expo">Début d'exposition</label>
        <input type="date" class="form-control" name="debut_expo" id="debut_expo" aria-describedby="debut_expo" value="<?php echo $valeurs[0]["debut_expo"]; ?>">
    </div>
    <div class="mb-3">
        <label for="fin_expo">Fin d'exposition</label>
        <input type="date" class="form-control" name="fin_expo" id="fin_expo" aria-describedby="fin_expo" value="<?php echo $valeurs[0]["fin_expo"]; ?>">
    </div>

    <input type="submit" name="submit" class="btn btn-warning" value="Modifier">
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
<?php
