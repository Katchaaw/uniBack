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
        <title>Inscription</title>
        <!-- Importe le fichier CSS le plus récent pour le style de la page -->
        <link rel="stylesheet" href="formStyle.css?v=1.1">
    </head>

    <body>
        <div class="container">
            <div class="inscription">
                <div class="logo">
                    <img src="image/UBfull.png" alt="logo" width=125px>
                </div>
                <div id="titre">
                    <h1>Inscrivez-vous pour partager et travailler avec vos amis !</h1>
                </div>
                <div>
                    <form action="versign.php" method="post">
                        <div>
                            <label for="nom">Nom complet :</label>
                            <!-- Affiche la valeur du champ nom s'il a été rempli précédemment -->
                            <input type="text" id="nom" name="nom" <?php if(isset($_POST["nom"])){echo "value=\"" . $_POST["nom"] . "\"";}?> placeholder="Nom et prénom" maxlength="60" required>
                        </div>        
                        <div>
                            <label for="identifiant">Identifiant :</label>
                            <!-- Affiche la valeur du champ identifiant s'il a été rempli précédemment -->
                            <input type="text" id="identifiant" name="identifiant" <?php if(isset($_POST["ident"])){echo "value=\"" . $_POST["ident"] . "\"";}?> maxlength="20" required>
                        </div>
                        <?php
                        // Affiche un message d'erreur si l'identifiant est déjà utilisé
                        if (isset($_GET["idused"])){
                            echo "<p style=\"color:red;font-size:80%;\"> Cet identifiant est déjà pris !</p>";
                        }
                        ?>
                        <div>
                            <label for="ddn">Date de naissance :</label>
                            <!-- Affiche la valeur du champ ddn s'il a été rempli précédemment -->
                            <input type="date" id="ddn" name="ddn" <?php if(isset($_POST["ddn"])){echo "value=\"" . $_POST["ddn"] . "\"";}?> required>
                        </div>
                        <div>
                            <label for="univ">Université / École :</label>
                            <!-- Affiche la valeur du champ univ s'il a été rempli précédemment -->
                            <input type="text" id="univ" name="univ" placeholder="Votre établissement d'enseignement supérieur" <?php if(isset($_POST["univ"])){echo "value=\"" . $_POST["univ"] . "\"";}?> maxlength="100" required>
                        </div>
                        <div>
                            <label for="mdp1">Mot de passe :</label>
                            <!-- Champ de saisie pour le mot de passe -->
                            <input type="password" id="mdp1" name="mdp1" required>
                        </div>
                        <?php 
                        //Vérification que le mot de passe entré respecte les normes de sécurité.
                        if (isset($_GET["mdpnorm"])){
                            // Affichage d'un message d'erreur si le mot de passe ne respecte pas les normes de sécurité
                            echo "<p style=\"color:red;font-size:80%;\"> Le mot de passe ne respecte pas les normes !</p>";
                        }
                        ?>
                        <div>
                            <!-- Information sur les normes de sécurité pour les mots de passe -->
                            <p class="mdp-info">&#9888; Au moins 8 caractères dont 1 majuscule, 1 minuscule, 1 caractère spécial et 1 chiffre </p>
                        </div>
                        <div>
                            <label for="mdp2">Entrez votre mot de passe à nouveau :</label>
                            <!-- Champ de saisie pour confirmer le mot de passe -->
                            <input type="password" id="mdp2" name="mdp2" required>
                        </div>
                        <?php 
                        //Vérification que les deux mots de passe entrés sont identiques.
                        if (isset($_GET["mdpcor"])){
                            // Affichage d'un message d'erreur si les deux mots de passe ne sont pas identiques
                            echo "<p style=\"color:red;font-size:80%;\"> Les deux mots de passe ne correspondent pas !</p>";
                        }
                        ?>
                        <div>
                            <!-- Bouton de soumission du formulaire -->
                            <button type="submit">Continuer</button>
                        </div>
                        <div>
                            <!-- Lien vers la page de connexion pour les utilisateurs qui ont déjà un compte -->
                            <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous !</a></p>
                        </div>
                    </form>
                </div>
            </div>  
            <div>
                <p style="text-align:center;font-size:12px">&copy; UniBack 2023</p>
            </div>  
        </div>
    </body>
        
</html>