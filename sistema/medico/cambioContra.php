<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
$userr = $_SESSION['usuario']; /*VALOR USUARIO*/
require_once "../../conUsuario.php";


    $datosUser = mysqli_query($conUsuario, "SELECT * FROM usuarios WHERE matricula = $matricula"); //
    
    while($row=mysqli_fetch_array($datosUser)) {
        $nombre = $row['nombre'];        
        $matricula = $row['matricula'];
        $usuario = $row['usuario'];
        $mail = $row['mail'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perfil - Cambio Contraseña</title>
    <?php  include_once "dependencias.php" ?>
    <link rel="stylesheet" href="css.css"> <link rel="icon" href="../../imagen/modelo.jpg">    
</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
                <!–– Principal -->
                <div class="card">
                    <h5 class="card-header">Cambio de Contraseña</h5>
                    <div class="card-body">
                        <h4 class="card-title">Datos</h4>
                        <br>
                        <ul class="list-group list-group-horizontal-lg">
                            <li class="list-group-item border-0"><span>Matricula: ㅤㅤㅤㅤ ㅤ ㅤㅤ</span></li>
                            <li class="list-group-item border-0"><input class="form-control" id="matricula" readonly value="<?php echo $matricula ?>"></li>                            
                        </ul>
                        <ul class="list-group list-group-horizontal-lg">
                            <li class="list-group-item border-0"><span>Nombre:ㅤㅤ ㅤㅤㅤㅤㅤㅤ</span></li>
                            <li class="list-group-item border-0"><input class="form-control" readonly value="<?php echo $nombre ?>"></li>
                        </ul>
                        <ul class="list-group list-group-horizontal-lg">
                            <li class="list-group-item border-0"><span>Email:ㅤ ㅤㅤ ㅤㅤㅤㅤㅤㅤ</span></li>
                            <li class="list-group-item border-0"><input class="form-control"  readonly value="<?php echo $mail ?>"></li> 
                        </ul>
                        <ul class="list-group list-group-horizontal-lg">
                            <li class="list-group-item border-0"><span>Contraseña Actual:ㅤㅤㅤㅤ</span></li>
                            <li class="list-group-item border-0"><input class="form-control" type="password"  id="actual" onblur="validarContra ()"></li>
                            <li class="list-group-item border-0">
                                <button type="button" class="btn btn-success" id="actSi" style="display: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"></path>
                                        </svg>
                                </button>
                                <button type="button" class="btn btn-danger" id="actNo" style="display: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"></path>
                                        </svg>
                                </button>
                            </li>
                        </ul>
                        <ul class="list-group list-group-horizontal-lg">
                            <li class="list-group-item border-0"><span>Contraseña Nueva:ㅤㅤㅤㅤ</span></li>
                            <li class="list-group-item border-0"><input class="form-control" type="password" id="con1" disabled></li>  
                        </ul>
                        <ul class="list-group list-group-horizontal-lg">
                            <li class="list-group-item border-0"><span>Repita Contraseña Nueva:ㅤ</span></li>
                            <li class="list-group-item border-0"><input class="form-control" type="password" id="con2" onblur="validarIgual()" disabled></li>
                            <li class="list-group-item border-0">
                                <button type="button" class="btn btn-success" id="contrSi" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"></path>
                                    </svg>
                                </button>
                                <button type="button" class="btn btn-danger" id="contrNo" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"></path>
                                    </svg>
                                </button>
                            </li>
                        </ul>
                        
                        <br>
                        <br>
                        <button type="button" class="btn btn-success" onclick="cambiarContra()">Guardar Cambios</button>
                    </div>
                </div>
                <!–– Fin Principal -->
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>

<script src="funcionesNueva.js"></script>
</html>