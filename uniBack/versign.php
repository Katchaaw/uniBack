<?php
    //Démarre une session ou redirige si déjà connecté
    require('session_start_home.php');

    if (!isset($_POST["identifiant"])) {
        header('Location: login.php');
        exit();
    }
    
    //Connexion à la base de données.
    require('mysqli_connex.php');

    // Validation des entrées utilisateur
    $ident = mb_strtolower(filter_input(INPUT_POST, "identifiant"), 'UTF-8');
    $nom = filter_input(INPUT_POST, "nom");
    $ddn = filter_input(INPUT_POST, "ddn");
    $univ = filter_input(INPUT_POST, "univ");
    
    // Utilisation d'une requête préparée pour éviter les injections SQL
    $reqid = $connex->prepare("SELECT * FROM comptes WHERE Identifiant = ?");
    $reqid->bind_param("s", $ident);
    $reqid->execute();
    $result = $reqid->get_result()->fetch_assoc();

    if ($result !== null) {
        //Renvoi vers le formulaire en cas d'erreur utilisateur avec le contenu sauvegardé
        echo "<form action=\"signin.php?idused\" id=\"returnform\" method=\"post\">";
        require('verifMdp.php');
    }

    $verifMdpNorm = (strlen($_POST["mdp1"]) >= 8) && preg_match('@[a-z]@', $_POST["mdp1"]) && preg_match('@[A-Z]@', $_POST["mdp1"]) && preg_match('@[^\w]@', $_POST["mdp1"]);

    if (!$verifMdpNorm){
        //Renvoi vers le formulaire en cas d'erreur utilisateur avec le contenu sauvegardé
        echo "<form action=\"signin.php?mdpnorm\" id=\"returnform\" method=\"post\">";
        require('verifMdp.php');
    }

    $verifMdpCor = $_POST["mdp1"]==$_POST["mdp2"];

    if (!$verifMdpCor){
        //Renvoi vers le formulaire en cas d'erreur utilisateur avec le contenu sauvegardé
        echo "<form action=\"signin.php?mdpcor\" id=\"returnform\" method=\"post\">";
        require('verifMdp.php');
    }

    // Hashage du mot de passe
    $theMdp = password_hash($_POST["mdp1"], PASSWORD_DEFAULT);

    // Utilisation d'une requête préparée pour éviter les injections SQL
    $reqacc = $connex->prepare("INSERT INTO comptes VALUES (?, ?, 'default.jpg', ?, ?, ?, 0)");
    $reqacc->bind_param("sssss", $ident, $nom, $theMdp, $ddn, $univ);
    $reqacc->execute();

    //Enregistre la connexion dans la base avec l'IP et le lieu de connexion
    $reqacc = $connex->prepare("INSERT INTO connectionhist(Identifiant, IpAddress, IpLocation) VALUES (?, ?, ?)");
    $ip = $_SERVER['REMOTE_ADDR'];
    $details = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
    if(property_exists($details, "loc")){
        $reqacc->bind_param("sss", $ident, $ip, "$details->city [$details->country]");   
    } else {
        $error = "Lieu introuvable ou IP locale au serveur";
        $reqacc->bind_param("sss", $ident, $ip, $error);
    }
    $reqacc->execute();

    //Lancement de la session et renvoi vers la page d'accueil
    $_SESSION["id"]=$ident;
    header('Location: login.php');
    exit();
?>