<?php 
    //Simple fonction permettant de se déconnecter.
    session_start();
    session_destroy();
    header('Location: login.php');
?>