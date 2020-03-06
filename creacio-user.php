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
            echo "Connexió";

            if ($ldapconn) {                
                $ldapbind = ldap_bind($ldapconn, $ldapadmin, $ldappass);
                echo "Bind";
                
                // Preparació de les dades
                $info["uid"] = $_POST["uid"];
                $info["ou"] = $_POST["ou"];
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
                $info["objectClass"] = "top";
                $info["objectClass"] = "person";
                $info["objectClass"] = "organizationalPerson";
                $info["objectClass"] = "inetOrgPerson";
                $info["objectClass"] = "posixAccount";
                $info["objectClass"] = "shadowAccount";

                $dn = "uid=".$info[uid].",ou=".$info["ou"].",dc=fjeclot,dc=net";

                echo "[DEBUG]<br>User info:<br>";
                var_dump($info);
                echo "<br>User dn: $dn<br><br>";

                // Creació de l'usuari LDAP
                $ldapadd = ldap_add_ext($ldapconn, $dn, $info);
                $ldapparse = ldap_parse_result($ldapconn, $ldapadd, $errcode, $matcheddn, $errmsg, $ref);

                echo "Resultat ldapadd<br>";
                echo <<<RES
                ErrCode: $errcode<br>
                Matched dn: $matcheddn<br>
                ErrMsg: $errmsg<br>
                Referral: $ref<br><br>
                RES;

                if ($ldapadd) {
                    echo <<<OUT
                    S'ha afegit correctament l'usuari.<br>
                    <a href="http://localhost/crea-user.php">Tornar enrere.</a>
                    OUT;
                } else {
                    echo <<<OUT
                    Hi ha hagut un error a l'hora d'afegir aquest usuari.<br/>
                    Contacta amb l'administrador.<br>
                    <a href="http://localhost/crea-user.php">Tornar enrere.</a>
                    OUT;
                }

                ldap_close($ldapconn);
            } else {
                echo <<<OUT
                Error durant la connexió al servidor LDAP.<br/>
                <a href="http://localhost/crea-user.php">Tornar enrere.</a>
                OUT;
            }
        }
    }
?>
</body>