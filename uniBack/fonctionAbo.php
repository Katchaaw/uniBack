<?php

//Retourne le nombre d'abonnés.
function nbSubs($Identifiant){
    $connex = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    // Échapper les caractères spéciaux dans l'identifiant
    $Identifiant = mysqli_real_escape_string($connex, $Identifiant);
    
    // Utiliser une requête préparée avec un paramètre pour éviter les injections SQL
    $stmt = mysqli_prepare($connex, "SELECT COUNT(*) FROM follows WHERE Account=?");
    mysqli_stmt_bind_param($stmt, "s", $Identifiant);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nbAbo);
    mysqli_stmt_fetch($stmt);
    echo $nbAbo;
    if($nbAbo < 2){echo " abonné";}else{echo " abonnés";};
}

//Retourne le nombre d'abonnements
function nbAbon($Identifiant){
    $connex = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    // Échapper les caractères spéciaux dans l'identifiant
    $Identifiant = mysqli_real_escape_string($connex, $Identifiant);
    
    // Utiliser une requête préparée avec un paramètre pour éviter les injections SQL
    $stmt = mysqli_prepare($connex, "SELECT COUNT(*) FROM follows WHERE Follower=?");
    mysqli_stmt_bind_param($stmt, "s", $Identifiant);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nbAbo);
    mysqli_stmt_fetch($stmt);
    echo $nbAbo;
    if($nbAbo < 2){echo " abonnement";}else{echo " abonnements";};
} 

//Insère l'abonnement dans la base de données.
function abonnement($Identifiant, $id_sub){
    $connex = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Échapper les caractères spéciaux dans l'identifiant et l'id_sub
    $Identifiant = mysqli_real_escape_string($connex, $Identifiant);
    $id_sub = mysqli_real_escape_string($connex, $id_sub);

    // Utiliser une requête préparée avec des paramètres pour éviter les injections SQL
    $stmt = mysqli_prepare($connex, "INSERT INTO follows (Account, Follower) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $Identifiant, $id_sub);
    mysqli_stmt_execute($stmt);
}

//Permet de se désabonner en supprimant l'enregistrement dans la base de données.
function desabonnement($Identifiant, $id_sub){
    $connex = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Échapper les caractères spéciaux dans l'identifiant et l'id_sub
    $Identifiant = mysqli_real_escape_string($connex, $Identifiant);
    $id_sub = mysqli_real_escape_string($connex, $id_sub);

    // Utiliser une requête préparée avec des paramètres pour éviter les injections SQL
    $stmt = mysqli_prepare($connex, "DELETE FROM follows WHERE Account=? AND Follower=?");
    mysqli_stmt_bind_param($stmt, "ss", $Identifiant, $id_sub);
    mysqli_stmt_execute($stmt);
}

//Vérifie si l'utilisateur est suivi ou non.
function isSub($Identifiant, $id_sub){
    $connex = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $req = mysqli_prepare($connex, "SELECT * FROM follows WHERE Follower = ? AND Account = ?");
    mysqli_stmt_bind_param($req, "ss", $id_sub, $Identifiant);
    mysqli_stmt_execute($req);
    $res = mysqli_stmt_get_result($req);

    if(mysqli_num_rows($res) == 0) {
        return 0;
    } else {
        return 1;
    }
}

//Affiche un bouton "S'abonner" ou "Se désabonner" selon si l'utilisateur est déjà suivi ou non.
function quelBouton($Identifiant, $id_sub) {
    if(!isSub($Identifiant, $id_sub)) {
        echo "<form action=\"subscription.php\" method=\"post\"> 
            <input type=\"hidden\" name=\"Identifiant\" value=\"$Identifiant\">
            <input type=\"hidden\" name=\"id_sub\" value=\"$id_sub\">
            <input type=\"submit\" value=\"S'abonner\"> 
        </form>";
    } else {
        echo "<form action=\"subscription.php\" method=\"post\">
            <input type=\"hidden\" name=\"Identifiant\" value=\"$Identifiant\">
            <input type=\"hidden\" name=\"id_sub\" value=\"$id_sub\">
            <input type=\"submit\" value=\"Se désabonner\">
        </form>";
    }
}
?>