<?php

$db = mysqli_connect('localhost', 'root', '', 'database');
session_start();

include('menu.php');

//Verification si connecter------------------------------------------

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

//Recuperation profil------------------------------------------------

if (isset($_GET['profile'])) {

	$recherche = htmlspecialchars($_GET['profile']);
	$sth = "SELECT * FROM `users` WHERE pseudo='$recherche'";
	$result = mysqli_query($db, $sth);

?>

	<html>

	<head>
		<title> Profil de <?php echo $recherche; ?></title>
	</head>

	</html>

<?
	//Si utilisateur existe pas-----------------------------------------

	if (mysqli_num_rows($result) != 1) {
		echo "<div class=\"header\"><h2>" . $recherche . "</h2></div>";
		echo "<ul class=\"posts\"><li class=\"post\">";
		echo "<h3>Profil inexistant</h3>";
		echo "</li></ul>";
	} else {

		//Verifie si le compte est privé

		$access = true;
		$row = mysqli_fetch_array($result);
		$mypseudo = $_SESSION['pseudo'];
		if ($row["private"] == 1) {
			$nbr = mysqli_num_rows(mysqli_query($db, "SELECT * FROM follow WHERE follower='$mypseudo' AND following='$recherche'"));
			if ($nbr != 1 && $row['id'] != $_SESSION['id']) {
				$access = false;
			}
		}

		//Affiche nombre d'abonnes et nom------------------------------

		if (isset($_SESSION['success'])) {
			echo "<div class=\"contenu\"><h3>" . $_SESSION['success'] . "<h3></div>";
			unset($_SESSION['success']);
		}

		echo "<div class=\"header\"><h2>" . $row['pseudo'] . "</h2></div>";
		$nbr_follower = mysqli_num_rows(mysqli_query($db, "SELECT * FROM `follow` WHERE following = '$recherche'"));
		echo "<h4 style=\"font-weight: bold;\"><a style=\"text-decoration: none;\" href=\"list_followers.php?user=" . $recherche . "\">Abonnés : " . $nbr_follower . "&nbsp;&nbsp;&nbsp;&nbsp;</a>";

		$nbr_following = mysqli_num_rows(mysqli_query($db, "SELECT * FROM `follow` WHERE follower = '$recherche'"));
		echo "<a style=\"text-decoration: none;\" href=\"list_following.php?user=" . $recherche . "\">&nbsp;&nbsp;&nbsp;&nbspAbonnement : " . $nbr_following . "</a></h4>";

		//Afficher biographie

		if (!empty($row['bio'])) {
			echo "<h4 style=\"font-weight: bold;\">\"" . $row['bio'] . "\"</h4>";
		}

		//Modification profil------------------------------------------

		if ($_SESSION['pseudo'] == $recherche) {
			echo "<a class=\"follow\" href=change_profile.php><input class=\"follow\" type=\"button\" value=\"Modifier mon profil\"></a>";
		}

		//Bouton follow------------------------------------------------	

		$sth = "SELECT * FROM `follow` WHERE follower ='$mypseudo' AND following ='$recherche'";
		$result = mysqli_query($db, $sth);
		if (mysqli_num_rows($result) >= 1 and $mypseudo != $recherche) {
			echo "<a class=\"follow\" href=follow.php?follower=" . $mypseudo . "&following=" . $recherche . "&action=0><input class=\"follow\" type=\"button\" value=\"Se desabonner\"></input></a></div>";
		} else if ($mypseudo != $recherche) {
			echo "<a class=\"follow\" href=follow.php?follower=" . $mypseudo . "&following=" . $recherche . "&action=1><input type=\"button\" class=\"follow\" value=\"S'abonner\"></input></a></div>";
		}

		if ($recherche != $_SESSION['pseudo']) {
			echo "<a class=\"follow\" href=envoi.php?reply=" . $recherche . "><input class=\"follow\" type=\"button\" value=\"Envoyer un message\"></input></a></div>";
		}

		echo "<ul class=\"posts\">";

		$id = $row['id'];
		$sth_id = "SELECT * FROM `posts` WHERE id_user='$id' ORDER BY id_post DESC";
		$res = mysqli_query($db, $sth_id);

		if ($access == true) { //Verifie si on a access au compte


			//Recherche des posts de l'utilisateur-------------------------

			if (mysqli_num_rows($res) <= 0) {
				echo "<li class=\"post\"><h3>Pas de post</h3></li>";
				include('darkmode.php');
				exit;
			}

			//Verification si l'utilisateur est admin-----------------------


			$admincheck = mysqli_query($db, "SELECT * FROM `users` WHERE pseudo='$mypseudo'");
			$myprofil = mysqli_fetch_array($admincheck);


			//Affichage des posts-------------------------------------------

			while ($row_post = mysqli_fetch_array($res)) {
				$id_post = $row_post['id_post'];
				$id_user = $row_post['id_user'];

				echo "<li class=\"post\">";
				echo "<a class=\"follow\" href=create_report.php?id_post=" . $id_post . "&id_user=" . $recherche . "><input class=\"report\" type=\"button\" value=\"Signaler\"></input></a></div><br>";
				echo "<h3>" . $row_post['post'] . "</h3><div class=\"date\">" . $row_post['date'] . "</div>";

				//Supression post-------------------------------------------

				if ($recherche == $_SESSION['pseudo'] || $myprofil['admin']) {
					echo "<a class=\"delete\" href=\"delete_post.php?id=" . $id_post . "&id_user=" . $id_user . "\"><input type=\"button\" class=\"supprimer\" value=\"Supprimer\"</input></a>";
				}

				//Bouton like---------------------------------------------

				$id = $_SESSION['id'];
				$sth = "SELECT * FROM `likes` WHERE id_user ='$id' AND id_post ='$id_post'";
				$result = mysqli_query($db, $sth);
				if (mysqli_num_rows($result) >= 1) {
					echo "<a class=\"follow\" href=like.php?id_user=" . $id . "&id_post=" . $id_post . "&action=1&location=" . $recherche . "><input class=\"like\" type=\"button\" value=\"Unlike\"></input></a></div>";
				} else {
					echo "<a class=\"follow\" href=like.php?id_user=" . $id . "&id_post=" . $id_post . "&action=2&location=" . $recherche . "><input class=\"like\" type=\"button\" value=\"Like\"></input></a></div>";
				}

				//Affichage nombre de likes et commentaire-----------------



				$nbr_like = mysqli_num_rows(mysqli_query($db, "SELECT * FROM likes WHERE id_post='$id_post'"));

				$nbr_c = mysqli_num_rows(mysqli_query($db, "SELECT * FROM comment WHERE id_post ='$id_post'"));


				echo "<a href=\"list_likes.php?id_post=" . $id_post . "\"><div class=\"like\">" . $nbr_like . " likes</div></a>";
				echo "<a href=\"list_comment.php?id_post=" . $id_post . "&location=1\"><div class=\"like\">" . $nbr_c . " commentaires</div></a>";
				echo "<a class=\"delete\" href=\"comment.php?id_post=" . $id_post . "\"><input type=\"button\" class=\"supprimer\" value=\"Commenter\"</input></a>";

				echo "</li>";
			}
		} else {
			echo "<li class=\"post\"><h3>Compte privé</h3></li>";
		}
		echo "</ul>";
	}
	include('darkmode.php');
}

?>