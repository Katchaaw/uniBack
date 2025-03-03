<?php

    require('session_start_login.php');

    $connex = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8', 'testadmin', '123');
    $ident = mb_strtolower($_SESSION["id"], 'UTF-8');
    $reqid = "SELECT * FROM comptes WHERE Identifiant=:identifiant";
    $querid = $connex->prepare($reqid);
    $querid->bindParam(':identifiant', $ident);
    $querid->execute();
    $val_id = $querid->fetch();
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recherche</title>
        <link rel="stylesheet" type="text/css" href="listeStyle.css?v=1.1">
    </head>

    <body>
        <header>
            <div>
                <a href="accueil.php"><img src="image/UBsimple.png" width=50px height=50px alt="Accueil"></a>
            </div>
            <div> 
                <form action="profileSearch.php" method="post">
                    <input id="search" type="text" name="search" placeholder="&#x1F50E">
                </form>
            </div>
            <div>
                <a href = "profile.php"><img src="image/profil.png" alt="Profil"></a>
            </div>
        </header>
        <div id="list">
            <?php //Affiche tous les utilisateurs du site
                if(isset($_POST["search"])){
                    $search = filter_input(INPUT_POST, 'search'); // Récupération de la recherche
                } else {
                    $search = "";
                }
                //Requête pour récupérer tous les utilisateurs correspondant à la recherche
                $query = "SELECT * FROM comptes WHERE Identifiant LIKE :search";
                $result = $connex->prepare($query);
                $result->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                $result->execute();

                // Compteur d'utilisateurs trouvés
                $nbus = 0;
                //Affiche tous les utilisateurs recherchés
                while ($user = $result->fetch(PDO::FETCH_ASSOC)){
                    $nbus++;
                    if ($user['Identifiant'] != $_SESSION["id"]){
                    ?>
                    <a href= "profile.php?id=<?php echo $user['Identifiant'];?>"><div id="user"><img src="image/profile_pic/<?php echo $user['ProfilePic'];?>" alt="Photo de profil de l'utilisateur" width=32px height=32px> <!-- Lien vers la page de profil de l'utilisateur -->
                    <?php echo $user['Identifiant'];?><!-- Affichage de l'identifiant de l'utilisateur --></a><br></div><?php
                    }
                }
                if($nbus == 0){echo "<p> Aucun utilisateur trouvé ! </p>";}
            ?>
        </div>



        <script src="getTheme.js"></script>
    </body>
    
</html>


