<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Eliminació de l'usuari LDAP</title>
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
            $uid = $_GET["uid"];
            $ldaphost = "ldap://localhost";
            $ldappass = $_SESSION["pwd"];
            $ldapadmin = $_SESSION["id"];

            // Connexió LDAP
            $ldapconn = ldap_connect("localhost") or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            if ($ldapconn) {
                $ldapbind = ldap_bind($ldapconn, $ldapadmin, $ldappass);

                $dn = "uid=".$_GET["uid"].",ou=".$_GET["ou"].",dc=fjeclot,dc=net";

                echo "dn: ".$dn."<br>";

                // Eliminació de l'usuari LDAP
                $ldapdel = ldap_delete_ext($ldapconn, $dn);
                $ldapparse = ldap_parse_result($ldapconn, $ldapdel, $errcode, $matcheddn, $errmsg, $ref);

                if ($errcode == 0) {
                    echo "S'ha eliminat correctament l'usuari.<br>";
                } else {
                    echo <<<OUT
                    Hi ha hagut un error a l'hora d'eliminar aquest usuari. Codi d'error: $errcode.<br/>
                    Contacta amb l'administrador.<br>
                    OUT;
                }

                ldap_close($ldapconn);
            } else {
                echo "Error durant la connexió al servidor LDAP.<br/>";
            }
            
            echo '<a href="http://localhost/elimina-user.php">Tornar enrere.</a>';
        }
    }
?>
</body>