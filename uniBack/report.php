<?php

    require('session_start_login.php');
    $bdd = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8;', 'testadmin', '123');

    $postno = $_POST['idpost'];
    $idReportQr = $bdd->query('SELECT MAX(Id) FROM report');
    $idReport = ($idReportQr->fetch())[0] + 1;
    $insererMessage = $bdd -> prepare('INSERT INTO report VALUES(?, ?, ?)');
    $insererMessage-> execute(array($idReport, $postno, $_SESSION["id"]));

    // Redirection vers la page précédente
    echo "<script>history.back()</script>";
    exit();
?>