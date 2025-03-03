<?php
    require('session_start_login.php');
    $bdd = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8;', 'testadmin', '123');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message privé</title>
    <link rel="stylesheet" type="text/css" href="msg.css?v=1.1">
</head>

<body>
    <?php
        if(isset($_GET['id']) && !empty($_GET['id'])){

            $receiver = mb_strtolower($_GET['id'], 'UTF-8');

            // On prépare la requête pour récupérer les informations du compte du destinataire
            $reqid = "SELECT * FROM comptes WHERE Identifiant=?";
            $stmtid = $bdd->prepare($reqid);
            $stmtid->execute([$receiver]);
            $val_id = $stmtid->fetch(PDO::FETCH_ASSOC);

            // Si aucun compte n'est trouvé avec cet identifiant, on affiche un message d'erreur et on quitte la page
            if($stmtid->rowCount() <= 0){
                echo "<h3>Utilisateur inexistant <br>";
                echo "<a href=\"messagerie.php\">Retour</a></h3>";
                exit();
            }
        }
        //Sinon affiche un message d'erreur, on redirige l'utilisateur vers la messagerie et on quitte la page
        else{
            echo "<h3>Destinataire non renseigné !<br>";
            echo "<a href=\"messagerie.php\">Retour</a></h3>";
            header('Location: messagerie.php?dest');
            exit();
        }
    ?>

    <header>
        <div class="left">
            <a href="accueil.php"><img src="image/UBsimple.png" width=50px height=50px alt="Accueil"></a>
        </div>
        <div class ="middle">
            <?php
                // On affiche le lien vers le profil du destinataire avec son identifiant et sa photo de profil
                echo "<a href=\"profile.php?id=$receiver\">";
                echo "<img class=\"pp\" src=\"image/profile_pic/" . htmlspecialchars($val_id["ProfilePic"]) . "\" width=20px height=20px>";
                echo htmlspecialchars($receiver);
                echo "</a>";
            ?>
        </div>
        <div class="right">
            <a href="messagerie.php"><img src= "image/back.png" alt="Messagerie"></a>
        </div>
    </header>

    <section class="messages">

        <?php
            // On prépare la requête pour récupérer les messages échangés entre l'utilisateur connecté et le destinataire
            $recupMessage = $bdd->prepare('SELECT * FROM message WHERE (IdReceiver = ? AND IdSender = ?) OR (IdReceiver = ? AND IdSender = ?)');
            $recupMessage->execute(array($_SESSION['id'], $receiver, $receiver, $_SESSION['id']));
            ?>
            <div>-</div> <!--Définit le plafond pour les blocs message-->
            <?php 
            while($message = $recupMessage->fetch()){
                //Date et heure de l'envoi
                if(date("Y-m-d", strtotime("today")) == date("Y-m-d", strtotime($message['Date']))){
                    $dateenstr = "Aujourd'hui à " . date("H:i", strtotime($message['Date']));
                } else if(date("Y-m-d", strtotime("yesterday")) == date("Y-m-d", strtotime($message['Date']))){
                    $dateenstr = "Hier à " . date("H:i", strtotime($message['Date']));
                } else {
                    $dateenstr = "Le " . date("d/m/Y", strtotime($message['Date'])) . " à " . date("H:i", strtotime($message['Date']));
                }
                //Affichage des messages reçus
                if($message['IdReceiver'] == $_SESSION['id']){
                    ?>
                    <div class="received">
                        <p><?=$message['Contenu']; ?>
                        <br><a style="font-size: 55%;"><?=$dateenstr?></a></p>
                        
                    </div>
                    <?php
                } 
                //Affichage des messages envoyés
                else if($message['IdReceiver'] == $receiver){
                    ?>
                    <div class="sended">
                        <p><?=$message['Contenu'];?>
                        <br><a style="font-size: 55%;"><?=$dateenstr?></a></p>
                    </div>
                    <?php
                }
            }
        ?>
        
    </section>

    <div class="message-sender">
        <form action="sendmsg.php?id=<?php echo $receiver;?>" method="post">
        <input type="text" id="message" name="message" placeholder="Entrez votre message...">
            <br><br>
            <input type="submit" name="envoyer">
        </form> 
    </div>        

    <script src="getTheme.js"></script>
</html>