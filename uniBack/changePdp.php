<?php
    require('session_start_login.php');
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photo de profil</title>
        <link rel="stylesheet" type="text/css" href="pdpStyle.css?v=1.1">
    </head>

    <body>
        <a href="profile.php"><img src = "image/back.png"></a>
        <h1>Changez votre photo de profil :</h1>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
                <label for="image">Sélectionnez une image à enregistrer : </label>
                <div class="formats">
                    <p>Seuls les formats <i>jpg</i>, <i>jpeg</i> et <i>png</i> sont acceptés (2mo max)<p>
                </div>
                
                <div class="select">
                    <br>
                    <input type="file" id="image" name="image"><br>
                    <?php
                    if(isset($_GET['ext'])){echo "<b style=\"color:red;\">Extension non autorisée, veuillez sélectionner un fichier JPEG, PNG ou GIF.</b><br>";}
                    if(isset($_GET['size'])){echo "<b style=\"color:red;\">Taille de fichier maximale dépassée (2Mo).</b><br>";}
                    ?>
                    <br><input type="submit" value="Enregistrer">
                </div>
            </div>
            
        </form>
        <form action="defaultpic.php" method="POST" id="default">
            <h3>Rétablissez la photo de profil par défaut :</h3>
            <input type="submit" id="default" value="Photo par défaut">
        </form>

        <script src="getTheme.js"></script>

    </body>
</html>
