<?php
session_start();
require_once("config.php");

if (!isset($_SESSION['candidat'])) {
    header('Location:../index.php');
    exit();
}

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
    <link rel="stylesheet" type="text/css" href="../css/style-page-candidat.css">
    <title>Accueil - TRT Conseil</title>
</head>

<body>
    <?php



    ?>

    <header>
        <nav>
            <a href="../index.php"><img src="../images/TrtConseil.svg" id="img-title" alt="Trt Conseil Logo" /></a>
            <div id="menu">
                <ul>
                    <li><a class="nav-btn" href="../index.php">Accueil</a></li>
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

                                    <li><a class="connexion-btn" href="../page_candidat.php">Mon profil</a></li>
                                    <li><a class="connexion-btn" href="deconnexion.php">Deconnexion</a></li>

                    <?php } else { ?>

                                    <li><a class="connexion-btn" href="connexion.php">Connexion</a></li>

                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>
    <section>
        <h2>Modifier mon profil</h2>
        <div id="cons-content">
            <h3>Mes informations</h3>
            <div class="content">
                <form class="modify-form" action="modifier_infos.php" method="POST">
                    <label for="nom">Changer mon nom</label>
                    <input ype="text" id="nom" name="nom" required />

                    <label for="adresse">Changer mon adresse</label>
                    <input type="text" id="adresse-candidat" name="adresse" required />

                    <label for="code-postal">Changer mon code postal</label>
                    <input type="text" class="form-control" id="cp" name="cp"   minlength="5" maxlength="5" required />

                    <label for="Tel">Changer mon numéro de téléphone</label>
                    <input type="text" class="form-control" id="tel" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}" name="tel" required  />

                    <label for="profession" id="job-candidat-label">Changer ma profession</label>
                    <input type="text" id="job-candidat" name="job" required />

                    <label for="curriculum">Transmettre mon CV</label>
                    <input type="file" accept=".pdf" name="cv" class="file-input" required />

                    <button type="submit" value="modify" name="modifier" class="modifier-btn">Modifier mon profil</button>
                </form>
            </div>
            

        </div>

    </section>
</body>

</html>