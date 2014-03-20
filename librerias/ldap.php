<?php
// variables de autenticacion y LDAP
			$ldap['user']              = $user;
			$ldap['pass']              = $pass;
			$ldap['host']              = 'ldap.ues.edu.sv'; // nombre del host o servidor
			$ldap['port']              = 389; // puerto del LDAP en el servidor
			$ldap['dn']                = 'uid='.$ldap['user'].',ou=estudiantes,ou=usuarios,dc=ues,dc=edu,dc=sv'; // modificar respecto a los valores del LDAP
			$ldap['base']              = ' ';
	
			// conexion al servidor ldap
			$ldap['conn'] = ldap_connect( $ldap['host'], $ldap['port'] )or die("Imposible Conectarse al servidor LDAP");
			ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3);

			// match de usuario y password
			$conex_ldap =	ldap_bind( $ldap['conn'], $ldap['dn'], $ldap['pass'] ); 
			//variable guarda un valor entero si se realizo el match, null en otro caso
			
			//Close the link apointed by the identified (get with ldap_connect)
			ldap_close($ldap['conn']); 
	
?>