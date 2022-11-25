<?php
session_start();
// echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
require_once "../../conSanatorio.php";
$menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden") //order by Orden 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CONSULTA</title>
    <?php  include_once "dependencias.php" ?>
    <link rel="stylesheet" href="css.css"> <link rel="icon" href="../../imagen/modelo.jpg">
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
                <!–– Principal -->
                <div class="card-body">
                <form method="post" action="reporteTurno.php">
                    <div class="row justify-content-center align-items-center minh-100">                   
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Fecha</h5>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Seleccione Quirofano</h5>
                                        <select  class="custom-select" name="menuQuirofano">
                                            <option value=""></option>
                                            <option value="00">TODOS</option>
                                            <?php 
                                                while($row=mysqli_fetch_array($menQuirofano)) {
                                            ?>
                                                <option value="<?php echo $row['Numero']?>"> <?php echo $row['Descripcion']?> </option>
                                            <?php }?>
                                        </select>
                                        <span id="selectMenuQuirofano"></span> <!-- VALOR DEL QUIROFANO -->
                                        <script>
                                            $('#menuQuirofano').on('change', function(){
                                                var valor = this.value;
                                                $('#selectMenuQuirofano').text(valor);                                                   
                                            })
                                        </script>
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
                <!–– Fin Principal -->
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>

</html>