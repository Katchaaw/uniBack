<?php
session_start();
if (!isset($_SESSION["id"])){
    header('Location: login.php');
}
$bdd = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8;', 'testadmin', '123');


if(isset($_GET['id']) AND !empty($_GET['id'])){

    $getId = mb_strtolower($_GET['id'], 'UTF-8');
    $recupUser = $bdd->prepare('SELECT * FROM comptes WHERE Identifiant = ?');
    $recupUser->execute(array($getId));

    if($recupUser->rowCount() <= 0){
        echo "<h3>Utilisateur inexistant <br>";
        echo "<a href=\"messagerie.php\">Retour</a></h3>";
        exit;
    }
}else{
    echo "<h3>Destinataire non renseigné !<br>";
    echo "<a href=\"messagerie.php\">Retour</a></h3>";
    exit;
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message privées</title>
    <link rel="stylesheet" type="text/css" href="msg.css">
</head>

<body>
    <h2><a href="accueil.php">Accueil</a></h2>
    <h3><a href="messagerie.php">Messagerie</a></h3>
    <form method="post" action="sendmsg.php?id=<?php echo $getId; ?>">
        <textarea name ="message"></textarea>
        <br/><br/>
        <input type="submit" name="envoyer">
    </form>

    <section id="messages">

        <?php
            $recupMessage = $bdd->prepare('SELECT * FROM message WHERE (IdReceiver = ? AND IdSender = ?) OR (IdReceiver = ? AND IdSender = ?)');
            $recupMessage->execute(array($_SESSION['id'], $getId, $getId, $_SESSION['id']));
            while($message = $recupMessage->fetch()){
                //Messages reçus
                if($message['IdReceiver'] == $_SESSION['id']){
                    ?>
                    <p style="color:blue;"><?= "$getId : " . $message['Contenu']; ?></p>
                    <?php
                } 
                //Messages envoyés
                else if($message['IdReceiver'] == $getId){
                    ?>
                    <p style="color:red;"><?= "Vous : " . $message['Contenu']; ?></p>
                    <?php
                }

            }
        ?>
    </section>
</body>
</html>
