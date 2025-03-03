<?php
// Démarre une session
session_start();
// Si l'utilisateur n'est pas connecté, le redirige vers la page de connexion.
if (!isset($_SESSION["id"])){
    header('Location: login.php');
    exit();
}
?>