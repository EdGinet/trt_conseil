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

    $sql = $pdo->prepare("SELECT ap.Id_Annonce, ap.Id_Compte, a.Id_Annonce, a.Titre, a.Lieu, a.Description, a.Salaire FROM annonces_postulees ap INNER JOIN annonces a ON ap.Id_Annonce = a.Id_Annonce WHERE ap.Id_Compte=:id_compte AND ap.Active = 1");
    $sql->execute(["id_compte" => $_SESSION["candidat"]["id_compte"]]);
    $annonces = $sql->fetchALL(PDO::FETCH_ASSOC);

    ?>
    <header>
        <nav>
            <a href="index.php"><img src="../images/TrtConseil.svg" id="img-title" alt="Trt Conseil Logo" /></a>
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

                                <li><a class="connexion-btn" href="../page_recruteur.php">Dashboard</a></li>
                                <li><a class="connexion-btn" href="deconnexion.php">Deconnexion</a></li>

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
        <h2>Mes postulations</h2>

        <div id="cons-content">
            <table>
                <thead>
                    <tr class="theadrow">
                        <th>Titre</th>
                        <th>Lieu</th>
                        <th>Salaire</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($annonces as $annonce) { ?>
                        <tr>
                            <td>
                                <?php echo $annonce["Titre"]; ?>
                            </td>
                            <td>
                                <?php echo $annonce["Lieu"]; ?>
                            </td>
                            <td>
                                <?php echo $annonce["Salaire"]; ?>
                            </td>
                            <td class="descr-column">
                                <?php echo $annonce["Description"]; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

</body>

</html>