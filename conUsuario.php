<?php 
	
	/* $host = 'localhost';
	$user = 'root';
	$password = '';
	$db = 'zetap_sanatorio'; */

	$host = '192.168.1.4';
	$user = 'sanatorio';
	$password = '123';
	$db = 'zetap_sanatorio';

	$conUsuario = @mysqli_connect($host,$user,$password,$db);

	if(!$conUsuario){
		echo "Error en la conexión Usuario";
	}

?>