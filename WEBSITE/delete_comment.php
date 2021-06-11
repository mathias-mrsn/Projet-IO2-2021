<?php
session_start();

$bdd = new PDO("mysql:host=127.0.0.1;dbname=database;charset=utf8", "root", "");

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

//Si id rentrer alors on supprime le post correspondant

if (isset($_GET['id'])) {
	$suppr_id = htmlspecialchars($_GET['id']);
	$post = $bdd->prepare("SELECT * FROM comment WHERE id=?");
	$post->execute(array($suppr_id));
	$user = $post->fetch();
	if ($user['id_user'] == $_SESSION['id'] || isset($_SESSION['admin'])) {
		$suppr = $bdd->prepare('DELETE FROM comment WHERE id = ?');
		$suppr->execute(array($suppr_id));
	}
	header('location: list_comment.php?id_post=' . $user['id_post']);
} else {
	header('location: index.php');
}
