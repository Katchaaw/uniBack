<?php

    require('session_start_login.php');
    require('mysqli_connex.php');

    $ident = mb_strtolower($_SESSION["id"], 'UTF-8');
    $reqid = "SELECT * FROM comptes WHERE Identifiant=?";
    $stmt = mysqli_prepare($connex, $reqid);
    mysqli_stmt_bind_param($stmt, 's', $ident);
    mysqli_stmt_execute($stmt);
    $querid = mysqli_stmt_get_result($stmt);
    $val_id = mysqli_fetch_assoc($querid);
    
    //Recupération de toutes les infos de l'image.
    if(isset($_FILES['image'])){
        //tableau contenant les erreurs s'il y en a
        $errors="";
        $file_name = $_FILES['image']['name'];
        $file_size =$_FILES['image']['size'];
        $file_tmp =$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $temp = explode('.',$_FILES['image']['name']);
        $file_ext=strtolower(end($temp));
        //creation d'un tableau contenant toutes les extensions acceptées
        $extensions= array("jpeg","jpg","png");
        //verification si extension est autorisée 
        if(!in_array($file_ext,$extensions)){
            $errors = "ext";
        }
        //verification taille du fichier
        if($file_size > 2097152){
            if(empty($errors)){$errors = "size";}else{$errors .= "&size";}
        }
        //Si tableau des erreurs vide = pas d'erreur c'est bon
        if(empty($errors)){
            $identif = $val_id["Identifiant"];

            //Attribue un nom de fichier aléatoire dans la BDD
            $randChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randCharsLen = strlen($randChars);
            $randStr = '';
            for ($randI = 0; $randI < 25; $randI++) {
                $randStr .= $randChars[random_int(0, $randCharsLen - 1)];
            }

            $tmp=$randStr.'.'.$file_ext;
            move_uploaded_file($file_tmp,"image/profile_pic/".$tmp);
            $sql = "UPDATE comptes SET ProfilePic='$tmp' WHERE Identifiant = '$identif'";
            mysqli_query($connex, $sql);
            header('Location: profile.php');
            exit();
        }else{
            header('Location: changePdp.php?'.$errors);
            exit();
        }
    }

?>