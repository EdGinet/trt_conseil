<?php

session_start();
require_once("config.php");

?>

<?php

$stm_unique = $pdo->prepare("SELECT Email FROM comptes WHERE Email=:email UNION SELECT Email FROM candidats WHERE Email=:email UNION SELECT Email FROM recruteurs WHERE Email=:email");

$stm_unique->execute(["email" => $_POST["email"]]);

$number_of_rows = $stm_unique->fetchColumn();

if ($number_of_rows == 0) {

    if ($_POST["statut"] == 1) {

        $req1 = "INSERT INTO candidats (Nom, Prenom, Date_De_Naissance, Profession, Email, Adresse, Code_Postal, Telephone) VALUES ('" . $_POST["nom"] . "', '" . $_POST["prenom"] . "', '" . $_POST["date_de_naissance"] . "', '" . $_POST["job"] . "', '" . $_POST["email"] . "', '" . $_POST["adresse"] . "', '" . $_POST["cp"] . "', '" . $_POST["tel"] . "')";

        $pdo->query($req1);

        $stm1 = $pdo->prepare("SELECT Id_Candidat FROM candidats WHERE Nom=:nom");

        $stm1->execute(["nom" => $_POST["nom"]]);

        $nom1 = $stm1->fetch();

        $password = $_POST["pswd"];
        $salt = bin2hex(random_bytes(32));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $req2 = "INSERT INTO comptes (Nom, Prenom, Email, Mot_De_Passe, Salt, Statut, Id_Candidat, Actif) VALUES ('" . $_POST["nom"] . "', '" . $_POST["prenom"] . "', '" . $_POST["email"] . "', '" . $hashed_password . "', '" . $salt . "', '" . $_POST["statut"] . "', '" . $nom1["Id_Candidat"] . "', 0)";

        $pdo->query($req2);

        $_SESSION['message'] = "Vous êtes maintenant inscrit.";

        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }


        header('Location:../connexion.php');
        exit();

    } else if ($_POST["statut"] == 2) {

        $req3 = "INSERT INTO recruteurs (Nom, Email, Adresse, Code_Postal, Telephone) VALUES ('" . $_POST["nom"] . "', '" . $_POST["email"] . "', '" . $_POST["adresse"] . "', '" . $_POST["cp"] . "', '" . $_POST["tel"] . "')";

        $pdo->query($req3);

        $stm2 = $pdo->prepare("SELECT Id_Recruteur FROM recruteurs WHERE Nom=:nom");

        $stm2->execute(["nom" => $_POST["nom"]]);

        $nom2 = $stm2->fetch();

        $password = $_POST["pswd"];
        $salt = bin2hex(random_bytes(32));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $req4 = "INSERT INTO comptes (Nom, Email, Mot_De_Passe, Salt, Statut, Id_Recruteur, Actif) VALUES ('" . $_POST["nom"] . "', '" . $_POST["email"] . "', '" . $hashed_password . "', '" . $salt . "', '" . $_POST["statut"] . "', '" . $nom2["Id_Recruteur"] . "', 0)";

        $pdo->query($req4);

        $_SESSION['message'] = "Vous êtes maintenant inscrit.";

        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }


        header('Location:../connexion.php');
        exit();

    }
} else {

    $message = "Cet email existe déjà.";

    header("Location:../inscription.php?error=" . $message);
}

?>