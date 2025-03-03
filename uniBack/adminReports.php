<?php

require('session_start_login.php');
require('mysqli_connex.php');
require("fonctionAbo.php");


// Requête pour obtenir les signalements de posts
$reqreport = "SELECT posts.Id AS Id, posts.IdUser, posts.Date, posts.ContenuTxt, posts.ContenuMedia, report.Id AS IdRep, report.IdReporter, comptes.ProfilePic FROM posts, report, comptes WHERE posts.Id=report.IdPost AND posts.IdUser=comptes.Identifiant ORDER BY report.Id DESC;";
$stmtreport = mysqli_prepare($connex, $reqreport);
mysqli_stmt_execute($stmtreport);
$querreport = mysqli_stmt_get_result($stmtreport);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="adminReportsStyle.css?v=1.1">
    </head>

    <body>
        <header>
            <div>
                <a href="accueil.php"><img src="image/UBsimple.png" width=50px height=50px alt="Accueil"></a>
            </div>
            <div>
                <h1>Espace administrateur</h1>
            </div>

        </header>
        <?php
        //Affiche la liste des reports.
        while($val_report = mysqli_fetch_assoc($querreport)){
            //Affiche la photo de profil de l'auteur du post, son identifiant et qui l'a report.
            echo "<div class=\"pdp\"><a href=\"profile.php?id=".$val_report['IdUser']."\"><img src=\"image/profile_pic/".$val_report['ProfilePic']."\" width=20px height=20px>".$val_report['IdUser']."</a>".
            " / Signalé par <a href=\"profile.php?id=".$val_report['IdReporter']."\">".$val_report['IdReporter']."</a><br><br>";
            
            //Affiche le contenu du post
            echo $val_report['ContenuTxt']."<br><br>";

            //Affiche le contenu media du post s'il y en a
            if(!empty($val_report['ContenuMedia'])){
                echo "<a style=\"cursor: pointer;\" onclick=\"window.open('image/postmedia/".$val_report['ContenuMedia']."', '_blank').focus();\"><img style=\"max-width: 500px;\" src=\"image/postmedia/".$val_report['ContenuMedia']."\"></a><br><br>";
            }

            //Affiche les deux cas possibles : un bouton pour supprimer le post, et un autre pour le garder.
            echo "<div class=\"container\">";
                echo "<form action=\"reportdel.php\" method=\"post\"><input type=\"hidden\" name=\"idrep\" value=\"".$val_report['IdRep']."\"><input type=\"hidden\" name=\"idpost\" value=\"".$val_report['Id']."\"><input type=\"submit\" value=\"Supprimer ce post\"></form>";         
                echo "<form action=\"reportdel.php\" method=\"post\"><input type=\"hidden\" name=\"idrep\" value=\"".$val_report['IdRep']."\"><input type=\"submit\" value=\"Garder ce post\"></form>";         
            echo "</div>";

            //Affiche la date de la création du post.
            echo "<p style=\"font-size: 60%;\">".$val_report['Date']."</p><br><hr><br>";
        }
        mysqli_stmt_close($stmtreport);
        ?>



        <script src="getTheme.js"></script>
    </body>
</html>