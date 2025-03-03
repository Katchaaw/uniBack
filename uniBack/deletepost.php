<?php
    
    require('session_start_login.php');
    require('mysqli_connex.php');

    //Supprime le post
    $reqposts = "DELETE FROM posts WHERE Id=?;";
    $stmtposts = mysqli_prepare($connex, $reqposts);
    mysqli_stmt_bind_param($stmtposts, 's', $_POST["idpost"]);
    mysqli_stmt_execute($stmtposts);
    mysqli_stmt_close($stmtposts);

    //Supprime le ticket de report.
    $reqrep = "DELETE FROM report WHERE IdPost=?;";
    $stmtrep = mysqli_prepare($connex, $reqrep);
    mysqli_stmt_bind_param($stmtrep, 's', $_POST["idpost"]);
    mysqli_stmt_execute($stmtrep);
    mysqli_stmt_close($stmtrep);

    // Redirection vers la page précédente
    echo "<script>history.back()</script>";
?>