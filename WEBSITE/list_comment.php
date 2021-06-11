<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

include('menu.php');

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

if ($_GET["id_post"]) {

	//On recupere tout les commentaires donc son argument "id_post" est celui envoyer via GET

	$id_post = htmlspecialchars_decode($_GET["id_post"]);

	$sth = $bdd->prepare("SELECT * FROM comment WHERE id_post=? ORDER BY id DESC");
	$sth->execute(array($id_post));
	$size = $sth->rowCount();

	echo "<div class=\"header\"><h2>Commentaires :</h2></div>";
	echo "<ul class=\"posts\">";

	if ($size == 0) {
		echo "<li class=\"post\"><h3>Aucun commentaire<h3></li>";
	} else { //On affiche tout les messages
		while ($p = $sth->fetch()) {
			$user = $bdd->prepare("SELECT * FROM users WHERE id=?");
			$user->execute(array($p['id_user']));
			$user = $user->fetch();
			echo "<li class=\"post\">";
			echo "<div class=\"envoyeur\">" . $user["pseudo"] . "</div><br><br><strong><div class=\"message\">" . $p['comment'] . "</strong><br><br></div><div class=\"date\">" . $p['date'] . "</div>";

			if ($user['pseudo'] == $_SESSION["pseudo"] || isset($_SESSION['admin'])) {
				echo "<a style=\"text-decoration: none;\" class=\"delete\" href=\"delete_comment.php?id=" . $p["id"] . "\"><input type=\"button\" class=\"supprimer\" value=\"Supprimer\"</input></a>";
			}
			echo "</li>";
		}
	}
	echo "</ul>";
	include('darkmode.php');
}
