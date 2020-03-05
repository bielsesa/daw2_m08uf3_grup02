<?php
	// Dades de connexió
	$ldaphost = "ldap://localhost";
	$ldappass = trim($_POST['ctsnya']); 
	$ldapadmin= "cn=admin,dc=fjeclot,dc=net";
	//
	// Connectant-se al servidor openLDAP
	$ldapconn = ldap_connect($ldaphost) or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");
	//
	//Versió del servidor i protocol
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	//
	//Autenticació
	if ($ldapconn) {
		// Autenticant-se en el servidor openLDAP
		$ldapbind = ldap_bind($ldapconn, $ldapadmin, $ldappass);

		// Accedint a les dades de la BD LDAP
		if ($ldapbind) {
            session_start();
            echo "<p>Autenticació correcta. Redirecció en 5 segons...</p>";
            sleep(5);
            header("Location: http://localhost/menu.php");
            $_SESSION["admin"] = "true";
            $_SESSION["id"] = $ldapadmin;
            $_SESSION["pwd"] = $ldappass;
        } 
		else {
            echo "<p>Error d'autenticació!<br>";
            echo "<a href=\"http://localhost/index.html\">Tornar enrere</a></p>";
		}
	}
	//
	// Tancant connexió
	ldap_close($ldaphost);
?>

