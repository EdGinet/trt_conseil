<?php
require_once("php/config.php");
session_start();

if (!isset($_SESSION['admin'])) {
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
    <link rel="stylesheet" type="text/css" href="css/style-create.css">
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

                    <?php } else { ?>

                        <li><a class="connexion-btn" href="connexion.php">Connexion</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>
    <section>
        <h2>Créer un consultant</h2>

        <div id="form-container">
            <form class="create-cons-form" action="php/newCons.php" method="POST">

                <label for="Lname">Nom</label>
                <input type="text" id="Lname" name="Lname" required />

                <label for="Fname">Prénom</label>
                <input type="text" id="Fname" name="Fname" required />

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />

                <label for="password">Mot de passe</label>
                <input type="password" name="pswd" required />



                <button type="submit" value="login" name="login" class="submit-btn">Créer</button>
            </form>
        </div>
    </section>

</body>

</html>