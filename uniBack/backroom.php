<?php

// On inclut les fichiers nécessaires.
require('session_start_login.php');
require('mysqli_connex.php');
require("fonctionAbo.php");

// Vérifie si la connexion est définie
if (!isset($connex)){
    header('Location: error503.html');
    exit();
} else {

    // Requêtes pour récupérer les informations de l'utilisateur nécessaire.
    // Les requêtes sont préparées pour éviter les attaques par injection.
    $ident = mb_strtolower($_SESSION["id"], 'UTF-8');
    $reqid = "SELECT * FROM comptes WHERE Identifiant=?";
    $stmt = mysqli_prepare($connex, $reqid);
    mysqli_stmt_bind_param($stmt, 's', $ident);
    mysqli_stmt_execute($stmt);
    $querid = mysqli_stmt_get_result($stmt);
    $val_id = mysqli_fetch_assoc($querid);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backroom</title>
    <link rel="stylesheet" type="text/css" href="backroom.css?v=1.1">
</head>

<body>
    <div class="accueil">
    <header>
        <!-- Lien pour aller sur la page d'accueil -->
        <div>
            <a href="accueil.php"><img src="image/UBsimple.png" width=50px height=50px alt="Accueil"></a>
        </div>
        <!-- Lien pour aller sur la page de profil -->
        <div>
            <a href="profile.php"><img src="image/profile_pic/<?php echo $val_id['ProfilePic'];?>" width=32px height=32px alt="Profil"></a>
        </div>
    </header>
    <div class="centre">
            <ul>
            <?php
                // Requête pour récupérer un post aléatoire de la backroom
                $reqposts = "SELECT posts.Id, posts.IdUser, posts.Date, posts.ContenuTxt, posts.ContenuMedia, comptes.ProfilePic 
                            FROM posts, comptes 
                            WHERE posts.Backroom = 1 AND posts.IdUser=comptes.Identifiant AND posts.IdUser <> ?
                            ORDER BY RAND() LIMIT 1;";
                $stmtposts = mysqli_prepare($connex, $reqposts); // Préparation de la requête SQL
                mysqli_stmt_bind_param($stmtposts, 's', $ident); 
                mysqli_stmt_execute($stmtposts); // Exécution de la requête
                $querposts = mysqli_stmt_get_result($stmtposts); // Récupération des résultats
                $val_posts = mysqli_fetch_assoc($querposts); // Récupération des données du post

                if(isset($val_posts)){ // Si un post est trouvé
                    // Affichage de l'auteur du post et de sa photo de profil
                    echo "<a href=\"profile.php?id=".$val_posts['IdUser']."\"><img id =\"pdp\" src=\"image/profile_pic/".$val_posts['ProfilePic']."\" width=20px height=20px>".$val_posts['IdUser']."</a><br>";




                    // Affichage du contenu textuel du post
                    echo "<br>".$val_posts['ContenuTxt']."<br><br>";

                    // Si le post contient du contenu multimédia, on affiche une image cliquable qui ouvre une nouvelle fenêtre avec le contenu multimédia
                    if(!empty($val_posts['ContenuMedia'])){
                        echo "<a style=\"cursor: pointer;\" onclick=\"window.open('image/postmedia/".$val_posts['ContenuMedia']."', '_blank').focus();\"><img style=\"max-width: 500px;\" src=\"image/postmedia/".$val_posts['ContenuMedia']."\"></a><br><br>";
                    }

                    // Si l'utilisateur courant est l'auteur du post ou s'il est administrateur, on affiche un bouton pour supprimer le post, sinon on affiche un bouton pour signaler le post
                    if($val_posts['IdUser']===$ident || $val_id['Admin']){
                        echo "<form action=\"deletepost.php\" method=\"post\"><input type=\"hidden\" name=\"idpost\" value=\"".$val_posts['Id']."\"><input type=\"submit\" value=\"Supprimer ce post\"></form>";         
                    } else {
                        echo "<form action=\"report.php\" method=\"post\"><input type=\"hidden\" name=\"idpost\" value=\"".$val_posts['Id']."\"><input type=\"submit\" value=\"Signaler ce post\"></form>";
                    }                    

                    // Affichage de la date de publication du post
                    echo "<p style=\"font-size: 60%;\">Le ".date("d/m/Y à H:i", strtotime($val_posts['Date']))."</p><br>";

                    // Affichage d'un bouton pour afficher un autre post aléatoire de la backroom
                    echo "<form action=\"backroom.php\"><input type=\"submit\" value=\"Post aléatoire suivant\"></form>";
                } else {
                    // Si aucun post n'est trouvé, on affiche un message
                    echo "<p>Rien dans les backrooms !</p>";
                }
                mysqli_stmt_close($stmtposts);
            ?>
        </div>
    </div>
    <script src="getTheme.js"></script>

</body>
    
</html>