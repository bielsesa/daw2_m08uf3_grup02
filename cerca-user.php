<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Menú d'accions LDAP</title>
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
    if (session_start()) {
        if (!isset($_SESSION["ldap"])) {
            echo <<<OUT
            <p>No has iniciat sessió com a administrador.<br/>
            Torna a la <a href="http://localhost/index.html">pàgina inicial</a> i fes login.</p>
            OUT;
        } else {
            // si s'ha guardat el nom d'usuari
            // cercar-lo, si no, mostrar form
            if (isset($_GET["usuari"])) {
                $ldap = new LdapHelper($_SESSION["host"], $_SESSION["uid"], $_SESSION["pwd"], $_SESSION["dc"]);

                if ($ldap->ldapconn && $ldap->ldapbind) {
                    $uid = $_GET["usuari"];
                    // Esborrem la info de l'usuari per quan es vulgui cercar un altre
                    unset($_GET["usuari"]);
                    $cerca = $ldap->CercaUsuari($uid);
                    echo $cerca;                    
                    echo <<<OUT
                    <a href="cerca-user.php"><button class="btn btn-dark">Buscar un altre usuari</button></a>
                    OUT;
                } else {
                    echo "<p>Error d'autenticació!</p>";
                }
            } else {
                echo <<<OUT
                <form action="http://localhost/cerca-user.php" method="GET">
                <label>UID de l'usuari: <input type="text" name="usuari"/></label>
                <input type="submit" value="Cerca"/>
                </form>
                OUT;
            }
                
            echo '<a href="http://localhost/menu.php"><button class="btn btn-dark">Tornar al menú</button></a>'; 
        }
    }
?>
</body>
</html>