<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Modificar usuari LDAP</title>
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
        if (!isset($_SESSION["ldap"])) {
            echo "No has iniciat sessió com a administrador.<br/>";
            echo "Torna a la <a href=\"http://localhost/index.html\">pàgina inicial</a> i fes login.";
        } else {
            echo <<<BODY
            <form action="modificacio-user.php" METHOD="GET">
                <label>Identificador de l'usuari: <input type="text" name="uid"></label><br/>
                <label>Unitat organitzativa: <input type="text" name="ou"></label><br/>                
                <p>A continuació pots escollir què modificar. Si no vols modificar alguna<br/>
                de les següents dades, deixa-la en blanc.</p>                
                <label>Nou número UID: <input type="text" name="uidnum"></label><br/>                
                <label>Nou número GID: <input type="text" name="gidnum"></label><br/>                
                <input type="submit" class="btn btn-dark" value="Modifica usuari"/>
            </form>
            <a href="http://localhost/menu.php"><button class="btn btn-dark">Tornar al menú</button></a>
            BODY;
        }
    }
?>
</body>