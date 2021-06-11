<?php
session_start();

$bdd = new PDO("mysql:host=127.0.0.1;dbname=database;charset=utf8", "root", "");

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

//Si id rentrer alors on supprime le post correspondant

if (isset($_GET['id'])) {
	$suppr_id = htmlspecialchars($_GET['id']);
	$post = $bdd->prepare("SELECT * FROM messages WHERE id=?");
	$post->execute(array($suppr_id));
	$user = $post->fetch();
	if ($user['id_expediteur'] == $_SESSION['id']) {
		$suppr = $bdd->prepare('DELETE FROM messages WHERE id = ?');
		$suppr->execute(array($suppr_id));
	}
}

header("location:" .  $_SERVER['HTTP_REFERER']);
