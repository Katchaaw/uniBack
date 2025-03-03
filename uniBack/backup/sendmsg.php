<?php
session_start();
if (!isset($_SESSION["id"])){
    header('Location: login.php');
}
$bdd = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8;', 'testadmin', '123');

$getId = mb_strtolower($_GET['id'], 'UTF-8');


if(isset($_POST['envoyer'])){
    $message = htmlspecialchars($_POST['message']);
    $idMessQr = $bdd->query('SELECT COUNT(*) FROM message');
    $idMess = ($idMessQr->fetch())[0] + 1;
    $insererMessage = $bdd -> prepare('INSERT INTO message(Id, Contenu, IdSender, IdReceiver)VALUES(?, ?, ?, ?)');
    $insererMessage-> execute(array($idMess, $message, $_SESSION["id"],$getId ));
}
header("Location: msg.php?id=$getId");


?>