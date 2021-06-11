<?php
session_start();

//On verifie si l'utilisateur est connecter

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

$error = 0;
$tab = array();
$checkadmin = 0;
$prive = 0;

//On recupere les informations de notre compte

$profil = $bdd->prepare('SELECT * FROM `users` WHERE id=?');
$profil->execute(array($_SESSION['id']));
$profil = $profil->fetch();

//On cherche si le compte est prive ou admin pour afficher dans le formulaire

if ($profil['private'] == 1) {
	$profil_prive = "checked";
} else {
	$profil_prive = "";
}

if ($profil['admin'] == 1) {
	$profil_admin = "checked";
} else {
	$profil_admin = "";
}

//Si formule a ete remplie

if (isset($_POST['modifier'])) {

	//On recupere les informations envoyer

	$pseudo = htmlspecialchars($_POST['pseudo']);
	$email = htmlspecialchars($_POST['email']);
	$mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);
	$mot_de_passe_2 = htmlspecialchars($_POST['mot_de_passe_2']);
	$bio = htmlspecialchars($_POST['bio']);

	//Verifie si le nouveau nom et email sont bien unique

	$sql_u = $bdd->prepare("SELECT * FROM users WHERE pseudo=? AND NOT id=?");
	$sql_e = $bdd->prepare("SELECT * FROM users WHERE email=? AND NOT id=?");
	$sql_u->execute(array($pseudo, $profil['id']));
	$sql_e->execute(array($email, $profil['id']));
	$sql_u = $sql_u->rowCount();
	$sql_e = $sql_e->rowCount();

	if (isset($_POST['admin'])) {
		$checkadmin = 1;
	}

	if (isset($_POST['prive'])) {
		$prive = 1;
	}

	if ($sql_e != 0) {
		array_push($tab, "Email deja utilisé par un autre utilisateur<br>");
		$error++;
	}

	if ($sql_u != 0) {
		array_push($tab, "Pseudo deja utilisé par un autre utilisateur<br>");
		$error++;
	}

	//On verifie que les mots de passe correspondent

	if ($mot_de_passe != $mot_de_passe_2) {
		array_push($tab, "Mot de passe differents<br>");
		$error++;
	}

	//Si aucune erreur on actualise les informations

	if ($error == 0) {
		if ($pseudo != $profil['pseudo']) {
			$follow_change = $bdd->prepare("UPDATE follow SET follower = ? WHERE follower=?");
			$follow_change->execute(array($pseudo, $profil['pseudo']));
			$follow_change = $bdd->prepare("UPDATE follow SET following = ? WHERE following=?");
			$follow_change->execute(array($pseudo, $profil['pseudo']));

			$newpseudo = $bdd->prepare("UPDATE users SET pseudo = ? WHERE id=?");
			$newpseudo->execute(array($pseudo, $_SESSION['id']));
			$_SESSION['pseudo'] = $pseudo;
		}

		if ($email != $profil['email']) {
			$newemail = $bdd->prepare("UPDATE users SET email = ? WHERE id=?");
			$newemail->execute(array($email, $_SESSION['id']));
		}

		$mot_de_passe = md5($mot_de_passe);

		if ($mot_de_passe != $profil['mot_de_passe']) {
			$newmdp = $bdd->prepare("UPDATE users SET mot_de_passe = ? WHERE id=?");
			$newmdp->execute(array($mot_de_passe, $_SESSION['id']));
		}

		if ($checkadmin != $profil['admin']) {
			$newadmin = $bdd->prepare("UPDATE users SET admin = ? WHERE id=?");
			$newadmin->execute(array($checkadmin, $profil['id']));
		}

		if ($prive != $profil['private']) {
			$newprive = $bdd->prepare("UPDATE users SET private = ? WHERE id=?");
			$newprive->execute(array($prive, $profil['id']));
		}

		if ($bio != $profil['bio']) {
			$newbio = $bdd->prepare("UPDATE users SET bio = ? WHERE id=?");
			$newbio->execute(array($bio, $profil['id']));
		}


		$_SESSION['success'] = "Profil modifier avec succes";
		if ($checkadmin == 1) {
			$_SESSION['admin'] = 1;
		} else if (isset($_SESSION['admin'])) {
			unset($_SESSION['admin']);
		}
		$_SESSION['pseudo'] = $pseudo;
		header('location: profile.php?profile=' . $_SESSION['pseudo']);
	}
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>Modification profil</title>
</head>

<body>

	<?php include('menu.php') ?>

	<div class="header">
		<h2>Modification de votre profil</h2>
	</div>
	<div class="contenu">
		<form method="post" action="change_profile.php">
			<div class="input">
				<label>Pseudo :</label><br>
				<input type="text" name="pseudo" value="<? echo $profil['pseudo'] ?>" required>
			</div>
			<div class="input">
				<label>Email :</label><br>
				<input type="mail" name="email" value="<? echo $profil['email'] ?>" required>
			</div>
			<div class="input">
				<label>Biographie</label><br>
				<textarea type="text" class="bio" name="bio" placeholder="Biographie" required><? echo $profil['bio'] ?></textarea><br>
			</div>
			<div class="input">
				<label>Mot de Passe :</label><br>
				<input type="password" name="mot_de_passe" placeholder="Nouveau Mot de Passe" required>
			</div>
			<div class="input">
				<label>Confirmation du Mot de Passe :</label><br>
				<input type="password" name="mot_de_passe_2" placeholder="Confirmation Mot de Passe" required>
			</div>
			<div class="input">
				<label>Admin :</label>
				<input type="checkbox" name="admin" <? echo $profil_admin ?>>
			</div>
			<div class="input">
				<label>Compte privé :</label>
				<input type="checkbox" name="prive" <? echo $profil_prive ?>>
			</div>
			<div class="input">
				<button type="submit" class="bouton" name="modifier">Changer mes informations</button>
			</div>
		</form>
	</div>
	<? include('darkmode.php'); ?>
</body>

</html>