<?php
// Démarre une session
session_start();
// Si l'utilisateur est déjà connecté, le redirige vers la page d'accueil
if (isset($_SESSION["id"])){
    header('Location: accueil.php');
    exit();
}
?>
