<?php
$v = 0;
session_start();

// echo $_SESSION['tipo'];

require_once "../../conSanatorio.php";

$menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden")

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Sistema Administrador </title>
    <?php  include_once "dependencias.php" ?>
<link rel="icon" href="../../imagen/modelo.jpg">

</head>
<body>
            <!–– menu -->
             <?php  include_once "menuAdmin.php" ?>
            <!–– fin menu -->
            
              
            
        <div class="jumbotron ">        
            <div class =" text-center">
                <h1><p> Reporte de Turnos </p> </h1>
            </div>
            <form method="post" action="reporteTurnoD.php">
            <div class="row justify-content-center align-items-center minh-100">                   
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Fecha</h5>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class =" text-center">
                <input type="submit">
            </div>
            </form>
        </div>


        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>

</html>