<?php
session_start();
require_once("config.php");

?>

<?php

$password = $_POST["pswd"];
$salt = bin2hex(random_bytes(32));
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stm_unique = $pdo->prepare("SELECT * FROM consultants WHERE Email=:email");

$stm_unique->execute(['email' => $_POST["email"]]);

$number_of_rows = $stm_unique->fetchColumn();

if ($number_of_rows == 0) {

    $stm = $pdo->prepare("SELECT Id_Administrateur FROM administrateurs WHERE Email=:email");

    $stm->execute(['email' => $_SESSION["admin"]["email"]]);

    $nom = $stm->fetch(PDO::FETCH_COLUMN);


    $insert_data = "INSERT INTO consultants (Nom, Prenom, Email, Mot_De_Passe, Salt, Id_Administrateur) VALUES ('" . $_POST["Lname"] . "', '" . $_POST["Fname"] . "', '" . $_POST["email"] . "', '" . $hashed_password . "', '" . $salt . "', '" . $nom . "')";

    $pdo->query($insert_data);


    $_SESSION['message'] = "Le consultant a bien été créé.";

    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }


    header('Location:../create-consultant.php');
    exit();

} else {

    $message = "Le consultant existe déjà.";

    header("location:../create-consultant.php?error=" . $message);

}

?>