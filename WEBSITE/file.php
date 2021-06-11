<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

//On recupere tout les posts

if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
	echo "<ul class=\"posts\">";
	$post = $bdd->prepare('SELECT * FROM posts ORDER BY id_post DESC');
	$post->execute(array());
	$total = 0;

	//On parcours tout les messages

	while ($m = $post->fetch()) {
		$id = $bdd->prepare('SELECT * FROM users WHERE id=?');
		$id->execute(array($m['id_user']));

		//On recupere l'utilsateur pour chaque message

		if ($id->rowCount() == 1) {
			$id = $id->fetch();
			$pseudo = $id['pseudo'];
			$id_post = $m['id_post'];

			$follow = $bdd->prepare('SELECT * FROM follow WHERE follower=? AND following=?');
			$follow->execute(array($_SESSION['pseudo'], $pseudo));

			//On verifie si je suis abonnes a la personne si oui on affiche

			if ($follow->rowCount() > 0) {
				echo "<li class=\"post\">";

				//Signalement

				echo "<a class=\"follow\" href=create_report.php?id_post=" . $id_post . "><input class=\"report\" type=\"button\" value=\"Signaler\"></input></a></div>";

				//Affiche le post

				echo "<a style=\"text-decoration: none; color: black;\" href=\"profile.php?profile=" . $pseudo . "\"><div class=\"envoyeur\">" . $pseudo . "</div></a><br><div class=\"message\"><h3>" . $m['post'] . "</h3></div><div class=\"date\">" . $m['date'] . "</div>";

				$id = $_SESSION['id'];
				$sth = $bdd->prepare("SELECT * FROM `likes` WHERE id_user =? AND id_post =?");
				$sth->execute(array($id, $id_post));
				$size = $sth->rowCount();

				//Supression post-------------------------------------------

				if ($pseudo == $_SESSION['pseudo'] || isset($_SESSION['admin'])) {
					echo "<a class=\"delete\" href=\"delete_post.php?id=" . $id_post . "\"><input type=\"button\" class=\"supprimer\" value=\"Supprimer\"</input></a>";
				}

				//Bouton like

				if ($size >= 1) {
					echo "<a class=\"follow\" href=like.php?id_user=" . $pseudo . "&id_post=" . $id_post . "&action=1><input class=\"like\" type=\"button\" value=\"Unlike\"></input></a></div>";
				} else {
					echo "<a class=\"follow\" href=like.php?id_user=" . $pseudo . "&id_post=" . $id_post . "&action=2><input class=\"like\" type=\"button\" value=\"Like\"></input></a></div>";
				}

				//Lien pour voir les likes

				$sth = $bdd->prepare("SELECT * FROM likes WHERE id_post=?");
				$sth->execute(array($id_post));
				$nbr_like = $sth->rowCount();
				echo "<a href=\"list_likes.php?id_post=" . $id_post . "\"><div class=\"like\">" . $nbr_like . " likes</div></a>";

				//Lien pour voir les commentaire

				$sth = $bdd->prepare("SELECT * FROM comment WHERE id_post=?");
				$sth->execute(array($id_post));
				$nbr_c = $sth->rowCount();
				echo "<a href=\"list_comment.php?id_post=" . $id_post . "\"><div class=\"like\">" . $nbr_c . " commentaires</div></a>";

				//Bouton commenter

				echo "<a class=\"delete\" href=\"comment.php?id_post=" . $id_post . "\"><input type=\"button\" class=\"supprimer\" value=\"Commenter\"</input></a>";


				echo "</li>";
				$total++;
			}
		}
	}

	//Si aucun post afficher alors aucun post disponible

	if ($total == 0) {
		echo "<li class=\"post\"><h3>Aucune publication disponible</h3></li>";
	}
	echo "</ul>";
}
