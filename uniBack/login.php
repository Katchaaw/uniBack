<?php
    //Démarre une session ou redirige si déjà connecté
    require('session_start_home.php');
?>
<!DOCTYPE html>
<html lang="fr">
    
    <head>
        <!-- Spécifie l'encodage des caractères utilisés pour la page web.-->
        <meta charset="UTF-8">
        <!--  Utilisé pour définir le mode de compatibilité des navigateurs. -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Utilisé pour définir la manière dont la page Web doit être affichée sur les appareils mobiles -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <!-- Importe le fichier CSS le plus récent pour le style de la page -->
        <link rel="stylesheet" href="formStyle.css?v=1.1">
    </head>

    <body>
        <div class="container">
            <div class="inscription">
                <div class="logo">
                    <img src="image/UBfull.png" width=125px alt="logo">
                </div>
                <div>
                    <h1>Connexion</h1>
                </div>
                <div>
                    <form action="verlog.php" method="post">
                    <?php //Vérifie si l'identifiant existe dans la bdd.
                    if (isset($_GET["nope"])){
                        echo "<p style=\"color:red;\"> L'identifiant ou le mot de passe est incorrect !</p>";
                    }
                    ?>
                    <div>
                        <label for="id">Identifiant :</label>
                        <input type="id" id="id" name="id" required>
                    </div>        
                    <div>
                        <label for="mdp">Mot de passe :</label>
                        <input type="password" id="mdp" name="mdp" required>
                    </div>
                    <div>
                        <button type="submit">Continuer</button>
                    </div>
                    <div>
                        <p>Vous n'avez pas de compte ? <a href="signin.php">Inscrivez-vous !</a></p>
                    </div>
                    </form>
                </div>
            </div>
            <p style="text-align:center;font-size:12px">&copy; UniBack 2023</p>
        </div>
    </body>

</html>