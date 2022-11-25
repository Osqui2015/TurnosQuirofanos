<?php 
	
	$host = '192.168.1.4';
	$user = 'sanatorio';
	$password = '123';
	$db = 'modelo';



	$conSanatorio = @mysqli_connect($host,$user,$password,$db);

	if(!$conSanatorio){
		echo "Error en la conexión Modelo";
	}else{
        echo "conexión ok";
    }

?>