<?php

if (isset($_GET['logout'])) {
	session_destroy();
	header("location: login.php");
}

$db = mysqli_connect('localhost', 'root', '', 'database');

if (isset($_GET['recherche'])) {

	// On verifier si un utilsateur correspond a la recherche

	$recherche = htmlspecialchars($_GET['recherche']);
	$sth = "SELECT * FROM `users` WHERE pseudo='$recherche'";
	$result = mysqli_query($db, $sth);
	if (mysqli_num_rows($result) <= 0) {
		header('location: index.php?not_find=1');
	} else {
		$row = mysqli_fetch_array($result);
		header('location: profile.php?profile=' . $row['pseudo']);
	}
}
?>


<html>

<body>

	<?php
	if (isset($_SESSION['pseudo'])) {
		$myid = $_SESSION['id'];
		$res = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM users WHERE id='$myid'"));
	?>

		<ul class="nav">

			<li class="2"><a href="index.php?logout=1">Déconnection</a></li>

			<? if (isset($_SESSION["admin"])) { ?>

				<li class="2"><a href="report_list.php">Signalement</a></li>

			<? } ?>

			<li class="2"><a href="create_post.php">Créer un post</a></li>

			<li class="1"><a href="index.php">Accueil</a></li>

			<li class="2"><a href="profile.php?profile=<?php echo $_SESSION['pseudo']; ?>">Profil</a></li>

			<li class="2"><a href="message.php">Messages</a></li>

			<li class="2">
				<form method="get">
					<input type="recherche" name="recherche" placeholder="Recherche d'utilisateur" required>
				</form>
			</li>
		</ul>

	<?php  } else { ?>

		<ul class="nav">

			<li class="1"><a href="login.php">Se connecter</a></li>

			<li class="1"><a href="register.php">S'inscrire</a></li>

		</ul>
	<?php } ?>



</body>

</html>