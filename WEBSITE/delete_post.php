<?php
session_start();

$bdd = new PDO("mysql:host=127.0.0.1;dbname=database;charset=utf8", "root", "");

if (!isset($_SESSION['pseudo'])) {
   header('location: login.php');
}

//On recupere le post, puis si on est admin ou le porprietaire on supprime et enfin si on vient d'une page profile alors on est rediriger sur celle ci

if (isset($_GET['id'])) {
   $suppr_id = htmlspecialchars($_GET['id']);
   $post = $bdd->prepare("SELECT FROM posts WHERE id_post=?");
   $post->execute(array($suppr_id));
   $user = $post->fetch();
   if ($user['id_user'] == $_SESSION['id'] || isset($_SESSION['admin'])) {
      $suppr = $bdd->prepare('DELETE FROM posts WHERE id_post = ?');
      $suppr->execute(array($suppr_id));
      $report = $bdd->prepare('SELECT * FROM report WHERE id_post = ?');
      $report->execute(array($suppr_id));
      if ($report->rowCount() > 0) {
         $suppr_report = $bdd->prepare('DELETE FROM report WHERE id_post = ?');
         $suppr_report->execute(array($suppr_id));
      }
      if (isset($_GET['id_user']) and !empty($_GET['id_user'])) {
         $id_user = htmlspecialchars($_GET['id_user']);
         $user = $bdd->prepare('SELECT pseudo FROM users WHERE id = ?');
         $user->execute(array($id_user));
         $pseudo = $user->fetch();
         $pseudo = $pseudo['pseudo'];
         header('location: profile.php?profile=' . $pseudo);
      } else {
         header('location: index.php');
      }
   } else {
      header('location: index.php');
   }
} else {
   header('location: index.php');
}
