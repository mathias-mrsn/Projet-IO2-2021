<?php

session_start();

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

//On insert un rapport sur le post qui a ete envoyer via GET

if (isset($_GET["id_post"])) {
	$id_post = htmlentities($_GET["id_post"]);

	$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

	$date = date("Y-m-d H:i");
	$ins = $bdd->prepare("INSERT INTO report (id_user, id_post, date) VALUES (?, ?, ?)");
	$ins->execute(array($_SESSION['id'], $id_post, $date));
	$_SESSION['success'] = "Signalement effectué";

	//Si GET['ud_user'] est rentrer alors on retourne sur la page de l'utilisateur sinon on retourne sur l'index

	if (isset($_GET['id_user']) and !empty($_GET['id_user'])) {
		$id_user = htmlspecialchars($_GET['id_user']);
		header('location: profile.php?profile=' . $id_user);
	} else {
		header('location: index.php');
	}
}
