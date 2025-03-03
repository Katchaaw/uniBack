<?php

    require('session_start_login.php');

    $bdd = new PDO('mysql:host=localhost;dbname=bddres;charset=utf8;', 'testadmin', '123');

    if(isset($_POST['envoyer'])){
        $content = htmlspecialchars($_POST['postcontent']);
        $idPostQr = $bdd->prepare('SELECT MAX(Id) FROM posts');
        $idPostQr->execute();
        $idPost = ($idPostQr->fetch())[0] + 1;
        if(isset($_POST['backroom'])){
            $bcr = 1;
        } else {
            $bcr = 0;
        }

        //Publication d'une image
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
            $extensions= array("jpeg","jpg","png","gif");
            //verification si image envoyée
            if(empty($_FILES['image']['name']) && $file_size==0){
                if (!empty($content)){
                    $insererMessage = $bdd -> prepare('INSERT INTO posts(Id, IdUser, ContenuTxt, Backroom)VALUES(?, ?, ?, ?)');
                    $insererMessage-> execute(array($idPost, $_SESSION["id"], $content, $bcr));
                    header('Location: accueil.php');
                    exit();
                } else {
                    header('Location: post.php');
                    exit();
                }
                
            }
            //verification si extension est autorisée
            if(!in_array($file_ext,$extensions)){
                $errors = "ext";
            }
            //verification taille du fichier
            if($file_size > 10485760){
                if(empty($errors)){$errors = "size";}else{$errors .= "&size";}
            }
            //Si tableau des erreurs vide = pas d'erreur c'est bon
            if(empty($errors)){

                //Attribue un nom de fichier aléatoire dans la BDD
                $randChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randCharsLen = strlen($randChars);
                $randStr = '';
                for ($randI = 0; $randI < 25; $randI++) {
                    $randStr .= $randChars[random_int(0, $randCharsLen - 1)];
                }

                $tmp=$randStr.'.'.$file_ext;
                move_uploaded_file($file_tmp,"image/postmedia/".$tmp);
                
                $insererMessage = $bdd -> prepare('INSERT INTO posts(Id, IdUser, ContenuTxt, ContenuMedia, Backroom)VALUES(?, ?, ?, ?, ?)');
                $insererMessage-> execute(array($idPost, $_SESSION["id"], $content, $tmp, $bcr));
                header('Location: accueil.php');
                exit();
                
            }else{
                echo "<form action=\"post.php?$errors\" id=\"returnform\" method=\"post\"><input type=\"hidden\" name=\"content\" value=\"$content\"></form>
                <script type=\"text/javascript\">document.getElementById(\"returnform\").submit();</script>";
                exit();
            }
        } else {
            $insererMessage = $bdd -> prepare('INSERT INTO posts(Id, IdUser, ContenuTxt, Backroom)VALUES(?, ?, ?, ?)');
            $insererMessage-> execute(array($idPost, $_SESSION["id"], $content, $bcr));
            header('Location: accueil.php');
            exit();
        }   
    }
    

?>