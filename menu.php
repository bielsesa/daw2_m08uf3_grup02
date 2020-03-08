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
          Torna a la <a href="index.html">pàgina inicial</a> i fes login.</p>
          OUT;
        } else {
          // var_dump($_SESSION["ldap"]);
          $ldap = new LdapHelper($_SESSION["host"], $_SESSION["uid"], $_SESSION["pwd"], $_SESSION["dc"]);

          if ($ldap->ldapconn && $ldap->ldapbind) {
            echo <<<OUT
            <a href="crea-user.php"><button class="btn btn-dark">Crear usuari</button></a>
            <a href="elimina-user.php"><button class="btn btn-dark">Eliminar usuari</button></a>
            <a href="modifica-user.php"><button class="btn btn-dark">Modifica usuari</button></a>
            <a href="cerca-user.php"><button class="btn btn-dark">Cercar usuari</button></a>
            OUT;
          }
        }
    }
  ?>    
  </body>
</html>