<?php
    // On inclut le fichier de démarrage de la session et de vérification de connexion
    require('session_start_login.php');

    // On établit la connexion avec la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8;', 'testadmin', '123');

    // On prépare la requête qui permettra de récupérer les informations de l'utilisateur connecté
    $reqid = "SELECT * FROM comptes WHERE Identifiant=?";
    $stmtid = $bdd->prepare($reqid);
    // On exécute la requête en utilisant le nom d'utilisateur stocké en session
    $stmtid->execute([$_SESSION['id']]);
    // On récupère les informations de l'utilisateur sous forme d'un tableau associatif
    $val_id = $stmtid->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Messagerie</title>
        <link rel="stylesheet" type="text/css" href="messagerie.css?v=1.1">
    </head>

    <body>
        <header>
            <div>
                <a href="accueil.php"><img src="image/UBsimple.png" width=50px height=50px alt="Accueil"></a>
            </div>
            <div> 
                <form action="messagerie.php" method="post">
                    <input id="search" type="text" name="search" placeholder="&#x1F50E Cherchez un utilisateur">
                </form>
            </div>
            <div>
                <!-- On affiche la photo de profil de l'utilisateur connecté -->
                <a href="profile.php"><img src="image/profile_pic/<?php echo $val_id['ProfilePic'];?>" width=32px height=32px alt="Profil"></a>
            </div>
        </header>
        <div id="list">
        <?php
            // Vérifie si le destinataire a été renseigné dans l'URL
            if(isset($_GET["dest"])){
                echo "<p style=\"text-align: center;\">Destinataire non renseigné !</p>";
            }

            // Récupère tous les utilisateurs du site, ou les utilisateurs correspondant à une recherche
            if(isset($_POST["search"])){
                $search = htmlspecialchars($_POST["search"]);
                // Prépare la requête SQL avec une recherche de l'identifiant de l'utilisateur
                $recupUser = $bdd->prepare('SELECT * FROM comptes WHERE Identifiant LIKE :search' );
                $recupUser->execute(array('search' => '%'.$search.'%'));
            } else {
                // Récupère tous les utilisateurs du site
                $recupUser = $bdd->query('SELECT * FROM comptes' );
            }

            // Affiche un maximum de 10 utilisateurs
            $nbus = 0; // Compteur du nombre d'utilisateurs affichés
            while(($nbus < 10) && ($user = $recupUser->fetch())){
                $nbus++;
                // Vérifie si l'utilisateur affiché n'est pas l'utilisateur connecté
                if ($user['Identifiant'] != $_SESSION["id"]){
            ?>
                    <!-- Affichage des informations de l'utilisateur -->
                    <a href= "msg.php?id=<?php echo $user['Identifiant'];?>"><div id="user">
                        <img src="image/profile_pic/<?php echo $user['ProfilePic'];?>" alt="Photo de profil de l'utilisateur" width=32px height=32px>
                        <?php echo $user['Identifiant'];?>
                    </a><br></div>
            <?php
                }
            }

            // Affiche un message si aucun utilisateur n'a été trouvé
            if($nbus == 0){
                echo "<p> Aucun utilisateur trouvé ! </p>";
            }
        ?>
        </div>

        <script src="getTheme.js"></script>

</html>
