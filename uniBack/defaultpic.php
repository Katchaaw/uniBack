<?php
    //Permet de remettre la photo de profil par défaut.

    require('session_start_login.php');
    require('mysqli_connex.php');

    $ident = mb_strtolower($_SESSION["id"], 'UTF-8');
    $sqlq = "UPDATE comptes SET ProfilePic='default.jpg' WHERE Identifiant = '$ident'"; //Rétablit la photo de profil par défaut
    mysqli_query($connex, $sqlq);
    header('Location: profile.php');
    exit();

?>