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
            echo <<<BODY
            <form action="creacio-user.php" METHOD="POST">
                <label>Nom de l'usuari: <input type="text" name="nom"></label><br/>
                <label>Cognom de l'usuari:  <input type="text" name="cognom"></label><br/>
                <label>Càrrec o títol de l'usuari: <input type="text" name="titol"></label><br/>
                <label>Telèfon fixe de l'usuari: <input type="text" name="telFix"></label><br/>
                <label>Telèfon mòbil de l'usuari: <input type="text" name="telMob"></label><br/>
                <label>Adreça de l'usuari: <input type="text" name="adrPostal"></label><br/>
                <label>Descripció de l'usuari: <input type="text" name="desc"></label><br/>
                <label>Identificador (login) de l'usuari: <input type="text" name="uid"></label><br/>
                <label>Unitat organitzativa de l'usuari: <input type="text" name="ou"></label><br/>
                <label>Número identificador de l'usuari: <input type="text" name="uidNumber"></label><br/>
                <label>Número de grup per defecte de l'usuari: <input type="text" name="gidNumber"></label><br/>
                <label>Directori personal de l'usuari: <input type="text" name="homeDirectory"></label><br/>
                <label>Shell per defecte de l'usuari: <input type="text" name="loginShell"></label><br/>
                
                <input type="submit" value="Crear usuari"/>
            </form>
            <a href="http://localhost/menu.php">Tornar al menú</a>
            BODY;
            // <label>Contrasenya de l'usuari: <input type="text" name="pwd"></label><br/>
        }
    }
?>
</body>