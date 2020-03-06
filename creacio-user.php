<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Creació de l'usuari LDAP</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" 
integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" 
integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
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
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            if ($ldapconn) {                
                echo "Bind";
                
                // Preparació de les dades
                $info["objectClass"][0] = "top";
                $info["objectClass"][1] = "person";
                $info["objectClass"][2] = "organizationalPerson";
                $info["objectClass"][3] = "inetOrgPerson";
                $info["objectClass"][4] = "posixAccount";
                $info["objectClass"][5] = "shadowAccount";
                $info["uid"] = $_POST["uid"];
                $info["cn"] = $_POST["nom"]." ".$_POST["cognom"];
                $info["givenName"] = $_POST["nom"];
                $info["sn"] = $_POST["cognom"];
                $info["title"] = $_POST["titol"];
                $info["telephoneNumber"] = $_POST["telFix"];
                $info["mobile"] = $_POST["telMob"];
                $info["postalAddress"] = $_POST["adrPostal"];
                $info["loginShell"] = $_POST["loginShell"];
                $info["gidNumber"] = $_POST["gidNumber"];
                $info["uidNumber"] = $_POST["uidNumber"];
                $info["homeDirectory"] = $_POST["homeDirectory"];
                $info["description"] = $_POST["desc"];
                // $info["userPassword"] = $_POST["pwd"]; potser necessita cript i encoding

                $dn = "uid=".$_POST["uid"].",ou=".$_POST["ou"].",dc=fjeclot,dc=net";

                // Creació de l'usuari LDAP
                $ldapadd = ldap_add_ext($ldapconn, $dn, $info);
                // Extract information from result
                $ldapparse = ldap_parse_result($ldapconn, $ldapadd, $errcode, $matcheddn, $errmsg, $ref);

                if ($errcode == 0) {
                    echo "S'ha afegit correctament l'usuari.<br>";
                } else {
                    echo <<<OUT
                    Hi ha hagut un error a l'hora d'afegir aquest usuari. Codi d'error: $errcode.<br/>
                    Contacta amb l'administrador.<br>
                    OUT;
                }

                ldap_close($ldapconn);
            } else {
                echo "Error durant la connexió al servidor LDAP.<br/>";
            }
                echo '<a href="http://localhost/crea-user.php">Tornar enrere.</a>';
        }
    }
?>
</body>