<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

if (!isset($_SESSION['pseudo'])) {
   header('location: login.php');
}

//Si l'utilisateur est connecter alors on recuperer ses messages

if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
   $user = $bdd->prepare('SELECT * FROM users');
   $user->execute(array($_SESSION['id']));
?>





   <!DOCTYPE html>
   <html>

   <head>
      <title>Boîte de réception</title>
   </head>

   <body>
      <?php include('menu.php') ?>

      <?php //Verifie si un message a ete envoye precedemment
      if (isset($_SESSION['success'])) { ?>
         <div class="success">
            <h3>
               <?php
               echo "<div class=\"contenu\"><p>" . $_SESSION['success'] . "<p></div>";
               unset($_SESSION['success']);
               ?>
            </h3>
         </div>
      <?php } ?>

      <div class="header">
         <h2>Messagerie</h2>
      </div>
      <a href="envoi.php"><input class="new_mes" type="button" value="Nouveau message"></input></a>
      <ul class="posts">
         <div class="header">
            <h3>Vos contacts :</h3>
         </div>
         <?php //Verifie avec tous les utilisateur si un message a ete envoyer
         $total = 0;
         while ($u = $user->fetch()) {
            $check_msg = $bdd->prepare('SELECT * FROM messages WHERE id_expediteur = ? AND id_destinataire = ? OR id_expediteur = ? AND id_destinataire = ?');
            $check_msg->execute(array($_SESSION['id'], $u['id'], $u['id'], $_SESSION['id']));
            $check_msg_nbr = $check_msg->rowCount();
            if ($check_msg_nbr > 0) {
               echo "<li class=\"post\"><a style=\"text-decoration: none;\" href=\"list_message.php?user=" . $u['id'] . "\"><h3>" . $u['pseudo'] . "</h3></a></h3></li>";
               $total++;
            }
         }
         if ($total == 0)
            echo "<li class=\"post\"><h3>Aucun message recu</h3></h3></li>";
         ?>
      </ul>
   </body>
   <? include('darkmode.php'); ?>

   </html>
<?php } ?>