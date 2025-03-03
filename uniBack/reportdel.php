<?php

    require('session_start_login.php');
    require('mysqli_connex.php');

    // Requête SQL pour supprimer un signalement
    $reqrep = "DELETE FROM report WHERE report.Id=?;";
    $stmtrep = mysqli_prepare($connex, $reqrep);
    mysqli_stmt_bind_param($stmtrep, 's', $_POST["idrep"]);
    mysqli_stmt_execute($stmtrep);
    mysqli_stmt_close($stmtrep);

    //Supprime le post s'il existe.
    if(isset($_POST['idpost'])){
        $reqposts = "DELETE FROM posts WHERE posts.Id=?;";
        $stmtposts = mysqli_prepare($connex, $reqposts);
        mysqli_stmt_bind_param($stmtposts, 's', $_POST["idpost"]);
        mysqli_stmt_execute($stmtposts);
        mysqli_stmt_close($stmtposts);
    }

    // Redirection vers la page précédente
    echo "<script>history.back()</script>";
    exit();
?>