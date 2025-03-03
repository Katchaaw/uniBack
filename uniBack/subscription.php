<?php

    require('session_start_login.php'); 
    require('mysqli_connex.php');
    require("fonctionAbo.php");

    // Récupère les informations de l'utilisateur et de l'abonnement 
    $Identifiant = $_POST["Identifiant"]; 
    $id_sub = $_POST["id_sub"];

    
    if(!isSub($Identifiant, $id_sub)){ // Si l'utilisateur n'est pas abonné
        // L'abonner à l'abonnement en question
        abonnement($Identifiant, $id_sub);
    } else {
        // Le désabonner de l'abonnement en question
        desabonnement($Identifiant, $id_sub);
    }

    // Rediriger l'utilisateur vers la page précédente
    echo "<script>history.back()</script>";
?>