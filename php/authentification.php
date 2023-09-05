<?php
require_once("config.php");
session_start();
?>

<?php

if (isset($_POST["email"]) && isset($_POST["pswd"])) {

	$password = $_POST["pswd"];
	$email = $_POST["email"];

	$stm_comptes = $pdo->prepare("SELECT Id_Compte, Email, Mot_De_Passe, Statut, Actif FROM comptes WHERE Email = :email");
	$stm_comptes->execute(['email' => $email]);
	$user = $stm_comptes->fetch(PDO::FETCH_ASSOC);

	if ($user && password_verify($password, $user['Mot_De_Passe']) && $user["Actif"] == 1) {
		if ($user["Statut"] == 2) {
			$_SESSION['recruteur'] = array(
				"id_compte" => $user["Id_Compte"],
				"email" => $user["Email"],
				"password" => $user["Mot_De_Passe"]
			);
		} else {
			$_SESSION['candidat'] = array(
				"id_compte" => $user["Id_Compte"],
				"email" => $user["Email"],
				"password" => $user["Mot_De_Passe"]
			);
		}
		header('Location:../index.php');
		exit();
	}

	$stm_admin = $pdo->prepare("SELECT Id_Administrateur, Email, Mot_De_Passe, Statut FROM administrateurs WHERE Email = :email");
	$stm_admin->execute(['email' => $email]);
	$admin = $stm_admin->fetch(PDO::FETCH_ASSOC);

	if ($admin && password_verify($password, $admin['Mot_De_Passe'])) {

		$_SESSION['admin'] = array(
			"id" => $admin["Id_Administrateur"],
			"email" => $admin["Email"],
			"password" => $admin["Mot_De_Passe"],
			"statut" => $admin["Statut"]
		);
		header('Location:../admin.php');
		exit();
	}

	$stm_consult = $pdo->prepare("SELECT Id_Consultant, Email, Mot_De_Passe FROM consultants WHERE Email = :email");
	$stm_consult->execute(['email' => $email]);
	$consultant = $stm_consult->fetch(PDO::FETCH_ASSOC);

	if ($consultant && password_verify($password, $consultant['Mot_De_Passe'])) {

		$_SESSION['consult'] = array(
			"id" => $consultant["Id_Consultant"],
			"email" => $consultant["Email"],
			"password" => $consultant["Mot_De_Passe"]
		);
		header('Location:../cons.php');
		exit();
	}

	$error = "Adresse email ou mot de passe incorrect";
}

if (isset($error)) {
	echo $error;
}
?>