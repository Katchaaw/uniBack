<?php
    // Démarre une session
    require('session_start_home.php');

    // Vérifie si l'identifiant est bien envoyé en POST
    if (!isset($_POST["id"])){
        // Redirige l'utilisateur vers la page de login s'il manque des informations
        header('Location: login.php');
        exit();
    }

    // Connecte à la base de données MySQL
    require('mysqli_connex.php');

    // Récupère l'identifiant en minuscules et nettoie les données
    $ident = mb_strtolower(filter_input(INPUT_POST, "id"), 'UTF-8');

    // Prépare une requête pour récupérer les informations de compte
    $reqid = "SELECT * FROM comptes WHERE Identifiant=?";
    $stmt = mysqli_prepare($connex, $reqid);

    // Lie le paramètre de l'identifiant à la requête
    mysqli_stmt_bind_param($stmt, "s", $ident);

    // Exécute la requête
    mysqli_stmt_execute($stmt);

    // Récupère les résultats de la requête
    $querid = mysqli_stmt_get_result($stmt);

    // Récupère la première ligne des résultats sous forme de tableau associatif
    $val_id = mysqli_fetch_assoc($querid);

    // Si l'identifiant n'existe pas dans la base de données
    if (!isset($val_id['Identifiant'])){
        // Redirige l'utilisateur vers la page de login avec un message d'erreur
        header('Location: login.php?nope');
        exit();
    } 
    else {
        // Si le mot de passe ne correspond pas à celui stocké dans la base de données
        if (!password_verify($_POST["mdp"], $val_id['Mdp'])){
            // Redirige l'utilisateur vers la page de login avec un message d'erreur
            header('Location: login.php?nope');
            exit();
        } 
        else {
            // Enregistrement de la connexion dans la base avec l'IP et le lieu de connexion
            $reqacc = $connex->prepare("INSERT INTO connectionhist(Identifiant, IpAddress, IpLocation) VALUES (?, ?, ?)");

            // Récupère l'adresse IP de l'utilisateur
            $ip = $_SERVER['REMOTE_ADDR'];

            // Récupère les informations géographiques de l'adresse IP
            $details = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));

            // Si les informations géographiques sont disponibles
            if(property_exists($details, "loc")){
                // Stocke la ville et le pays correspondants
                $iploc = "$details->city [$details->country]";
            } else {
                // Sinon, indique que le lieu est introuvable ou l'adresse IP est locale
                $iploc = "Lieu introuvable ou IP locale au serveur";
            }

            // Lie les paramètres de la requête avec les valeurs correspondantes
            $reqacc->bind_param("sss", $ident, $ip, $iploc); 

            // Exécute la requête
            $reqacc->execute();

            // Stocke l'identifiant dans la session
            $_SESSION["id"]=htmlspecialchars($ident);

            // Redirige l'utilisateur vers la page d'accueil
            header('Location: accueil.php');
            exit();
        }
    }
?>