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
    $sql = 'SELECT oeuvres.id,titre,description,annee_crea,nom_artiste FROM oeuvres INNER JOIN artiste ON oeuvres.id_artiste = artiste.id';
    $statement = $conn->query($sql);
    $artistes = $statement->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <h1>Oeuvres</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Description</th>
            <th scope="col">Année de Création</th>
            <th scope="col">Artiste</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($artistes as $artiste): ?>
            <tr>
                <td><?= $artiste['titre'] ?></td>
                <td><?= $artiste['description'] ?></td>
                <td><?= $artiste['annee_crea'] ?></td>
                <td><?= $artiste['nom_artiste'] ?></td>
                <td>
                    <form method="post" action="../backend/oeuvres/vendu.php">
                        <div>
                            <input type="hidden" id="idd" name="idd" value="<?= $artiste['id'] ?>">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger" value="Oeuvre vendu">
                    </form>
                </td>
                <td>
                    <form method="post" action="../backend/oeuvres/modif_oeuvre.php">
                        <div>
                            <input type="hidden" id="idd" name="idd" value="<?= $artiste['id'] ?>">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-warning" value="Modifier">
                    </form>
                </td>
                <td>
                    <form method="post" action="../backend/voir_planning_oeuvre.php">
                        <div>
                            <input type="hidden" id="idd" name="idd" value="<?= $artiste['id'] ?>">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-dark" value="Voir les différents plannings pour l'oeuvre">
                    </form>
                </td>
                <td>
                    <input  type="submit" class="btn btn-danger" value="<?= $artiste['id']?>">
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../backend/oeuvres/ajout_oeuvre.php" class="btn btn-success">Ajouter une oeuvre</a>

    </body>
    </html>
<?php
