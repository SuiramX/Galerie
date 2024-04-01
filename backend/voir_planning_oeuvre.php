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
                        <a class="nav-link active" aria-current="page" href="../frontend/artiste.php">Gérer les Artistes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../frontend/lieu.php">Gérer les Agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../frontend/oeuvres.php">Gérer les oeuvres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../frontend/plannings.php">Gérer les plannings des oeuvres</a>
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
    $sql = "SELECT id_oeuvres, titre, debut_expo, nom_agence, fin_expo 
            FROM planning 
            LEFT JOIN oeuvres ON planning.id_oeuvres = oeuvres.id
            LEFT JOIN agence ON planning.id_agence = agence.id
            WHERE oeuvres.id = " . $_POST['idd'] . "
            ORDER BY debut_expo";
    $statement = $conn->query($sql);
    $statement->execute();
    $artistes = $statement->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <h1>Voir le planning d'exposition de
        <?php if (count($artistes) > 0) {
            echo $artistes[0]['titre'];
        } else {
            echo "cette oeuvre";
        } ?>
        </h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Début d'exposition</th>
            <th scope="col">Fin d'exposition</th>
            <th scope="col">Lieu d'exposition</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($artistes as $artiste): ?>
            <tr>
                <td><?= $artiste['debut_expo'] ?></td>
                <td><?= $artiste['fin_expo'] ?></td>
                <td><?= $artiste['nom_agence'] ?></td>
                <td>
                    <form method="post" action="../backend/planning/supprimer.php">
                        <div>
                            <input type="hidden" id="idd" name="idd">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-info" value="Supprimer ce planning">
                    </form>
                </td>
                <td>
                    <form method="post" action="../backend/planning/modifier_planning.php">
                        <div>
                            <input type="hidden" id="idd" name="idd">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-dark" value="Modifier le planning">
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (count($artistes) == 0) {
        echo "Aucun planning pour cette oeuvre";
    } ?>
    <a href="../backend/planning/ajout_planning.php" class="btn btn-success">Ajouter un planning pour l'oeuvre</a>

    </body>
    </html>
<?php
