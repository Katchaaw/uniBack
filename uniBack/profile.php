<?php

    require('session_start_login.php');
    require('mysqli_connex.php');
    require("fonctionAbo.php");

    // On vérifie si l'identifiant passé dans l'URL est différent de celui de la session actuelle
    $isOther = isset($_GET["id"]) && strlen($_GET["id"]) && $_GET["id"] != $_SESSION["id"];

    if($isOther){
        // Si c'est le cas, on stocke les identifiants convertis en minuscules dans deux variables différentes
        $MonIdent = mb_strtolower($_SESSION["id"], 'UTF-8');
        $ident = mb_strtolower($_GET["id"], 'UTF-8');
    } else {
        // Sinon, on utilise l'identifiant de la session actuelle
        $ident = mb_strtolower($_SESSION["id"], 'UTF-8');
    }

    // On exécute une requête préparée pour récupérer les informations de l'utilisateur correspondant à l'identifiant
    $reqid = "SELECT * FROM comptes WHERE Identifiant=?";
    $stmt = mysqli_prepare($connex, $reqid);
    mysqli_stmt_bind_param($stmt, 's', $ident);
    mysqli_stmt_execute($stmt);
    $querid = mysqli_stmt_get_result($stmt);
    $val_id = mysqli_fetch_assoc($querid);

    // On exécute une requête préparée pour récupérer les posts de l'utilisateur correspondant à l'identifiant
    $reqposts = "SELECT Id, IdUser, Date, ContenuTxt, ContenuMedia,  ProfilePic FROM posts, comptes WHERE posts.IdUser=? AND posts.IdUser=comptes.Identifiant ORDER BY posts.Id DESC;";
    $stmtposts = mysqli_prepare($connex, $reqposts);
    mysqli_stmt_bind_param($stmtposts, 's', $ident);
    mysqli_stmt_execute($stmtposts);
    $querposts = mysqli_stmt_get_result($stmtposts);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil de <?php echo $ident; ?></title>
        <link rel="stylesheet" type="text/css" href="profilStyle.css?v=1.1">
    </head>

    <body>
        <div>
            <!-- Lien vers la page d'accueil -->
            <a href="accueil.php"><img src="image/UBsimple.png" width=50px height=50px alt="Accueil"></a>
        </div>

        <div class="infoProfil">
            <?php
                // Si l'utilisateur dont on affiche le profil est différent de celui de la session actuelle
                if($isOther){
                    // On affiche sa photo de profil, son nom d'utilisateur et le bouton d'abonnement correspondant
                    echo "<img class=\"pp\" src=\"image/profile_pic/" . $val_id["ProfilePic"] . "\" width=32px height=32px><br>";
                    echo "$ident <br>";
                    echo quelBouton($ident, $MonIdent);
                } else {
                     // Sinon, on affiche un lien pour changer la photo de profil, son nom d'utilisateur et le nombre d'abonnements/abonnés
                    echo "<a href=\"changePdp.php\"><img class=\"pp\" src=\"image/profile_pic/" . $val_id["ProfilePic"] . "\" width=32px height=32px></a><br>";
                    echo " $ident <br>";
                }
                //On affiche le nombre d'abonnements et d'abonnés.
                echo nbAbon($ident) . ' | ';
                echo nbSubs($ident);
                // Si l'utilisateur dont on affiche le profil est différent de celui de la session actuelle on peut lui envoyer un message.
                if($isOther){
                    echo "<div class=\"histo\"><a href=\"msg.php?id=$ident\">Envoyer un message</a></div>";
                } 
                //Sinon, on peut voir notre historique de connexion.
                else {
                    echo "<div class=\"histo\"><a href=\"cohistory.php\">Historique des connections</a></div>";
                }
            ?>
        </div>

        
        <div class="posts" style="text-align: left;">
            <?php
            while($val_posts = mysqli_fetch_assoc($querposts)){
                // Affiche l'image de profil de l'utilisateur et son ID
                echo "<div class=\"user\">";
                    echo "<div class=\"pdp\"><img src=\"image/profile_pic/".$val_posts['ProfilePic']."\" width=20px height=20px></div>";
                    echo "<div class=\"ident\">".$val_posts['IdUser']."</div>";
                
                // Vérifie si l'utilisateur est propriétaire du post ou s'il est administrateur
                if(!$isOther || $val_id['Admin']){
                    // Affiche le formulaire de suppression du post
                    echo "<form action=\"deletepost.php\" method=\"post\"><input type=\"hidden\" name=\"idpost\" value=\"".$val_posts['Id']."\"><input type=\"submit\" value=\"Supprimer ce post\"></form>";         
                } else {
                    // Affiche le formulaire de signalement du post
                    echo "<form action=\"report.php\" method=\"post\"><input type=\"hidden\" name=\"idpost\" value=\"".$val_posts['Id']."\"><input type=\"submit\" value=\"Signaler ce post\"></form>";
                } 
                echo "</div>";

                // Affiche le contenu textuel du post
                echo $val_posts['ContenuTxt']."<br><br>";

                // Vérifie si le post contient un média et affiche l'image correspondante si c'est le cas
                if(!empty($val_posts['ContenuMedia'])){
                    echo "<a style=\"cursor: pointer;\" onclick=\"window.open('image/postmedia/".$val_posts['ContenuMedia']."', '_blank').focus();\"><img style=\"max-width: 500px;\" src=\"image/postmedia/".$val_posts['ContenuMedia']."\"></a>";
                }           

                // Affiche la date de publication du post
                echo "<div class=\"date\"><p style=\"font-size: 60%;\">Le ".date("d/m/Y à H:i", strtotime($val_posts['Date']))."</p><br><hr><br></div>";
            }
            mysqli_stmt_close($stmtposts);
            ?>
        </div>
        
        <script src="getTheme.js"></script>

    </body>
</html>