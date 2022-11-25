<?php
session_start();
// echo $_SESSION['tipo'];
require_once "../../conSanatorio.php";
require_once "../../conUsuario.php";


$query = mysqli_query($conSanatorio, "SELECT * 
FROM quirofanoshorarios AS tur 
INNER JOIN quirofanos AS q ON q.Numero = tur.Quirofano 
ORDER BY q.orden");

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
                    <!--  -->

                    
                        <table class="table text-center" id="example">                           
                            <thead>
                                <tr>
                                    <th scope="col">QUIRIFANO</th>
                                    <th scope="col">HORA INICIO</th>
                                    <th scope="col">HORA FIN</th>
                                    <th scope="col">INTERVALO</th>
                                    <th scope="col">TIEMPO ENTRE TURNO</th>
                                    <th scope="col">HABILITADO</th>
                                    <th scope="col">EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!$query) {?>
                                <tr>
                                    <td colspan="6">No hay datos para mostrar</td>
                                </tr>

                                <?php }
                                else {
                                while($row=mysqli_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td scope="row"><?php echo $row['Descripcion'] ?></td>
                                    <td><?php echo $row['HoraInicio'] ?></td>
                                    <td><?php echo $row['HoraFin'] ?></td>
                                    <td><?php echo $row['Intervalo'] ?></td>
                                    <td><?php echo $row['TiempoEntreTurno'] ?></td>
                                    <td>
                                        <?php if($row['web'] == 1) { ?>
                                            <div class="alert alert-success" role="alert">
                                                HABILITADO
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger" role="alert">
                                                DESHABILITADO
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td> <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal" onclick="EditarQ(<?php echo $row['Quirofano'] ?>)">EDITAR</button> </td>
                                </tr>
                                <?php
                                }//Fin while
                                 // }
                                }//Fin if   
                                mysqli_close($conSanatorio); ?>
                            </tbody>                            
                        </table>

                </div>
                <!–– Fin Principal -->
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>

</html>

<script>
    $(document).ready(function(){
        $('#example').DataTable({

            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                fixedHeader: {
                header: true,
                footer: true,
                },
                
                ordering: false,
                responsive: "true",
                dom: 'Bfrtilp',       
                buttons:[ 
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fas fa-file-excel"></i> ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend:    'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        text:      '<i class="fas fa-file-pdf"></i> ',
                        titleAttr: 'Exportar a PDF',
                        className: 'btn btn-danger'
                    },
                    {
                        extend:    'print',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        text:      '<i class="fa fa-print"></i> ',				
                        className: 'btn btn-info',
                        messageTop: 'ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ <img src="../../images/logo_modelo.png">',
                    },
                ]	
        });

    });
</script>
<script src="func.js"></script>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Horario Quirofano</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <ul class="list-group list-group-horizontal-md">
            <li class="list-group-item border-0">Tipo:                         </li>
            <li class="list-group-item border-0"><input class="form-control" type="text" id="tp" disabled></li>
        </ul>

        <ul class="list-group list-group-horizontal-md">
            <li class="list-group-item border-0">Hora Inicio:               </li>
            <li class="list-group-item border-0"><input type="time" class="form-control" id="HoraI"/></li>
        </ul>

        <ul class="list-group list-group-horizontal-md">
            <li class="list-group-item border-0">Hora Fin:                   </li>
            <li class="list-group-item border-0"><input type="time" class="form-control" id="HoraF"/></li>
        </ul>

        <ul class="list-group list-group-horizontal-md">
            <li class="list-group-item border-0">Intervalo:                  </li>
            <li class="list-group-item border-0"><input class="form-control" type="text" id="intervalo"></li>
        </ul>

        <ul class="list-group list-group-horizontal-md">
            <li class="list-group-item border-0">Tiempo Entre Turno:</li>
            <li class="list-group-item border-0"><input class="form-control" type="text" id="entre"></li>
        </ul>

        <ul class="list-group list-group-horizontal-md">
            <li class="list-group-item border-0">Estado:                      </li>
            <li class="list-group-item border-0">
                <select class="custom-select" id="esta">
                    <option selected>            </option>
                    <option value="1">Habilitado</option>
                    <option value="0">Deshabilitado</option>
                    
                </select>
            </li>
        </ul>
        <ul class="list-group list-group-horizontal-md" style="display:none">
            <li class="list-group-item border-0">Quirofano:</li>
            <li class="list-group-item border-0"><input class="form-control" type="text" id="q"></li>
        </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="GuardarModi()">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>