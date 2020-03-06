<?php
    if (session_start()) {
        if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
            echo "No has iniciat sessió com a administrador.";
            echo "Torna a la <a href=\"http://localhost/index.html\">pàgina inicial</a> i fes login.";
        } else {
            // si s'ha guardat el nom d'usuari
            // cercar-lo, si no, mostrar form
            if (isset($_GET["uid"])) {
                // Dades de connexió
                $ldaphost = "ldap://localhost";
                $ldappass = $_SESSION["pwd"]; 
                $ldapadmin= $_SESSION["id"];
                $uid = $_GET["uid"];
                // Esborrem la info de l'usuari per quan es vulgui cercar un altre
                unset($_GET["uid"]);

                // Connexió
                $ldapconn = ldap_connect($ldaphost) or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");
                
                //Versió del servidor i protocol
                ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                
                //Autenticació
                if ($ldapconn) {
                    $ldapbind = ldap_bind($ldapconn, $ldapadmin, $ldappass);

                    // Accedint a les dades de la BD LDAP
                    if ($ldapbind) {
                        $search = ldap_search($ldapconn, "dc=fjeclot,dc=net", "uid=".$uid);
                        if ($search == FALSE) {
                            echo "<p>No s'ha trobat aquest usuari!</p><br>";
                        } else {
                            $info = ldap_get_entries($ldapconn, $search);
                            //Ara, visualitzarem algunes de les dades de l'usuari:
                            for ($i=0; $i<$info["count"]; $i++)
                            {
                                echo "Nom i cognoms: ".$info[$i]["cn"][0]. "<br />";
                                echo "Títol: ".$info[$i]["title"][0]. "<br />";
                                echo "Telèfon mòbil: ".$info[$i]["mobile"][0]. "<br />";
                                echo "Telèfon fixe: ".$info[$i]["telephonenumber"][0]. "<br />";
                                echo "Adreça postal: ".$info[$i]["postaladdress"][0]. "<br />";
                                echo "Descripció: ".$info[$i]["description"][0]. "<br />";                                
                                echo "Directori principal: ".$info[$i]["homeDirectory"][0]. "<br />";                                
                                echo "Shell: ".$info[$i]["loginShell"][0]. "<br />";                                
                                echo "GID: ".$info[$i]["gidNumber"][0]. "<br />";                                
                                echo "UID: ".$info[$i]["uid"][0]." (".$info[$i]["uidNumber"][0].")<br />";                                
                                echo "Unitat Organitzativa: ".$info[$i]["dn"]."<br />";                                
                            } 
                        }
                        echo "<form action=\"http://localhost/cerca-user.php\" method=\"GET\">";
                        echo "<input type=\"submit\" value=\"Buscar un altre\"/>";
                        echo "</form>";
                    } 
                    else {
                        echo "Error d'autenticació!";
                    }
                }
                //
                // Tancant connexió
                ldap_close($ldaphost);
            } else {
                echo "<form action=\"http://localhost/cerca-user.php\" method=\"GET\">";
                echo "<label>UID de l'usuari: <input type=\"text\" name=\"uid\"/></label>";
                echo "<input type=\"submit\" value=\"Cerca\"/>";
                echo "</form>";
            }
                
            echo '<a href="http://localhost/menu.php">Tornar al menú</a>'; 
        }
    }
?>
