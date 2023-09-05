<?php

session_start();
require_once("config.php");


if (!isset($_SESSION['consult'])) {
    header('Location:../index.php');
    exit;
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = $pdo->prepare("SELECT Id_Compte, Nom, Email, Statut FROM comptes WHERE Actif = 0");

$data->execute();

$users = $data->fetchALL(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["valider"])) {

        if (isset($_POST["demande"])) {

            $demandes = $_POST["demande"];
            $dateValidation = date("Y-m-d");

            foreach ($demandes as $demande) {
                $id_compte = $demande;


                try {

                    $sql1 = "UPDATE comptes SET Actif = 1 WHERE Id_Compte = :idCompte";
                    $stm = $pdo->prepare($sql1);
                    $stm->execute(['idCompte' => $id_compte]);


                    $sql2 = "INSERT INTO validation_comptes (Date_Validation, Id_Consultant, Id_Compte) VALUES (:dateValidation, :idConsultant, :idCompte)";
                    $stm2 = $pdo->prepare($sql2);
                    $stm2->execute([
                        'dateValidation' => $dateValidation,
                        'idConsultant' => $_SESSION["consult"]["id"],
                        'idCompte' => $id_compte
                    ]);

                } catch (PDOException $e) {

                    echo "Erreur lors de la mise à jour du compte : " . $e->getMessage();
                    echo "Erreur SQL : " . $stm->errorInfo()[2];

                }
            }

            $_SESSION['message'] = "Element validé.";

            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }

            header('Location:demande_inscr.php');
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
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Sélectionner</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td>
                                    <?php echo $user["Nom"]; ?>
                                </td>
                                <td>
                                    <?php echo $user["Email"]; ?>
                                </td>
                                <td>
                                    <?php echo $user["Statut"]; ?>
                                </td>
                                <td><input type="checkbox" name="demande[]" value="<?php echo $user['Id_Compte']; ?>"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <button type="submit" value="valider" name="valider" class="submit-btn" <?php if (empty($users))
                    echo 'disabled'; ?>>Valider</button>
            </form>
        </div>
    </section>

</body>

</html>