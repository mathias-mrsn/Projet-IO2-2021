<?php

session_start();

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

//Si le formulaire est remplie alors on insert un commentaire

if (isset($_POST['post'])) {

	$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

	$text = htmlspecialchars($_POST['post']);
	$date = date("Y-m-d H:i");
	$ins = $bdd->prepare("INSERT INTO posts (id_user, post, date) VALUES (?, ?, ?)");
	$ins->execute(array($_SESSION['id'], $text, $date));
	$_SESSION['success'] = "Publication posté";

	header('location: index.php');
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
			<h2>Créer un post</h2>
		</div>

		<form action="create_post.php" method="post">
			<div class="input">
				<textarea type="text" class="message" name="post" placeholder="Message" required></textarea>
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