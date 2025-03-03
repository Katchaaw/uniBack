<?php
    require('session_start_login.php');

    $bdd = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8;', 'testadmin', '123');
    $getId = mb_strtolower($_GET['id'], 'UTF-8');

    if(isset($_POST['envoyer'])){
        // On récupère le contenu du message
        $message = htmlspecialchars($_POST['message']);

        // On récupère l'ID du dernier message dans la base de données et on ajoute 1 pour obtenir le nouvel ID
        $idMessQr = $bdd->query('SELECT MAX(Id) FROM message');
        $idMess = ($idMessQr->fetch())[0] + 1;

        // On prépare la requête d'insertion du message dans la base de données
        $insererMessage = $bdd -> prepare('INSERT INTO message(Id, Contenu, IdSender, IdReceiver) VALUES(:idMess, :message, :idSender, :idReceiver)');
        $insererMessage->bindParam(':idMess', $idMess);
        $insererMessage->bindParam(':message', $message);
        $insererMessage->bindParam(':idSender', $_SESSION["id"]);
        $insererMessage->bindParam(':idReceiver', $getId);

        // On exécute la requête
        $insererMessage->execute();
    }

    // On redirige l'utilisateur vers la page de messagerie avec l'ID du destinataire dans l'URL
    header("Location: msg.php?id=$getId");

?>