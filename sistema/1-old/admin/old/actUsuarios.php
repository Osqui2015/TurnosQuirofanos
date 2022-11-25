<?php
session_start();
// echo $_SESSION['tipo'];
require_once "../../conSanatorio.php";
require_once "../../conUsuario.php";
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
$userr = $_SESSION['idUsuario']; /*VALOR USUARIO*/


$con = mysqli_query($conUsuario, "SELECT * FROM usuarios");

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
            <!–– menu -->
             <?php  include_once "menuAdmin.php" ?>
            <!–– fin menu -->
            <div class="jumbotron">
            <input type = "hidden" name = "iduser" value = "<?php echo $userr ?>" id="iduser">
            <div class="card">
                <div class="card-header">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-Principal-tab" data-toggle="pill" href="#pills-Principal" role="tab" aria-controls="pills-Principal" aria-selected="true">Crear Usuario</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-Enviados-tab" data-toggle="pill" href="#pills-Enviados" role="tab" aria-controls="pills-Enviados" aria-selected="false">Lista de Usuario</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-Recibidos-tab" data-toggle="pill" href="#pills-Recibidos" role="tab" aria-controls="pills-Recibidos" aria-selected="false">Editar Usuario</a>
                            </li>
                        </ul>
                </div>
                <div class="card-body">
                   
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-Principal" role="tabpanel" aria-labelledby="pills-Principal-tab">                        
                                <!-- /*crear usuario*/ -->
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold" >TIPO</label>
                                    <div class="col-sm-8">
                                        <select class="custom-select" id="tiposCrea" onchange="TipoSelect()" >                    
                                            <option value="1">ADMINISTRADORES</option>
                                            <option value="2">MEDICOS</option>
                                            <option value="3">CONSULTAS</option>
                                            <option value="4">TURNOS</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" id="selectProfesional" >
                                    <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold font-weight-bold">Profesional</label>
                                    <div class="col-5">


                                        <select class="js-example-basic-single" name="state" id="profesional" >                                        
                                            <option value="">ㅤㅤㅤㅤㅤㅤㅤSeleccioneㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</option>
                                            <?php 
                                            
                                                /*$sql = "SELECT Matricula, Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre"; */
                                                $sql = "SELECT pr.Matricula, pr.Nombre 
                                                FROM sanatorio.profesionales AS pr 
                                                WHERE pr.Matricula NOT IN (
                                                    SELECT matricula FROM zetap_sanatorio.usuarios WHERE matricula IS NOT NULL
                                                    )
                                                AND pr.Matricula NOT IN ( 1, 2, 3, 66, 99, 111, 333, 559, 1111, 1234, 5563 )
                                                AND pr.Activo = 1 order by pr.Nombre";
                                                
                                                $result = mysqli_query($conSanatorio, $sql);
                                                while($row = mysqli_fetch_array($result)){ ?>						
                                                <option value="<?php echo $row['Matricula'] ?>" ><?php echo $row['Matricula'] ?> | <?php echo utf8_encode($row['Nombre']) ?> </option>";
                                            <?php }?>
                                        </select>
                                            
                                            <span id="vMatricula" hidden = ""> <?php echo $matricula; ?> </span>
                                            <script>
                                                $('#profesional').on('change', function(){
                                                    var valor = this.value;
                                                    $('#vMatricula').text(valor);                                                                                                
                                                })
                                            </script>
                                    </div>				
                                </div>
                                
                                <div class="form-group row" id="mosNombre">
                                    <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold" >Nombre y Apellido</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nomyape" name="nomyape" >	
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold" >E-MAIL</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email1" name="email1" onblur="validEmail()">	
                                    </div>
                                </div>

                                <div class="form-group row">				
                                        <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold" >Usuario</label>				
                                    <div class="col-sm-8">
                                        <input id="user2" type="text" class="form-control" onblur="validUser()">	
                                    </div>
                                </div>
                                <div class="form-group row">				
                                        <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Contraseña</label>				
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="pass" name="pass">
                                    </div>
                                </div>
                                <div class="form-group row">				
                                        <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Repetir Contraseña</label>				
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="passw" name="passw" onblur="validContra()">	
                                    </div>
                                </div>
                                <!------------------>
                                <br><br>
                                <button type="button" class="btn btn-primary" onclick="ConfirmarR()">Confirmar</button>
                            </div>
                     
                            <div class="tab-pane fade" id="pills-Enviados" role="tabpanel" aria-labelledby="pills-Enviados-tab">
                                <div class="table-responsive">
                                    
                                    <table id="user" class="table display" >
                                        <thead class="thead-dark" style="background-color:#004993;">
                                            <tr>
                                                <th scope="col">Matricula</th>
                                                <th scope="col">Nombre</th>
                                                
                                                <th scope="col">Email</th>
                                                <th scope="col">Activacion</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Mensajes</th>
                                                <th scope="col">Panel</th>
                                                <th scope="col">Editar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php              
                                            if(!$con) {?>
                                                <tr>
                                                    <td colspan="6">No hay datos para mostrar</td>
                                                </tr>
                                            <?php }else {
                                                while($row=mysqli_fetch_array($con)) {
                                            ?>
                                            <tr>
                                                <td> <?php echo $row['matricula'] ?> </td>
                                                <td> <?php echo $row['nombre'] ?> </td>
                                                
                                                <td> <?php echo $row['mail']?> </td>
                                                <td> <?php 
                                                        if ($row['activacion'] == 1) {
                                                            ?><button type="button" class="btn btn-danger">DESACTIVAR</button>
                                                        <?php }else{ ?>
                                                            <button type="button" class="btn btn-success">ACTIVAR</button>
                                                        <?php } ?>
                                                </td>
                                                <td> <?php 
                                                            switch ($row['tipo']) {
                                                                case 1:
                                                                    ?>  <div class="alert alert-secondary" role="alert">
                                                                            ADMINISTRADOR
                                                                        </div>
                                                                    <?php
                                                                    break;
                                                                case 2:
                                                                    ?>  <div class="alert alert-primary" role="alert">
                                                                            MEDICO
                                                                        </div>
                                                                    <?php
                                                                    break;
                                                                case 3:
                                                                    ?>  <div class="alert alert-warning" role="alert">
                                                                            CONSULTA
                                                                        </div>
                                                                    <?php
                                                                    break;
                                                                case 4:
                                                                    ?> <div class="alert alert-danger" role="alert">
                                                                            TURNOS
                                                                        </div>
                                                                    <?php
                                                                    break;
                                                                default:
                                                                echo "SIN ASIGNAR TIPO";
                                                            }
                                                    ?> 
                                                </td>
                                                <td> <?php 
                                                            switch ($row['mensajes']) {
                                                                case 0:
                                                                    ?>  
                                                                        <div class="alert alert-danger" role="alert">
                                                                            DESACTIVADO
                                                                        </div>
                                                                    <?php
                                                                    break;
                                                                case 1:
                                                                    ?>  
                                                                        <div class="alert alert-primary" role="alert">
                                                                            ACTIVO
                                                                        </div>
                                                                    <?php
                                                                    break;                                                                
                                                                default:
                                                                echo "SIN ASIGNAR TIPO";
                                                            }
                                                    ?> 
                                                </td>
                                                <td>
                                                    <?php 
                                                            switch ($row['panel']) {
                                                                case 0:
                                                                    ?>  
                                                                        <div class="alert alert-danger" role="alert">
                                                                            DESACTIVADO
                                                                        </div>
                                                                    <?php
                                                                    break;
                                                                case 1:
                                                                    ?>  
                                                                        <div class="alert alert-primary" role="alert">
                                                                            ACTIVO
                                                                        </div>
                                                                    <?php
                                                                    break;                                                                
                                                                default:
                                                                echo "SIN ASIGNAR TIPO";
                                                            }
                                                    ?> 
                                                </td>
                                                <td>                                                     
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal" onclick="Editar(<?php echo $row['matricula'] ?>)" >EDITAR</button> 
                                                </td>
                                                
                                            </tr>
                                            <?php
                                            }//Fin while
                                            }//Fin if   
                                            ?>
                                        </tbody>
                                    </table>
                                    </table>
                                </div>                                        
                            </div>

                            <div class="tab-pane fade" id="pills-Recibidos" role="tabpanel" aria-labelledby="pills-Recibidos-tab">
                                Recibidos
                            </div>
                    </div>
                
                </div>
            </div>
                
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>
<script src="func.js"></script>
<script>
    $(document).ready(function() {
        $('#selectProfesional').hide();
        $('#user').DataTable({ 
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }     
        });
        $('.js-example-basic-single').select2();

    });
</script>
</html>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Matricula :ㅤㅤㅤㅤㅤㅤ</li>
            <li class="list-group-item border-0"> <input type="text" id="matricula" disabled > </li>
        </ul>
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Nombre y Apellido:ㅤㅤ</li>
            <li class="list-group-item border-0"> <input type="text" id="nombre" > </li>
        </ul>
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Usuario:ㅤㅤㅤㅤㅤㅤㅤ</li>
            <li class="list-group-item border-0"> <input type="text" id="usuario"> </li>
        </ul>
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Email:ㅤㅤㅤㅤㅤㅤㅤㅤ</li>
            <li class="list-group-item border-0"> <input type="text" id="email" > </li>
        </ul>
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Tipo :ㅤㅤㅤㅤㅤㅤㅤㅤ</li>
            <li class="list-group-item border-0">                 
                <select class="custom-select" id="tipos" >                    
                    <option value="1">ADMINISTRADORES</option>
                    <option value="2">MEDICOS</option>
                    <option value="3">CONSULTAS</option>
                    <option value="4">TURNOS</option>
                </select>
            </li>
        </ul>
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Reporte de  Turno :ㅤㅤ</li>
            <li class="list-group-item border-0"> 
                <select class="custom-select" id="reporteTurno" >
                    <option value="0">DESACTIVADOㅤ</option>
                    <option value="1">ACTIVADOㅤㅤㅤ</option>                    
                </select>
            </li>
        </ul>
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Reporte de  Creacion :ㅤ</li>
            <li class="list-group-item border-0"> 
                <select class="custom-select" id="reporteCreacion" >
                    <option value="0">DESACTIVADOㅤ</option>
                    <option value="1">ACTIVADOㅤㅤㅤ</option>                    
                </select>
            </li>
        </ul>
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Mensajes :ㅤㅤㅤㅤㅤㅤ</li>
            <li class="list-group-item border-0"> 
                <select class="custom-select" id="mensajes" >
                    <option value="0">DESACTIVADOㅤㅤ</option>
                    <option value="1">ACTIVADOㅤㅤㅤ</option>                    
                </select>
            </li>
        </ul>
        <ul class="list-group list-group-horizontal-sm">
            <li class="list-group-item border-0">Panel:ㅤㅤㅤㅤㅤㅤㅤㅤ</li>
            <li class="list-group-item border-0">
                <select class="custom-select" id="panel" >
                    <option value="0">DESACTIVADOㅤ</option>
                    <option value="1">ACTIVADOㅤㅤㅤ</option>                    
                </select>
            </li>
        </ul>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <button type="button" class="btn btn-primary" onclick="GuardarCambio()">GUARDAR CAMBIOS</button>
      </div>
    </div>
  </div>
</div>