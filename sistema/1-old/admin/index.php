<?php
session_start();
// echo $_SESSION['tipo'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema Administrador</title>
    <?php  include_once "dependencias.php" ?>
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body>
            <!–– menu -->
             <?php  include_once "menuAdmin.php" ?>
            <!–– fin menu -->
            <div class="jumbotron">
                <!–– Principal -->
                <div class="card-body">
                    <h1>administrador</h1>
                    <!-- crear panel de control -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Panel de control</h5>
                                    <p class="card-text">
                                        <a href="panelControl.php" class="btn btn-primary">Panel de control</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Mensajes</h5>
                                    <p class="card-text">
                                        <a href="mensajes.php" class="btn btn-primary">Mensajes</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Reportes</h5>
                                    <p class="card-text">
                                        <a href="reportes.php" class="btn btn-primary">Reportes</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- usuario -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Usuarios</h5>
                                    <p class="card-text">
                                        <a href="usuarios.php" class="btn btn-primary">Usuarios</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- fin usuario -->
                    </div>


                </div>
                <!–– Fin Principal -->
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>

</html>