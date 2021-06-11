<?php

session_start();

$db = mysqli_connect('localhost', 'root', '', 'database');
$errors = 0;
$tab = array();

if (isset($_POST['inscription'])) {

	//Recuperation des informations rentre
	$pseudo = mysqli_real_escape_string($db, $_POST['pseudo']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$mot_de_passe = mysqli_real_escape_string($db, $_POST['mot_de_passe']);
	$mot_de_passe_2 = mysqli_real_escape_string($db, $_POST['mot_de_passe_2']);

	//Verifie si les mots de passe sont similaires 

	if ($mot_de_passe != $mot_de_passe_2) {
		array_push($tab, "Les mots de passe sont differents");
		$errors++;
	}

	//Recuperer les utilisateur avec les memes pseudo et email pour verifier qu'ils sont uniques

	$sql_u = "SELECT * FROM users WHERE pseudo='$pseudo'";
	$sql_e = "SELECT * FROM users WHERE email='$email'";
	$res_u = mysqli_query($db, $sql_u);
	$res_e = mysqli_query($db, $sql_e);

	$check = 0;
	if (isset($_POST['admin'])) {
		$check = 1;
	}

	$prive = 0;
	if (isset($_POST['prive'])) {
		$prive = 1;
	}


	if (mysqli_num_rows($res_u) > 0) {
		array_push($tab, "Pseudo deja utilisé");
		$errors++;
	} else if (mysqli_num_rows($res_e) > 0) {
		array_push($tab, "Email deja utilisé");
		$errors++;
	}

	//Si aucune erreur importation du profil dans la base

	if ($errors == 0) {
		$mot_de_passe = md5($mot_de_passe);
		$query = "INSERT INTO users (pseudo, email, mot_de_passe, admin, private)
				VALUES('$pseudo', '$email', '$mot_de_passe', '$check', $prive)";
		mysqli_query($db, $query);
		$_SESSION['pseudo'] = $pseudo;
		$results = mysqli_query($db, "SELECT * FROM `users` WHERE pseudo='$pseudo'");
		$row = mysqli_fetch_array($results);
		if ($row['admin'] == 1) {
			$_SESSION['admin'] = 1;
		}
		$_SESSION['id'] = $row['id'];
		$_SESSION['success'] = "Vous etes connecter";
		header('location: index.php');
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Inscription</title>
</head>

<body>

	<?php include('menu.php') ?>

	<div class="header">
		<h2>Inscription</h2>
	</div>
	<div class="contenu">
		<form method="post" action="register.php">
			<div class="input">
				<label>Pseudo :</label><br>
				<input type="text" name="pseudo" placeholder="Mon Pseudo" required>
			</div>
			<div class="input">
				<label>Email :</label><br>
				<input type="mail" name="email" placeholder="exemple@adresse.com" required>
			</div>
			<div class="input">
				<label>Mot de Passe :</label><br>
				<input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
			</div>
			<div class="input">
				<label>Confirmation du Mot de Passe :</label><br>
				<input type="password" name="mot_de_passe_2" placeholder="Confirmation Mot de passe" required>
			</div>
			<div class="input">
				<label>Admin :</label>
				<input type="checkbox" name="admin" value="No">
			</div>
			<div class="input">
				<label>Compte privé :</label>
				<input type="checkbox" name="prive" value="No">
			</div>


			<? foreach ($tab as $t) {
				echo "<span style=\"color:red\"><strong>" . $t . "</strong></span>";
			}
			?>

			<div class="input">
				<button type="submit" class="bouton" name="inscription">Inscrivez-Vous</button>
			</div>
		</form>
	</div>
	<? include('darkmode.php'); ?>
</body>

</html>