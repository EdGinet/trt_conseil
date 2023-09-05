<?php

session_start();
require_once("config.php");


if (!isset($_SESSION['consult'])) {
    header('Location:../index.php');
    exit;
}

$data = $pdo->prepare("SELECT Id_Annonce, Titre, Lieu, Description, Salaire, Id_Compte FROM annonces WHERE Active = 0");

$data->execute();

$annonces = $data->fetchALL(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["valider"])) {

        if (isset($_POST["demande"])) {

            $demandes = $_POST["demande"];

            foreach ($demandes as $demande) {
                $id_annonce = $demande;
                $dateValidation = date("Y-m-d");


                try {

                    $sql = "UPDATE annonces SET Active = 1 WHERE Id_Annonce = :idAnnonce";
                    $stm = $pdo->prepare($sql);
                    $stm->execute(['idAnnonce' => $id_annonce]);


                    $sql2 = "INSERT INTO validation_annonces (Date_Validation, Id_Consultant, Id_Annonce) VALUES (:dateValidation, :idConsultant, :idAnnonce)";
                    $stm2 = $pdo->prepare($sql2);
                    $stm2->execute([
                        'dateValidation' => $dateValidation,
                        'idConsultant' => $_SESSION["consult"]["id"],
                        'idAnnonce' => $id_annonce
                    ]);

                } catch (PDOException $e) {

                    echo "Erreur lors de la mise à jour de l'annonce : " . $e->getMessage();
                    echo "Erreur SQL : " . $stm->errorInfo()[2];

                }
            }

            $_SESSION['message'] = "Element validé.";

            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }

            header('Location:nouv_annonce.php');
            exit();
        }
    }
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
    <link rel="stylesheet" type="text/css" href="../css/style-demande-inscr.css">
    <title>Accueil - TRT Conseil</title>
</head>

<body>
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

                            <li><a class="connexion-btn" href="../cons.php">Dashboard</a></li>
                            <li><a class="connexion-btn" href="deconnexion.php">Deconnexion</a></li>

                    <?php } else if (isset($_SESSION['recruteur'])) { ?>

                                <li><a class="connexion-btn" href="page_recruteur.php">Dashboard</a></li>
                                <li><a class="connexion-btn" href="deconnexion.php">Deconnexion</a></li>

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
        <h2>Bonjour</h2>

        <div id="cons-content">
            <h3>Annonces en attente de validation</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <thead>
                        <tr class="theadrow">
                            <th>Titre</th>
                            <th>Lieu</th>
                            <th>Salaire</th>
                            <th>Description</th>
                            <th>Sélectionner</th>
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
                                <td>
                                    <?php echo $annonce["Description"]; ?>
                                </td>
                                <td><input type="checkbox" name="demande[]" value="<?php echo $annonce['Id_Annonce']; ?>"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <button type="submit" value="valider" name="valider" class="submit-btn" <?php if (empty($annonces))
                    echo 'disabled'; ?>>Valider</button>
            </form>
        </div>
    </section>

</body>

</html>