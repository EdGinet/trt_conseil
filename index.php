<?php
session_start();
require_once("php/config.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Accueil - TRT Conseil</title>
</head>

<body>
    <?php

    $data = $pdo->prepare("SELECT a.Id_Annonce, a.Titre, a.Lieu, a.Salaire, a.Active, c.Nom FROM annonces a INNER JOIN comptes c ON a.Id_Compte = c.Id_Compte WHERE a.Active = 1");
    $data->execute();
    $annonces = $data->fetchALL(PDO::FETCH_ASSOC);

    ?>

    <header>
        <nav>
            <a href="index.php"><img src="images/TrtConseil.svg" id="img-title" alt="Trt Conseil Logo" /></a>
            <div id="menu">
                <ul>
                    <li><a class="nav-btn" href="index.php">Accueil</a></li>
                    <li><a class="nav-btn" href="#">Notre Histoire</a></li>
                    <li><a class="nav-btn" href="#">Contacts</a></li>

                    <?php if (isset($_SESSION['admin'])) { ?>
                        <li><a class="connexion-btn" href="admin.php">Dashboard</a></li>
                        <li><a class="connexion-btn" href="php/deconnexion.php">Deconnexion</a></li>

                    <?php } else if (isset($_SESSION['consult'])) { ?>

                            <li><a class="connexion-btn" href="cons.php">Dashboard</a></li>
                            <li><a class="connexion-btn" href="php/deconnexion.php">Deconnexion</a></li>

                    <?php } else if (isset($_SESSION['recruteur'])) { ?>

                                <li><a class="connexion-btn" href="page_recruteur.php">Dashboard</a></li>
                                <li><a class="connexion-btn" href="php/deconnexion.php">Deconnexion</a></li>

                    <?php } else if (isset($_SESSION['candidat'])) { ?>

                                    <li><a class="connexion-btn" href="page_candidat.php">Mon profil</a></li>
                                    <li><a class="connexion-btn" href="php/deconnexion.php">Deconnexion</a></li>

                    <?php } else { ?>

                                    <li><a class="connexion-btn" href="connexion.php">Connexion</a></li>

                    <?php } ?>
                </ul>
            </div>
        </nav>
        <div id="banner">
            <div id="content">
                <h1>A la recherche d'un emploi ?</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum</p>
                <a class="find-job" href="#">Trouver une annonce</a>
            </div>
        </div>
    </header>
    <section>
        <h2>Annonces récentes</h2>
        <div class="table-container">
            <?php foreach ($annonces as $annonce) { ?>
                <div class="job-post-content">
                    <div class="job-info">
                        <div class="job-title">
                            <h4>
                                <?php echo $annonce["Titre"]; ?>
                            </h4>
                        </div>
                        <div class="job-recruteur">
                            <h5>
                                <?php echo $annonce["Nom"]; ?>
                            </h5>
                        </div>
                    </div>
                    <div class="job-location">
                        <?php echo $annonce["Lieu"]; ?>
                    </div>
                    <div class="job-salary">
                        <?php echo $annonce["Salaire"]; ?> €/Mois
                        <div class="job-apply">

                            <?php if (isset($_SESSION['candidat'])) { ?>

                                <?php if ($annonce["Active"] == 1) { ?>

                                    <form action="php/postuler.php" method="POST">
                                        <input type="hidden" name="annonce_id" value="<?php echo $annonce['Id_Annonce']; ?>">
                                        <?php
                                        $stm_check = $pdo->prepare("SELECT * FROM annonces_postulees WHERE Id_Compte = :candidat AND Id_Annonce = :annonce");
                                        $stm_check->execute([
                                            'candidat' => $_SESSION['candidat']["id_compte"],
                                            'annonce' => $annonce['Id_Annonce']
                                        ]);
                                        $alreadyApplied = $stm_check->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php if ($alreadyApplied) { ?>
                                            <button type="button" disabled class="waiting">En attente</button>
                                        <?php } else { ?>
                                            <button type="submit" name="apply-job" class="apply">Postuler</button>
                                        <?php } ?>
                                    </form>

                                <?php } else { ?>
                                    <button disabled>Annonce inactive</button>
                                <?php } ?>
                            <?php } else { ?>
                                <button disabled>Postuler</button>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <footer>

    </footer>
</body>

</html>