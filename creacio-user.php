<?php
    if (session_start()) {
        if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
            echo "No has iniciat sessió com a administrador.<br/>";
            echo "Torna a la <a href=\"http://localhost/index.html\">pàgina inicial</a> i fes login.";
        } else {
            $uid = $_POST["uid"];
            $ou = $_POST["ou"];
            $nom = $_POST["nom"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];
            $uid = $_POST["uid"];

            // Creació de l'usuari LDAP
            $createStatement = <<<STM
            dn: uid=$uid,ou=$ou,dc=fjeclot,dc=net
            objectClass: top
            objectClass: person
            objectClass: organizationalPerson
            objectClass: inetOrgPerson
            objectClass: posixAccount
            objectClass: shadowAccount
            uid: $uid
            cn: $nom $cognom
            sn: sodalloc
            givenName: leinad
            title: administrador de sistemes
            telephoneNumber: 93 456 34 23
            mobile: 657 89 89 89
            postalAddress: Carrer Valencia 27. Barcelona.
            loginShell: /bin/bash
            gidNumber: 2000
            uidNumber: 1000
            homeDirectory: /users/sysadmin/
            description: Administrador de sistemes.
            STM;

        }
    }
?>
