<?php
    if (session_start()) {
        if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
            echo "No has iniciat sessió com a administrador.<br/>";
            echo "Torna a la <a href=\"http://localhost/index.html\">pàgina inicial</a> i fes login.";
        } else {
            echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
            <html>
              <head>
                <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
                <title>Crear un usuari LDAP</title>
              </head>
              <body style=\"text-align: center\">
                <form action=\"creacio-user.php\" METHOD=\"POST\">
                   <label>Nom de l'usuari: <input type=\"text\" name=\"nom\"></label><br/>
                   <label>Cognom de l'usuari:  <input type=\"text\" name=\"cognom\"></label><br/>
                   <label>Càrrec o títol de l'usuari: <input type=\"text\" name=\"titol\"></label><br/>
                   <label>Telèfon fixe de l'usuari: <input type=\"text\" name=\"telFix\"></label><br/>
                   <label>Telèfon mòbil de l'usuari: <input type=\"text\" name=\"telMob\"></label><br/>
                   <label>Adreça de l'usuari: <input type=\"text\" name=\"adrPostal\"></label><br/>
                   <label>Descripció de l'usuari: <input type=\"text\" name=\"desc\"></label><br/>
                   <label>Identificador (login) de l'usuari: <input type=\"text\" name=\"uid\"></label><br/>
                   <label>Unitat organitzativa de l'usuari: <input type=\"text\" name=\"ou\"></label><br/>
                   <label>Número identificador de l'usuari: <input type=\"text\" name=\"uidNumber\"></label><br/>
                   <label>Número de grup per defecte de l'usuari: <input type=\"text\" name=\"gidNumber\"></label><br/>
                   <label>Directori personal de l'usuari: <input type=\"text\" name=\"homeDirectory\"></label><br/>
                   <label>Shell per defecte de l'usuari: <input type=\"text\" name=\"loginShell\"></label><br/>
                   <label>Contrasenya de l'usuari: <input type=\"text\" name=\"pwd\"></label><br/>
                   <input type=\"submit\" value=\"Crear usuari\"/>
                </form>
                <a href=\"http://localhost/menu.php\">Tornar al menú</a>
              </body>
            </html>";
        }
    }
?>
