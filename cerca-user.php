<?php
    if (session_start()) {
        if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
            echo "No has iniciat sessió com a administrador.";
            echo "Torna a la <a href=\"http://localhost/index.html\">pàgina inicial</a> i fes login.";
        } else {            
            // Dades de connexió
            $ldaphost = "ldap://localhost";
            $ldappass = $_SESSION["pwd"]; 
            $ldapadmin= $_SESSION["id"];

            // si s'ha guardat el nom d'usuari
            // cercar-lo, si no, mostrar form
            if (isset($_GET["usuari"])) {
                echo "<p>es mostra la info de l'usuari</p>";
            } else {
                echo "<form action=\"http://localhost/cerca-user.php\" method=\"GET\">";
                echo "<label>Nom de l'usuari: <input type=\"text\" name=\"usuari\"/></label>";
                echo "<input type=\"submit\" value=\"Cerca\"/>";
                echo "</form>";
            }
        }
    }
?>
