<?php

session_start();
require_once('php/config.php');

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
    <link rel="stylesheet" type="text/css" href="css/style-connexion.css">
    <title>Accueil - TRT Conseil</title>
</head>

<body>
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
    </header>
    <section>
        <div class="container">
            <div id="login-form-container">
                <h1 class="form-title">Connexion</h1>
                <form class="login-form" action="php/authentification.php" method="POST">
                    <label for="text">Email</label>
                    <input type="email" id="email" name="email" required />

                    <label for="password">Mot de passe</label>
                    <input type="password" name="pswd" required />

                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>

                    <button type="submit" value="login" name="login" class="submit-btn">Connexion</button>
                </form>

                <p class="no-account">Vous n'avez pas de compte ?</p>
                <a href="inscription.php" class="subscribe-link">Inscrivez-vous</a>
            </div>
        </div>
    </section>
</body>

</html>