<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

include('menu.php');

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

if (isset($_GET["user"]) and !empty($_GET['user'])) {

	//On verifie que l'utilsateur existe et recupere et recupere tout les messages

	$us = htmlspecialchars($_GET["user"]);

	$users = $bdd->prepare('SELECT * FROM users WHERE id = ?');
	$users->execute(array($us));
	$user = $users->fetch();

	if ($users->rowCount() < 1)
		echo "<ul class=\"posts\"><li class=\"post\"><h3>Aucun utilisateur correspondant</h3></li></ul>";
	else {
		echo "<div class=\"header\"><h2>" . $user['pseudo'] . "</h2></div>";
		echo "<ul class=\"posts\">";

		$sth = $bdd->prepare('SELECT * FROM messages WHERE id_expediteur = ? AND id_destinataire = ? OR id_expediteur = ? AND id_destinataire = ? ORDER BY id DESC');
		$sth->execute(array($_SESSION['id'], $us, $us, $_SESSION['id']));
		$size = $sth->rowCount();
?>

		<html>

		<head>
			<title>Conversation "<? echo $user['pseudo']; ?>"</title>
		</head>

		<body>
			<form method="POST" action="envoi.php?return=<? echo $us ?>">
				<br><input type="text" name="destinataire" hidden placeholder="Destinataire" value="<? echo $user['pseudo']; ?>" required />
				<textarea type="text" class="message" name="message" placeholder="Message" required></textarea><br><br>
				<button type="submit" value="Envoyer" name="envoi_message">Envoyer</button>
			</form>
		</body>

		</html>

<?		//On verifie si il y a des messages puis on les affiches en separant les messages envoyer et recu
		echo "<li class=\"post\"></li>";
		if ($size == 0) {
			echo "<li class=\"post\"><h3>Aucun message<h3></li>";
		} else {
			while ($m = $sth->fetch()) {
				echo "<li class=\"post\">";
				if ($m['id_expediteur'] == $_SESSION['id'])
					echo "<div class=\"envoyeur\">" . $_SESSION['pseudo'] . "</div><br><strong><div class=\"message_envoye\">" . $m['message'] . "</strong></div><div class=\"date_envoye\">" . $m['date'] . "</div>";
				else
					echo "<div class=\"receveur\">" . $user['pseudo'] . "</div><br><strong><div class=\"message_recu\">" . $m['message'] . "</strong></div><div class=\"date_recu\">" . $m['date'] . "</div>";

				if ($m['id_expediteur'] == $_SESSION['id']) {
					echo "<a class=\"delete\" href=\"delete_message.php?id=" . $m["id"] . "\"><input style=\"float: left; margin-left: 15px;\" type=\"button\" class=\"supprimer\" value=\"Supprimer\"</input></a>";
				}
				echo "</li>";
			}
		}
	}
	echo "</ul>";
	include('darkmode.php');
}
