<?php
session_start();
// echo $_SESSION['tipo'];
require_once "../../conSanatorio.php";
require_once "../../conUsuario.php";
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
$userr = $_SESSION['idUsuario']; /*VALOR USUARIO*/


$con = mysqli_query($conUsuario, "SELECT mj.id_mensaje, mj.fecha_creacion, mj.id_usuario_creacion, mj.mensaje, mj.titulo, us.nombre, mj.importancia
FROM mensajes AS mj INNER JOIN usuarios AS us ON us.userid = mj.id_usuario_creacion");

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
                                <a class="nav-link active" id="pills-Principal-tab" data-toggle="pill" href="#pills-Principal" role="tab" aria-controls="pills-Principal" aria-selected="true">Principal</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-Enviados-tab" data-toggle="pill" href="#pills-Enviados" role="tab" aria-controls="pills-Enviados" aria-selected="false">Enviados</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-Recibidos-tab" data-toggle="pill" href="#pills-Recibidos" role="tab" aria-controls="pills-Recibidos" aria-selected="false">Recibidos</a>
                            </li>
                        </ul>
                </div>
                <div class="card-body">
                    <form class="was-validated">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-Principal" role="tabpanel" aria-labelledby="pills-Principal-tab">                        
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">DESTINATARIO</span>
                                    </div>
                                    <select class="js-example-basic-multiple custom-select" name="states[]" id="name" multiple="multiple" required>
                                        <option value="AL">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</option>
                                        <option value="0">TODOS</option>
                                            <?php 
                                                $sql = "SELECT Matricula, Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre";
                                                $result = mysqli_query($conSanatorio, $sql);
                                                while($row = mysqli_fetch_array($result)){ ?>
                                                    <option value="<?php echo $row['Matricula'] ?>" ><?php echo $row['Matricula'] ?> | <?php echo utf8_encode($row['Nombre']) ?> </option>";
                                                    
                                            <?php   } ?>
                                    </select>
                                    <script>
                                        $(document).ready(function() {
                                            $('.js-example-basic-multiple').select2();
                                        });
                                    </script>
                                </div>
                                
                                <br>
                                <br>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Titulo</span>
                                    </div>
                                    <textarea class="form-control is-invalid" aria-label="With textarea" id="titulo" rows="1" cols="10" required></textarea>
                                </div>
                                <br><br>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Importancia</label>
                                    </div>
                                    <select class="custom-select is-invalid" id="importancia" required>
                                        <option selected></option>
                                        <option value="0">Normal</option>
                                        <option value="1">Alta</option>
                                    </select>
                                </div>
                                <br><br>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">MENSAJE</span>
                                    </div>
                                    <textarea class="form-control is-invalid" aria-label="With textarea" id="mensaje" rows="8" cols="50" required></textarea>
                                </div>
                                <br><br>
                                <div>
                                    <button type="button" class="btn btn-success" onclick="EnviarMensaje()">Enviar Mensaje</button>
                                </div>




                            </div>
                    <form class="was-validated">   
                            <div class="tab-pane fade" id="pills-Enviados" role="tabpanel" aria-labelledby="pills-Enviados-tab">
                                <div class="table-responsive">
                                    
                                    <table id="mensajes" class="table display" >
                                        <thead class="thead-dark" style="background-color:#004993;">
                                            <tr>
                                                <th scope="col">id Mensaje</th>
                                                <th scope="col">Titulo</th>
                                                <th scope="col">Mensaje</th>
                                                <th scope="col">Fecha de Creacion</th>
                                                <th scope="col">Id Creacion</th>
                                                <th scope="col">Importancia</th>
                                                <th scope="col">Ver</th>
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
                                                <td> <?php echo $row['id_mensaje'] ?> </td>
                                                <td> <?php echo utf8_encode($row['titulo']) ?> </td>
                                                <td> <?php echo utf8_encode(substr($row['mensaje'],0,90)) ?> </td>
                                                <td> <?php echo substr($row['fecha_creacion'], 0, -9);?></td>
                                                <td> <?php echo $row['nombre'] ?> </td>
                                                <td> <?php echo $row['importancia'] ?> </td>
                                                <td> <span type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalMensaje" onclick="Mensaje(<?php echo $row['id_mensaje']?>)">Ver</span> </td>
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
        $('#mensajes').DataTable({ 
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },        
        "dom": 'lrtip',
        fixedHeader: {
                header: true,
                footer: true,
                },
        ordering: true,
        "info": false
        
        })

    });
</script>
</html>


<div class="modal fade" id="ModalMensaje" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mensaje</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- -->      
      <div class="form-group">
        <label for="exampleFormControlSelect1">Fecha y Hora</label>
        <input type="tex" class="form-control" id="Fecha" maxlength="11" readonly>
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1">Enviado Por</label>
        <input type="tex" class="form-control" id="Remitente" readonly>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Mensaje</label>
        <textarea class="form-control" id="Mensaje" rows="10" readonly></textarea>
      </div>
      <!-- -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>