<?php

    require('session_start_login.php');
    require('mysqli_connex.php');

    // Requêtes pour récupérer les informations de l'utilisateur nécessaire. Les requêtes sont préparées pour éviter les attaques par injection.
    $ident = mb_strtolower($_SESSION["id"], 'UTF-8');
    $reqid = "SELECT * FROM comptes WHERE Identifiant=?";
    $stmt = mysqli_prepare($connex, $reqid);
    mysqli_stmt_bind_param($stmt, 's', $ident);
    mysqli_stmt_execute($stmt);
    $querid = mysqli_stmt_get_result($stmt);
    $val_id = mysqli_fetch_assoc($querid);
    mysqli_stmt_close($stmt);
?>


<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil</title>
        <link rel="stylesheet" type="text/css" href="homeStyle.css?v=1.1">
    </head>

    <body>
        <header>
            <div class="home">
                <a href="accueil.php"><img src="image/UBsimple.png" width=50px height=50px alt="Accueil"></a>
            </div>
            <div>
                <form action="profileSearch.php" method="post">
                    <input id="search" type="text" name="search" placeholder="&#x1F50E Cherchez un utilisateur">
                </form>
            </div>
            <div>
                <a href="profile.php"><img src="image/profile_pic/<?php echo $val_id['ProfilePic'];?>" width=32px height=32px alt="Profil"></a>
            </div>
        </header>
        <div class="centre">
            <div class="left">
                <ul>
                    <?php
                    if ($val_id['Admin'] == 1){
                        echo "<li> <div> <img src=\"image/admin.png\"> <a href=\"adminReports.php\">ADMINISTRATION</a> </div> </li>";
                    }
                    ?>
                    <li> <div> <img src="image/message.png"> <a href="messagerie.php">Messagerie</a> </div> </li>
                    <li> <div> <img src="image/profile_pic/<?php echo $val_id['ProfilePic'];?>"> <a href="profile.php"><?php echo $_SESSION["id"];?></a> </div> </li>
                    <li> <div class="changeTheme"> <img id="oeil" src="image/oeil.png"> <a href="#">Mode nuit/jour</a></div> </li>
                    <li> <div> <img src="image/attention.png"> <a href="backroom.php">Backroom</a> </div> </li>
                    <li> <div> <img src="image/logout.png"> <a href="logout.php">Déconnexion</a> </div> </li>
                    <li> <div class="box-post"> <a href="post.php">Poster</a> </div> </li>
                </ul>
            </div>
            <div id="posts">
            <?php
            //Requêtes pour récupérer les posts
            $reqposts = "SELECT posts.Id, posts.IdUser, posts.Date, posts.ContenuTxt, posts.ContenuMedia, comptes.ProfilePic FROM posts, comptes, follows WHERE posts.IdUser=follows.Account AND follows.follower=? AND posts.IdUser=comptes.Identifiant ORDER BY posts.Id DESC;";
            $stmtposts = mysqli_prepare($connex, $reqposts);
            mysqli_stmt_bind_param($stmtposts, 's', $ident);
            mysqli_stmt_execute($stmtposts);
            $querposts = mysqli_stmt_get_result($stmtposts);
            $nbposts = 0;
            while($val_posts = mysqli_fetch_assoc($querposts)){
                $nbposts++;
                // Affichage de l'auteur du post et de sa photo de profil
                echo "<a href=\"profile.php?id=".$val_posts['IdUser']."\"><img src=\"image/profile_pic/".$val_posts['ProfilePic']."\" width=20px height=20px>".$val_posts['IdUser']."</a><br><br>";
                

                // Affiche le contenu textuel du post
                echo "<div class=\"textContent\">".$val_posts['ContenuTxt']."</div><br><br>";

                // Vérifie si le post contient un média et affiche l'image correspondante si c'est le cas
                if(!empty($val_posts['ContenuMedia'])){
                    echo "<a style=\"cursor: pointer;\" onclick=\"window.open('image/postmedia/".$val_posts['ContenuMedia']."', '_blank').focus();\"><img style=\"max-width: 500px;\" src=\"image/postmedia/".$val_posts['ContenuMedia']."\"></a><br><br>";
                }

                // Vérifie si l'utilisateur est propriétaire du post ou s'il est administrateur
                if($val_posts['IdUser']===$ident || $val_id['Admin']){
                    // Affiche le formulaire de suppression du post
                    echo "<form action=\"deletepost.php\" method=\"post\"><input type=\"hidden\" name=\"idpost\" value=\"".$val_posts['Id']."\"><input type=\"submit\" value=\"Supprimer ce post\"></form>";         
                } else {
                    // Affiche le formulaire de signalement du post
                    echo "<form action=\"report.php\" method=\"post\"><input type=\"hidden\" name=\"idpost\" value=\"".$val_posts['Id']."\"><input type=\"submit\" value=\"Signaler ce post\"></form>";
                }                

                // Affiche la date de publication du post
                echo "<p style=\"font-size: 60%;\">Le ".date("d/m/Y à H:i", strtotime($val_posts['Date']))."</p><br><hr><br>";
            }
            echo"</div>";

            //Si aucun abonnements
            if($nbposts<1){
                //Affiche un message conseillant de s'abonner à quelqu'un
                echo "<p style=\"text-align: center;\">Allez dans les backrooms, ou recherchez d'autre utilisateurs et abonnez vous pour avoir du contenu dans votre fil !</p>";
            }
            mysqli_stmt_close($stmtposts);
            ?>
        </div>
        <script src="setTheme.js"></script>
    </body>
    
</html>