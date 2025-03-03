<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'testadmin');
    define('DB_PASSWORD', '123');
    define('DB_NAME', 'bddres');

    $connex = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (!$connex) {
        header('Location: error503.html');
        exit();
    }
?>  