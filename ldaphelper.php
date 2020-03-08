<?php
    class LdapHelper {
        private $ldapconn;
        private $ldapbind;
        private $ldaphost;
        private $ldapadmin;
        private $ldappass;
        private $ldapdcbase;

        // Constructor (obre la connexió)
        public function __construct($host, $usradmin, $pass, $dcbase) {
            $this->ldaphost = $host;
            $this->ldapadmin = $usradmin;
            $this->ldappass = $pass;
            $this->ldapdcbase = $dcbase;
            $this->ldapconn = ldap_connect("localhost") or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");
            ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            // Bind amb les credencials
            $this->ldapbind = ldap_bind($this->ldapconn, $this->ldapadmin, $this->ldappass);
        }

        // Destructor (tanca la connexió)
        public function __destruct() {
            ldap_close($this->ldapconn);
            unset($this->ldapbind);
            unset($this->ldapadmin);
            unset($this->ldappass);
            unset($this->ldaphost);
            unset($this->ldapdcbase);
        }

        // Funció get
        public function __get($prop){
			if(property_exists($this,$prop)){
				return $this->$prop;
			}
			else{
				return -1;
			}		
        }
        
        // Crea un usuari nou
        public function CreaUsuari($dn, $info) {
            $retval = "";
            // Creació de l'usuari LDAP
            $ldapadd = ldap_add_ext($this->ldapconn, $dn, $info);
            // Extract information from result
            $ldapparse = ldap_parse_result($this->ldapconn, $ldapadd, $errcode, $matcheddn, $errmsg, $ref);

            if ($errcode == 0) {
                $retval = "S'ha afegit correctament l'usuari.<br>";
            } else {
                $retval = <<<OUT
                Hi ha hagut un error a l'hora d'afegir aquest usuari. Codi d'error: $errcode.<br/>
                Contacta amb l'administrador.<br>
                OUT;
            }

            return $retval;
        }

        // Elimina un usuari existent
        public function EliminaUsuari($dn) {
            $retval = "";
            // Eliminació de l'usuari LDAP
            $ldapdel = ldap_delete_ext($this->ldapconn, $dn);
            $ldapparse = ldap_parse_result($this->ldapconn, $ldapdel, $errcode, $matcheddn, $errmsg, $ref);

            if ($errcode == 0) {
                $retval = "S'ha eliminat correctament l'usuari.<br/>";
            } elseif ($errcode == 32) {
                $retval = "Aquest usuari no existeix.<br/>";            
            } else {
                $retval = <<<OUT
                Hi ha hagut un error a l'hora d'eliminar aquest usuari. Codi d'error: $errcode.<br/>
                Contacta amb l'administrador.<br>
                OUT;
            }

            return $retval;
        }

        // Modifica les dades d'un usuari
        public function ModificaUsuari($dn, $dades) {
            $retval = "";
            $ldapmod = ldap_mod_replace_ext($this->ldapconn, $dn, $dades);

            $ldapparse = ldap_parse_result($this->ldapconn, $ldapmod, $errcode, $matcheddn, $errmsg, $ref);

            if ($errcode == 0) {
                $retval = "S'han modificat correctament les dades.<br>";
            } elseif ($errcode == 32) {
                $retval = "Aquest usuari no existeix.<br/>";            
            } else {
                $retval = <<<OUT
                Hi ha hagut un error a l'hora de modificar aquest usuari. Codi d'error: $errcode.<br/>
                Contacta amb l'administrador.<br>
                OUT;
            }

            return $retval;
        }

        // Cerca la informació d'un usuari
        public function CercaUsuari($uid) {
            $retval = "";
            
            $search = ldap_search($this->ldapconn, $this->ldapdcbase, "uid=".$uid);
            if ($search == FALSE) {
                $retval = "<p>No s'ha trobat aquest usuari!</p><br>";
            } else {
                $info = ldap_get_entries($this->ldapconn, $search);
                
                for ($i=0; $i<$info["count"]; $i++)
                {
                    $retval .= "<table class=<\"table table-dark\"><tbody>";
                    $retval .= "<tr><th scope=\"row\">Nom i cognoms</th><td>".$info[$i]["cn"][0]. "</td></tr>";
                    $retval .= "<tr><th scope=\"row\">Títol</th><td>".$info[$i]["title"][0]. "</td></tr>";
                    $retval .= "<tr><th scope=\"row\">Telèfon mòbil</th><td>".$info[$i]["mobile"][0]. "</td></tr>";
                    $retval .= "<tr><th scope=\"row\">Telèfon fixe</th><td>".$info[$i]["telephonenumber"][0]. "</td></tr>";
                    $retval .= "<tr><th scope=\"row\">Adreça postal</th><td>".$info[$i]["postaladdress"][0]. "</td></tr>";
                    if (isset($info[$i]["description"])) {
                        $retval .= "<tr><th scope=\"row\">Descripció</th><td>".$info[$i]["description"][0]. "</td></tr>";                                
                    }
                    $retval .= "<tr><th scope=\"row\">Directori principal</th><td>".$info[$i]["homedirectory"][0]. "</td></tr>";                                
                    $retval .= "<tr><th scope=\"row\">Shell</th><td>".$info[$i]["loginshell"][0]. "</td></tr>";                                
                    $retval .= "<tr><th scope=\"row\">GID</th><td>".$info[$i]["gidnumber"][0]. "</td></tr>";                                
                    $retval .= "<tr><th scope=\"row\">UID</th><td>".$info[$i]["uid"][0]." (".$info[$i]["uidnumber"][0].")</td></tr>";                                
                    $retval .= "<tr><th scope=\"row\">Unitat Organitzativa</th><td>".$info[$i]["dn"]."</td></tr>";  
                    $retval .= "</tbody></table>";                              
                } 
            }
            
            return $retval;
        }               
    }
?>