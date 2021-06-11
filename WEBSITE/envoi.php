<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=database', 'root', '');

if (!isset($_SESSION['pseudo'])) {
   header('location: login.php');
}

if (isset($_GET['reply'])) {
   $user = htmlspecialchars($_GET['reply']);
} else {
   $user = "";
}

//Verifie si l'utisateur est connecter

if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {

   //Verifie que le message soit bien envoyer via POST

   if (isset($_POST['envoi_message'])) {

      //Recuperer les informations envoyer

      $destinataire = htmlspecialchars($_POST['destinataire']);
      $message = htmlspecialchars($_POST['message']);

      //Verifie que le destinataire existe bien

      $id_destinataire = $bdd->prepare('SELECT id FROM users WHERE pseudo = ?');
      $id_destinataire->execute(array($destinataire));
      $dest_exist = $id_destinataire->rowCount();

      //Si il existe on envoi le message dans la base de donnee

      if ($dest_exist == 1) {

         $id_destinataire = $id_destinataire->fetch();
         $id_destinataire = $id_destinataire['id'];
         $date = date("Y-m-d H:i");
         $ins = $bdd->prepare("INSERT INTO messages (id_expediteur, id_destinataire, message, date) VALUES (?, ?, ?, ?)");
         $ins->execute(array($_SESSION['id'], $id_destinataire, $message, $date));
         header('location: message.php');
      } else {

         $error = "Cet utilisateur n'existe pas";
      }
   }
   if (isset($_GET['return']) and !empty($_GET['return'])) {
      $return = htmlspecialchars($_GET['return']);
      header('location: list_message.php?user=' . $_GET['return']);
   }
?>


   <!DOCTYPE html>
   <html>

   <head>
      <title>Envoyer un message</title>
   </head>

   <body>
      <?php include('menu.php') ?>
      <div class="contenu">
         <div class="header">
            <h2>Nouveau message</h2>
         </div>
         <form method="POST">
            <input type="text" name="destinataire" placeholder="Destinataire" value="<? echo $user; ?>" required />
            <textarea type="text" class="message" name="message" placeholder="Message" required></textarea><br><br>
            <button type="submit" value="Envoyer" name="envoi_message">Envoyer le message</button>
            <?php if (isset($error)) {
               echo '<p style="color:red">' . $error . '</p>';
            } ?>
         </form>
         <br />
         <a href="message.php"><input value="Boîte de réception" type="button"></button></a>
      </div>
   </body>
   <? include('darkmode.php'); ?>

   </html>
<?php
}
?>