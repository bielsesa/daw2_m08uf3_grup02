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
	include "ldaphelper.php";

	// Dades de connexió
	$ldaphost = "ldap://localhost";
	$ldappass = trim($_POST['ctsnya']); 
	$ldapadmin = "cn=admin,dc=fjeclot,dc=net";
	
	// Creació de l'objecte de connexió a LDAP
	$ldap = new LdapHelper($ldaphost, $ldapadmin, $ldappass, "dc=fjeclot,dc=net");
	if ($ldap->ldapconn && $ldap->ldapbind) {
		session_start();
		$_SESSION["ldap"] = "true"; // $ldap;
		$_SESSION["uid"] = $ldapadmin;
		$_SESSION["pwd"] = $ldappass;
		$_SESSION["host"] = $ldaphost;
		$_SESSION["dc"] = "dc=fjeclot,dc=net";
		header("Location: http://localhost/menu.php");
	} else {
		echo <<<OUT
		<p>Error d'autenticació!<br>
		<a href="http://localhost/index.html"><button class="btn btn-dark">Tornar enrere</button></a></p>
		OUT;
	}
?>
</body>