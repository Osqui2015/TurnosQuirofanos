<?php
session_start();
//echo $_SESSION['tipo'];


function listadoDirectorio($directorio){
    $listado = scandir($directorio);
    unset($listado[array_search('.', $listado, true)]);
    unset($listado[array_search('..', $listado, true)]);
    if (count($listado) < 1) {
        return;
    }
    foreach($listado as $elemento){
        if(!is_dir($directorio.'/'.$elemento)) {
            echo "<li>- <a target='_blank' href='$directorio/$elemento'>$elemento</a></li>";
        }
        if(is_dir($directorio.'/'.$elemento)) {
            echo '<li class="open-dropdown">+ '.$elemento.'</li>';
            echo '<ul class="dropdown d-none">';
                listadoDirectorio($directorio.'/'.$elemento);
            echo '</ul>';
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>medico</title>
   
    <?php  include_once "dependencias.php" ?>

<!---- ---->
	<style>
		ul {
			list-style-type: none;
		}
		.d-none {
			display: none;
		}
		.open-dropdown {
			font-weight: bold;
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
	<script>
		$(document).ready(function(){
		  $(".open-dropdown").click(function(){
		    $(this).next( "ul.dropdown" ).toggleClass('d-none');
		  });
		});
	</script>


<!---- ---->
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body>


    <!–– Principal -->

      
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <div class="jumbotron">
                <!–– Principal -->
                <div class="card-body">
                    
                    <ul>
                        <?php listadoDirectorio('consentimientos'); ?>
                    </ul>

                    
                </div>
                <!–– Fin Principal -->
            </div>
    
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
  


   


</body>
</html>