<?php

	session_start();

	$bdd = new PDO("mysql:host=127.0.0.1;dbname=database;charset=utf8", "root", "");

	//Verifie si l'utilsateur est admin et si des informations ont ete envoyer via GET

	if(isset($_GET['id_report']) && isset($_SESSION['admin'])){

		//On recuperer l'id du post et on supprimer le report

		$id_report = htmlspecialchars($_GET['id_report']);
		$select = $bdd->prepare('SELECT * FROM report WHERE id = ?');
		$select->execute(array($id_report));
		if($select->rowCount() > 0){
			$select = $select->fetch();
			$id_post = $select['id_post'];
			$suppr = $bdd->prepare('DELETE FROM report WHERE id_post = ?');
			$suppr->execute(array($id_post));
		}
		//Si l'argument GET['delete'] a ete initialiser on supprime le post

		if(isset($_GET['delete'])){
   			$suppr = $bdd->prepare('DELETE FROM posts WHERE id_post = ?');
   			$suppr->execute(array($id_post));
		}
	}

	header('location: report_list.php')
?>