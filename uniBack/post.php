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
        <title>Poster</title>
        <link rel="stylesheet" type="text/css" href="posteSheet.css?v=1.1">
    </head>

    <body>
        <!-- Bouton de retour -->
        <a href="accueil.php"><img src="image/back.png" alt="retour"></a>

        <!-- Formulaire pour poster un contenu -->
        <form method="post" action="sendpost.php" enctype="multipart/form-data">
            <textarea name="postcontent" style="min-width: 30%;min-block-size: 100px;" placeholder="Que voulez-vous dire ?" ><?php if(isset($_POST["content"])){echo $_POST["content"];} ?></textarea><br>

            <!-- Champ de sélection d'image -->
            <label style="font-size:80%;">Sélectionnez une image à enregistrer (<i>jpg</i>, <i>jpeg</i>, <i>png</i> ou <i>gif</i> / 10 Mo max.) :</label>
            <input type="file" id="image" name="image"><br>
            <?php
            if(isset($_GET['ext'])){echo "<b style=\"color:red;\">Extension non autorisée, veuillez sélectionner un fichier JPEG, PNG ou GIF.</b><br>";}
            if(isset($_GET['size'])){echo "<b style=\"color:red;\">Taille de fichier maximale dépassée (10Mo).</b><br>";}
            ?>

            <!-- Case à cocher pour publier dans les backrooms -->
            <input type="checkbox" name="backroom" value="Backroom">Publier dans les backrooms<br>

            <!-- Bouton de soumission du formulaire -->
            <input type="submit" name="envoyer" value="Poster">
        </form>

        <!-- Script pour récupérer le thème actuel -->
        <script src="getTheme.js"></script>
    </body>
</html>