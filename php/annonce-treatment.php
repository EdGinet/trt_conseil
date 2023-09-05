<?php

session_start();
require_once("config.php");

?>

<?php


if (isset($_POST["creer_annonce"])) {

    $titre = $_POST["titre_annonce"];
    $lieu = $_POST["lieu_annonce"];
    $description = $_POST["description_annonce"];
    $salaire = $_POST["salaire_annonce"];
    $idCompte = $_SESSION["recruteur"]["id_compte"];

    $sql = "INSERT INTO annonces (Titre, Lieu, Description, Salaire, Active, Id_Compte) VALUES (:titre, :lieu, :description, :salaire, 0, :idCompte)";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        'titre' => $titre,
        'lieu' => $lieu,
        'description' => $description,
        'salaire' => $salaire,
        'idCompte' => $idCompte
    ]);
    header("Location:creer_annonce.php");
    exit();
}



?>