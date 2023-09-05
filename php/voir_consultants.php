<?php
session_start();
require_once("config.php");


if (!isset($_SESSION['admin'])) {
    header('Location:../index.php');
    exit;
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
    <link rel="stylesheet" type="text/css" href="../css/style-admin.css">
    <title>Accueil - TRT Conseil</title>
</head>

<body>

    <?php

    $sql = $pdo->prepare("SELECT Id_Consultant, Nom, Prenom, Email FROM consultants");
    $sql->execute();
    $consultants = $sql->fetchALL(PDO::FETCH_ASSOC);

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
                        <li><a class="connexion-btn" href="../admin.php">Dashboard</a></li>
                        <li><a class="connexion-btn" href="deconnexion.php">Deconnexion</a></li>

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
        <h2>Voir les consultants</h2>

        <div id="cons-content">
            <table>
                <thead>
                    <tr class="theadrow">
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultants as $consultant) { ?>
                        <tr>
                            <td>
                                <?php echo $consultant["Nom"]; ?>
                            </td>
                            <td>
                                <?php echo $consultant["Prenom"]; ?>
                            </td>
                            <td>
                                <?php echo $consultant["Email"]; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

</body>

</html>