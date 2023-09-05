<?php

session_start();
require_once("config.php");

$date = date("Y-m-d");

if (isset($_POST["apply-job"])) {
    $sql = "INSERT INTO annonces_postulees (Date_Postulation, Id_Compte, Id_Annonce, Active) VALUES (:date, :candidat, :annonce, 0)";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        'date' => $date,
        'candidat' => $_SESSION["candidat"]["id_compte"],
        'annonce' => $_POST["annonce_id"]
    ]);
    header("Location:../index.php");
    exit();
}

?>