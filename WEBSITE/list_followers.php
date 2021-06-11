<?
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

include('menu.php');

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

if ($_GET["user"]) {

	//On recupere tout les utilisateur donc son argument "following" est celui envoyer via GET

	$user = htmlspecialchars_decode($_GET["user"]);

	$sth = $bdd->prepare("SELECT * FROM follow WHERE following=?");
	$sth->execute(array($user));
	$size = $sth->rowCount();

	echo "<div class=\"header\"><h3>Abonnés :</h3></div>";
	echo "<ul class=\"posts\">";

	if ($size == 0) {
		echo "<li class=\"post\"><h3>Aucune abonnés<h3></li>";
	} else { //Affiche tout les utilisateur qui sont abonnes
		while ($p = $sth->fetch()) {
			echo "<a style=\"text-decoration: none;\" href=\"profile.php?profile=" . $p['follower'] . "\"><li class=\"post\"><h3>" . $p['follower'] . "</h3></li>";
		}
	}
	echo "</ul>";
	include('darkmode.php');
}
