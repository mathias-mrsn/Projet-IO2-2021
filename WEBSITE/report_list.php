<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

if (!isset($_SESSION['pseudo'])) {
	header('location: login.php');
}

//Verifie si l'utilisateur est bien connecte et si il est admin

if (isset($_SESSION['id']) and !empty($_SESSION['id']) and isset($_SESSION['admin'])) {
	$msg = $bdd->prepare('SELECT * FROM report ORDER BY date DESC');
	$msg->execute();
	$msg_nbr = $msg->rowCount();
?>





	<!DOCTYPE html>
	<html>

	<head>
		<title>Signalements</title>
	</head>

	<body>
		<?php include('menu.php') ?>
		<div class="header">
			<h2>Signalements</h2>
		</div>
		<ul class="posts">
			<div class="header">
			</div>
			<?php
			if ($msg_nbr == 0) {
				echo "<li class=\"post\"><h3>Aucun signalement</h3></li>";
			}
			while ($m = $msg->fetch()) {
				$p_exp = $bdd->prepare('SELECT pseudo FROM users WHERE id = ?');
				$p_exp->execute(array($m['id_user']));
				$p_exp = $p_exp->fetch();
				$p_exp = $p_exp['pseudo'];

			?>
				<li class="post">
					<p><b><?= $p_exp ?></b> a signalé ce post :
						<b>
							<div class="message">
								<?php
								$post = $bdd->prepare('SELECT * FROM posts WHERE id_post=?');
								$post->execute(array($m["id_post"]));
								$post = $post->fetch();
								echo $post['post'];
								?>
							</div>
						</b>
					</p>

					<?php echo "<a class=\"delete\" href=\"delete_report.php?id_report=" . $m["id"] . "\"><input type=\"button\" class=\"supprimer\" value=\"Ignorer\"</input></a>"; ?>
					<?php echo "<a class=\"delete\" href=\"delete_report.php?id_report=" . $m["id"] . "&delete=1\"><input type=\"button\" class=\"supprimer\" value=\"Supprimer le post\"</input></a>"; ?>
				</li>
			<?php } ?>
		</ul>
	</body>
	<? include('darkmode.php'); ?>

	</html>
<?php } else {
	header('location: index.php');
} ?>