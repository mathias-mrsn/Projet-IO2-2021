<?php

$bdd = new PDO("mysql:host=127.0.0.1;dbname=database;charset=utf8", "root", "");

if (isset($_GET['follower']) and isset($_GET['following']) and !empty($_GET['follower']) and !empty($_GET['following'])) {

    $follower = htmlspecialchars($_GET['follower']);
    $following = htmlspecialchars($_GET['following']);

    if ($_GET['action'] == 0) { //Desabonner

        $suppr = $bdd->prepare("DELETE FROM `follow` WHERE follower = ? AND following = ?");
        $suppr->execute(array($follower, $following));
    }

    if ($_GET['action'] == 1) { //Abonner

        $ins = $bdd->prepare("INSERT INTO follow (follower, following) VALUES (?, ?)");
        $ins->execute(array($follower, $following));
    }
}
header('location:profile.php?profile=' . $_GET['following']);
