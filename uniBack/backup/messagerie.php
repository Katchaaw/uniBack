<?php
session_start();
if (!isset($_SESSION["id"])){
    header('Location: login.php');
}
$bdd = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8;', 'testadmin', '123');

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Messagerie</title>
        <link rel="stylesheet" type="text/css" href="messagerie.css">
    </head>

    <body>
        <header>
            <div>
                <a href="accueil.php"><img src="image/info.png"></a>
            </div>
            <div> 
                <input id="searchbar" type="text" name="search" placeholder="&#x1F50E; Rechercher">  
            </div>
            <div>
                <img src="image/profil.png">
            </div>
        </header>
        
        <div id="list">
            <?php //Affiche tous les utilisateurs du site
            $recupUser = $bdd->query('SELECT * FROM comptes' );
            while($user = $recupUser->fetch()){
                if ($user['Identifiant'] != $_SESSION["id"]){
                ?>
                <div id="user"><img src="image/profil.png"><a href= "msg.php?id=<?php echo $user['Identifiant'];?>"><?php echo $user['Identifiant'];?></a><br></div>
                <?php
                }
            }
            ?>
        </div>

        <script type="text/javascript">
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
            document.documentElement.style.setProperty('--background', '#344D59');
            toggleTheme++;
        }
        </script>


    </body>
</html>