<?php
    if (session_start()) {
        if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
            echo "No has iniciat sessió com a administrador.<br/>";
            echo "Torna a la <a href=\"http://localhost/index.html\">pàgina inicial</a> i fes login.";
        } else {
            $ldaphost = "ldap://localhost";
            $ldappass = $_SESSION["pwd"];
            $ldapadmin = $_SESSION["id"];

            // Connexió LDAP
            $ldapconn = ldap_connect("localhost") or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");

            if ($ldapconn) {
                $ldapbind = ldap_bind($ldapconn, $ldapadmin, $ldappass);
                
                // Preparació de les dades
                $info["uid"] = $_POST["uid"];
                $info["ou"] = $_POST["ou"];
                $info["nom"] = $_POST["nom"];
                $info["cognom"] = $_POST["cognom"];
                $info["titol"] = $_POST["titol"];
                $info["telFix"] = $_POST["telFix"];
                $info["telMob"] = $_POST["telMob"];
                $info["adrPostal"] = $_POST["adrPostal"];
                $info["loginShell"] = $_POST["loginShell"];
                $info["gidNumber"] = $_POST["gidNumber"];
                $info["uidNumber"] = $_POST["uidNumber"];
                $info["homeDirectory"] = $_POST["homeDirectory"];
                $info["desc"] = $_POST["desc"];
                $info["pwd"] = $_POST["pwd"];

                $usuari = "uid=".$info["uid"].",cn=".$info["nom"]." ".$info["cognom"].",ou=".$info["ou"].",dc=fjeclot,dc=net";

                // Creació de l'usuari LDAP
                $res = ldap_add($ldapconn, $usuari, $info);
            }
        }
    }
?>
