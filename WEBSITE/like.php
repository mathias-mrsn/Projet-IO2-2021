<?php

$bdd = new PDO("mysql:host=127.0.0.1;dbname=database;charset=utf8", "root", "");

if (isset($_GET['id_user']) and isset($_GET['id_post']) and isset($_GET['action']) and !empty($_GET['action']) and !empty($_GET['id_user']) and !empty($_GET['id_post'])) {

	$id_user = htmlspecialchars($_GET['id_user']);
	$id_post = htmlspecialchars($_GET['id_post']);
	$action = htmlspecialchars($_GET['action']);

	if ($action == 1) { //Unlike

		echo $action;
		$suppr = $bdd->prepare("DELETE FROM `likes` WHERE id_user =? AND id_post =?");
		$suppr->execute(array($id_user, $id_post));
	}

	if ($action == 2) { //Like

		$ins = $bdd->prepare("INSERT INTO likes (id_user, id_post) VALUES (?, ?)");
		$ins->execute(array($id_user, $id_post));
	}
}

//Renvoie sur la page precedente

if (isset($_GET['location']) and !empty($_GET['location'])) {

	$location = htmlspecialchars($_GET['location']);
	header('location: profile.php?profile=' . $location);
} else {
	header('location:index.php');
}
