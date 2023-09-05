<?php

session_start();
require_once("config.php");

if (!isset($_SESSION['consult'])) {
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
    <link rel="stylesheet" type="text/css" href="../css/style-demande-inscr.css">
    <title>Accueil - TRT Conseil</title>
</head>

<body>
    <?php

    $sql = $pdo->prepare("SELECT ap.Id_Annonce_Postulee, ap.Id_Compte, ap.Id_Annonce, ap.Active, c.Id_Compte, c.Nom, c.Prenom, a.Id_Annonce, a.Titre, a.Lieu, a.Id_Compte AS RecruteurId_Compte, rec.Nom AS RecruteurNom
    FROM annonces_postulees ap
    INNER JOIN comptes c ON ap.Id_Compte = c.Id_Compte
    INNER JOIN annonces a ON ap.Id_Annonce = a.Id_Annonce
    INNER JOIN comptes rec ON a.Id_Compte = rec.Id_Compte
    WHERE ap.Active = 0");
    $sql->execute();
    $datas = $sql->fetchALL(PDO::FETCH_ASSOC);

    if (isset($_POST["valider"])) {
    
        if (isset($_POST["demande"])) {

            $demandes = $_POST["demande"];

            foreach ($demandes as $demande) {


                $dateValidation = date("Y-m-d");
                $idAnnP = $demande;

                $sqlUpdate = $pdo->prepare("UPDATE annonces_postulees SET Active = 1 WHERE Id_Annonce_Postulee = :idAnnonceP");
                $sqlUpdate->execute(['idAnnonceP' => $idAnnP]);


                $sql2 = "INSERT INTO validation_annonces_postulees (Date_Validation, Id_Annonce_Postulee, Id_Consultant) VALUES (:dateValidation, :idAnnonceP, :idConsultant)";
                $stm = $pdo->prepare($sql2);
                $stm->execute([
                'dateValidation' => $dateValidation,
                'idAnnonceP' => $idAnnP,
                'idConsultant' => $_SESSION["consult"]["id"]
            ]);
        }
            
            header("Location:demande_postulation.php");
            exit();
        }
    }

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
                        <li><a class="connexion-btn" href="deconnexion.php">Deconnexion</a></li>

                    <?php } else if (isset($_SESSION['consult'])) { ?>

                            <li><a class="connexion-btn" href="../cons.php">Dashboard</a></li>
                            <li><a class="connexion-btn" href="deconnexion.php">Deconnexion</a></li>

                    <?php } else if (isset($_SESSION['user'])) { ?>

                                <li><a class="connexion-btn" href="deconnexion.php">Deconnexion</a></li>

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
            <h3>Comptes en attente de validation</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <thead>
                        <tr class="theadrow">
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Titre</th>
                            <th>Lieu</th>
                            <th>Recruteur</th>
                            <th>Sélectionner</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datas as $demande) { ?>
                            <tr>
                                <td>
                                    <?php echo $demande["Nom"]; ?>
                                </td>
                                <td>
                                    <?php echo $demande["Prenom"]; ?>
                                </td>
                                <td>
                                    <?php echo $demande["Titre"]; ?>
                                </td>
                                <td>
                                    <?php echo $demande["Lieu"]; ?>
                                </td>
                                <td>
                                    <?php echo $demande["RecruteurNom"]; ?>
                                </td>
                                <td><input type="checkbox" name="demande[]" value="<?php echo $demande['Id_Annonce_Postulee']; ?>"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <button type="submit" value="valider" name="valider" class="submit-btn" <?php if (empty($datas))
                    echo 'disabled'; ?>>Valider</button>
            </form>
        </div>
    </section>
</body>

</html>