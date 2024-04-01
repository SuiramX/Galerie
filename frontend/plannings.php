<?php
include_once '../backend/config.php';
$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Trou Blanc</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="artiste.php">Gérer les Artistes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lieu.php">Gérer les Agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="oeuvres.php">Gérer les oeuvres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="plannings.php">Gérer les plannings des oeuvres</a>
                    </li>

                </ul>

            </div>
            <form method="post" action="../client/index.php">
                <div>
                    <input type="submit" class="btn btn-secondary" value="Passer à la version client">
            </form>

        </div>
    </nav>
    <?php
    $sql = 'SELECT planning.id, titre, nom_agence, debut_expo, fin_expo 
FROM planning 
JOIN agence 
ON agence.id=planning.id_agence
JOIN oeuvres
ON oeuvres.id=planning.id_oeuvres
ORDER BY oeuvres.titre
' ;
    $statement = $conn->query($sql);
    $artistes = $statement->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <h1>Plannings</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Agence </th>
            <th scope="col">Date de début d'exposition</th>
            <th scope="col">Date de fin d'exposition</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($artistes as $artiste): ?>
            <tr>
                <td><?= $artiste['titre'] ?></td>
                <td><?= $artiste['nom_agence'] ?></td>
                <td><?= $artiste['debut_expo'] ?></td>
                <td><?= $artiste['fin_expo'] ?></td>
                <td>
                    <form method="post" action="../backend/planning/supprimer.php">
                        <div>
                            <input type="hidden" id="idd" name="idd" value="<?= $artiste['id'] ?>">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger" value="Supprimer le planning">
                    </form>
                </td>
                <td>
                    <form method="post" action="../backend/planning/modifier_planning.php">
                        <div>
                            <input type="hidden" id="idd" name="idd" value="<?= $artiste['id'] ?>">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-warning" value="Modifier le planning">
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../backend/planning/ajout_planning.php" class="btn btn-success">Ajouter un planning</a>

    </body>
    </html>
<?php
