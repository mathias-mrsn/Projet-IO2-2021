<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

include('menu.php');

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

if ($_GET["id_post"]) {

	//On recupere tout les likes donc son argument "id_post" est celui envoyer via GET

	$id_post = htmlspecialchars_decode($_GET["id_post"]);

	$sth = $bdd->prepare("SELECT * FROM likes WHERE id_post=?");
	$sth->execute(array($id_post));
	$size = $sth->rowCount();

	echo "<div class=\"header\"><h2>Likes :</h2></div>";
	echo "<ul class=\"posts\">";

	if ($size == 0) {
		echo "<li class=\"post\"><h3>Aucune like<h3></li>";
	} else { //Affiche tout les utilisateur qui ont liker
		while ($p = $sth->fetch()) {
			$user = $bdd->prepare("SELECT * FROM users WHERE id=?");
			$user->execute(array($p['id_user']));
			$user = $user->fetch();
			echo "<a style=\"text-decoration: none;\" href=\"profile.php?profile=" . $user['pseudo'] . "\"><li class=\"post\"><h3>" . $user['pseudo'] . "</h3></li>";
		}
	}
	echo "</ul>";
	include('darkmode.php');
}
