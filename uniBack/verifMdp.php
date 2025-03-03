<?php
    //Vérifie que le mot de passe contient bien au minimum:
    //8 caractères, 1 majuscule, 1 minsucule, 1 caractère spécial et 1 chiffre
    echo"<input type=\"hidden\" name=\"ident\" value=\"$ident\">
        <input type=\"hidden\" name=\"nom\" value=\"$nom\">
        <input type=\"hidden\" name=\"ddn\" value=\"$ddn\">
        <input type=\"hidden\" name=\"univ\" value=\"$univ\">
        <input type=\"submit\" value=\"S'abonner\"> 
        </form>
        <script type=\"text/javascript\">
        document.getElementById(\"returnform\").submit();
        </script>";
        exit();
?>