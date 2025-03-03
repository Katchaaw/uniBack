<?php
    require('session_start_login.php');
    require('mysqli_connex.php');

    // On récupère l'identifiant de l'utilisateur et on le met en minuscules
    $ident = mb_strtolower($_SESSION["id"], 'UTF-8');

    // On prépare la requête pour récupérer les informations de l'utilisateur
    $reqid = "SELECT * FROM comptes WHERE Identifiant=?";
    $stmt = mysqli_prepare($connex, $reqid);
    mysqli_stmt_bind_param($stmt, 's', $ident);
    mysqli_stmt_execute($stmt);
    $querid = mysqli_stmt_get_result($stmt);
    $val_id = mysqli_fetch_assoc($querid);

    // On prépare la requête pour récupérer l'historique des connexions de l'utilisateur
    $reqco = "SELECT IpAddress, IpLocation, Date FROM connectionhist WHERE Identifiant=?;";
    $stmtco = mysqli_prepare($connex, $reqco);
    mysqli_stmt_bind_param($stmtco, 's', $ident);
    mysqli_stmt_execute($stmtco);
    $querco = mysqli_stmt_get_result($stmtco);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Historique des connections</title>
        <link rel="stylesheet" type="text/css" href="profilStyle.css?v=1.1">
    </head>

    <body>
        <div class="left">
            <a href="accueil.php"><img src="image/UBsimple.png" width=50px height=50px alt="Accueil"></a>
        </div>
        <div class="right">
            <a href="profile.php"><img src= "image/back.png" alt="profil"></a>
        </div>     

        <div class="infoProfil">
            <?php
                // On affiche la photo de profil de l'utilisateur et son identifiant
                echo "<a href=\"profile.php\"><img class=\"pp\" src=\"image/profile_pic/" . htmlspecialchars($val_id["ProfilePic"]) . "\" width=32px height=32px><br>";
                echo htmlspecialchars($ident) . " </a><br>";
            ?>
        </div>

        <h3>Historique des connections :</h3>
        <ul>
        <?php
        while($val_co = mysqli_fetch_assoc($querco)){
            // On affiche chaque entrée de l'historique des connexions de l'utilisateur
            echo "<li>Le ".date("d/m/Y à H:i", strtotime($val_co['Date']))." depuis ".htmlspecialchars($val_co['IpAddress'])." (".htmlspecialchars($val_co['IpLocation']).")</li>";
        }
        mysqli_stmt_close($stmtco);
        ?>
        <ul>

        <script src="getTheme.js"></script>
    </body>
</html>
