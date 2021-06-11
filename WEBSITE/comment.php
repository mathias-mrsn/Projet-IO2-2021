<?php

session_start();

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

//Si on a l'id du post et un commentaire de rentrer alors on insert le commentaire

if (isset($_GET["id_post"])) {
	$id_post = htmlspecialchars($_GET["id_post"]);

	if (isset($_POST['post'])) {

		$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

		$text = htmlspecialchars($_POST['post']);
		$date = date("Y-m-d H:i");
		$ins = $bdd->prepare("INSERT INTO comment (id_user, id_post, comment, date) VALUES (?, ?, ?, ?)");
		$ins->execute(array($_SESSION['id'], $id_post, $text, $date));
		$_SESSION['success'] = "Commentaire posté";

		header('location: index.php');
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Publier un post</title>
</head>

<body>
	<?php include('menu.php') ?>
	<div class="contenu">
		<div class="header">
			<h2>Commentaire</h2>
		</div>

		<form action="comment.php?id_post=<? echo $id_post; ?>" method="post">
			<div class="input">
				<textarea type="text" class="message" name="post" placeholder="Commentaire" required></textarea>
			</div>
			<div class="input">
				<button type="submit" class="bouton">Publier</button>
			</div>
		</form>
	</div>
</body>
<? include('darkmode.php'); ?>

</html>

<?php

?>