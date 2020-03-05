<?php
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Prova d'acc&eacute;s al servei de directori LDAP amb PHP</title>
  </head>
  <body style="text-align: center">
  <?php
    if (session_start()) {
      if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
          echo "No has iniciat sessió com a administrador.<br/>";
          echo "Torna a la <a href=\"http://localhost/index.html\">pàgina inicial</a> i fes login.";
      } else {
          echo "<form action=\"crea-user.php\" METHOD=\"GET\">
                  <input type=\"submit\" value=\"Crear usuari\">
              </form>
              <form action=\"elimina-user.php\" METHOD=\"GET\">
                  <input type=\"submit\" value=\"Eliminar usuari\">
              </form>
              <form action=\"cerca-user.php\" METHOD=\"GET\">
                  <input type=\"submit\" value=\"Cercar usuari\">
              </form>";
      }
    }
  ?>    
  </body>
</html>