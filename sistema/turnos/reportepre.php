<?php

    header('Content-Type: text/html; charset=UTF-8');

    session_start();

    // echo $_SESSION['matricula'];

    $matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/

    require_once "../../conSanatorio.php";

    
    $menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden"); //order by Orden 


    $query = mysqli_query($conSanatorio, "SELECT tur.Numero, p.Nombre AS Medico, tur.Nombre AS Paciente, tip.Descripcion AS Tipo_Documento, DniPaciente, 
    ObraSocial, tur.Telefono, Email, DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fecha, DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
    DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin, q.Descripcion AS Quirofano, CodigoPractica, pq.Descripcion, Anestesista, Rx, Sangre, Monitoreo, 
    Arco, ForceTriad, ForceTriad_Propio, Uti, Laparoscopica, ParaInternar, DescripcionCirugia, InsumosNoHabituales, Estado, usuario , FechaGrabacion
    
    FROM turnosquirofano AS tur LEFT JOIN tiposdocumentoidentidad AS tip ON tip.TipoDocumentoIdentidad=tur.TipoDocumentoIdentidad 
    INNER JOIN profesionales p ON p.Matricula=tur.MatriculaProfesional 
    INNER JOIN quirofanos q ON q.Numero=tur.Quirofano 
    INNER JOIN turnosquirofanospracticas tp ON tp.Numero=tur.Numero 
    INNER JOIN practicasquirofano pq ON tp.CodigoPractica = pq.codigo
    WHERE fecha = CURDATE()
    GROUP BY tur.Numero 
    ORDER BY q.orden, Fecha, HoraInicio"); 

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis Turnos</title>

<?php  include_once "dependencias.php" ?>
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">

    <!–– Principal -->            
            <!–– menu -->
             <?php  include_once "menuTurnos.php" ?>
            <!–– fin menu -->
            <input hidden = "" id="vMatricula" value = "<?php echo $matricula; ?>"> </input>
    <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
        <!--- TABLA Detalle---------------------------------> 

            <!–– Principal -->

        <br>            <br> <br>
            <div class="mx-auto" style="width: 1100px;"> <!-- Tabla Imagen-->                 
                <div class="card text-center">                    
                    <div class="card-body">                        
                            <div class="row">                            
                                <div class="col">
                                    <h5 class="card-title">Fecha Inicio: </h5>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" id="fecha" name="fecha" onchange = "ModiNuevo()" required>
                                </div>
                                <div class="col">
                                    <h5 class="card-title">Quirofano:</h5>
                                </div>
                                <div class="col">
                                    <select  class="custom-select" name="menuQuirofano" id="menuQuirofano" onchange = "ModiNuevo()">
                                        <option value="00">TODOS</option>
                                        <?php 
                                            while($row=mysqli_fetch_array($menQuirofano)) {
                                        ?>
                                            <option value="<?php echo $row['Numero']?>"> <?php echo $row['Descripcion']?> </option>
                                        <?php }?>
                                    </select>
                                    <span id="selectMenuQuirofano" hidden=""></span> <!-- VALOR DEL QUIROFANO -->
                                    <script>
                                        $('#menuQuirofano').on('change', function(){
                                            var valor = this.value;
                                            $('#selectMenuQuirofano').text(valor);                                                   
                                        })
                                    </script>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                
                                        <div class="col">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="checkfechaFin custom-control-input" id="checkfechaFin">
                                                <label class="custom-control-label" for="checkfechaFin"><h5 class="card-title">Fecha Fin:</h5></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control" id="fechaFin" name="fechaFin" onchange = "ModiNuevo()" disabled required>
                                        </div>                                    
                                <div class="col">
                                    <h5 class="card-title">Fecha Grabacion</h5>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" id="paciente" onchange = "ModiNuevo()">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-info" onclick = "BorrarFiltro()">Borrar Filtro</button>
                                </div>
                            </div>
                    </div>                    
                </div>                   
            </div>
        <br>
        <div class="mx-auto" style="width: 900px;"> <!-- Tabla Imagen--> 
                <div class="accordion" id="cImg"> 
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#cImge" aria-expanded="true" aria-controls="cImge">
                                Mostrar / Ocultar
                            </button>
                        </h2>
                        </div>

                        <div id="cImge" class="collapse show" aria-labelledby="headingOne" data-parent="#cImg">
                            <div class="card-body">
                                <div class="form-row" id="tabla">    <!-- Tabla de Turnos Ocupados-->                                    
                                    <div  class="col-lg-12" style="display: block;">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <img class="img-fluid" src="../../images/diagrama.png" />
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <br>

        
        <div class="card text-center">
            <div class="card-header">
                <div class="alert alert-light" role="alert">
                    aquí se mostraran los resultados
                </div>
            </div>
            <div class="card-body">
                <div id='misTurnos'>
                                  <!--- TABLA ----> 
                    <div class="table-responsive">    
                        <table class="display compact table table-striped table-hover table-condensed" id="reporteTurno">
                            <thead>
                                <tr class="bg-info">
                                    <th>Numero</th>
                                    <th>Quirofano</th>
                                    <th>Medico</th>
                                    <th>Paciente</th>  
                                    <th>Tipo Documento</th>
                                    <th>DniPaciente</th>
                                    <th>Obra Social</th> 
                                    <th>Telefono</th>
                                    
                                    <th>Fecha</th>
                                    <th>Hora Inicio</th> 
                                    <th>hora Fin</th> 
                                    
                                    <th>Codigo Practica</th>
                                    <th>Descripcion Practica</th>
                                    <th>Anestesista</th>
                                    <th>Rx</th>
                                    <th>Sangre</th>
                                    <th>Monitoreo</th>
                                    <th>Arco</th>
                                    <th>ForceTriad</th>
                                    <th>ForceTriad_Propio</th>
                                    <th>Uti</th>
                                    <th>Laparoscopica</th>
                                    <th>ParaInternar</th>
                                    <th>DescripcionCirugia</th>

                                    <th>Fecha de Grabacion</th>
                                    
                                    <th>Estado</th>
                                    <th>Usuario</th>                                                      
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
                                        <td scope="row"><?php echo $row['Numero'] ?></td>
                                        <td><?php echo $row['Quirofano'] ?></td>

                                        <td><?php echo utf8_encode($row['Medico']) ?></td>
                                        <td><?php echo utf8_encode($row['Paciente']) ?></td>
                                        <td><?php echo $row['Tipo_Documento'] ?></td>
                                        <td><?php echo $row['DniPaciente'] ?></td>
                                        <td><?php echo $row['ObraSocial'] ?></td>
                                        <td><?php echo $row['Telefono'] ?></td>
                                        
                                        <td><?php echo $row['Fecha'] ?></td>
                                        <td><?php echo $row['HoraInicio'] ?></td>
                                        <td><?php echo $row['HoraFin'] ?></td>
                                        
                                        <td><?php echo $row['CodigoPractica'] ?></td>
                                        <td><?php echo utf8_encode($row['Descripcion']) ?></td>
                                        <td><?php echo $row['Anestesista'] ?></td>
                                        <td><?php echo $row['Rx'] ?></td>
                                        <td><?php echo $row['Sangre'] ?></td>
                                        <td><?php echo $row['Monitoreo'] ?></td>
                                        <td><?php echo $row['Arco'] ?></td>
                                        <td><?php echo $row['ForceTriad'] ?></td>
                                        <td><?php echo $row['ForceTriad_Propio'] ?></td>
                                        <td><?php echo $row['Uti'] ?></td>
                                        <td><?php echo $row['Laparoscopica'] ?></td>
                                        <td><?php echo $row['ParaInternar'] ?></td>
                                        <td><?php echo $row['DescripcionCirugia'] ?></td>

                                        <td><?php echo $row['FechaGrabacion'] ?></td>
                                        
                                        <td><?php echo $row['Estado'] ?></td>
                                        <td><?php echo $row['usuario'] ?></td>                                            
                                    </tr>
                                    <?php
                                    }//Fin while
                                // }
                                    }//Fin if   
                                    mysqli_close($conSanatorio); ?>
                            </tbody>
                        </table>
                    </div>
                                  <!--- TABLA ----> 

                </div>
            </div>
            <div class="card-footer text-muted">
                
            </div>
        </div>
        
    </div>
    <!–– Fin Principal -->
    
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
    <script src="funcionesTurno.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reporteTurno').DataTable({ 
                "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                fixedHeader: {
                    header: true,
                    footer: true,
                },
                ordering: false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        split: [ 'pdf', 'print'],
                    }
                ]
            });
        });
    </script>
</body>
</html>




<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">SUSPENDER TURNO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <?php 
                $cons = mysqli_query($conSanatorio, "SELECT * FROM motivosuspension");
            ?>
            <label>Motivo de la Suspensión</label>
            <select class="form-control" id="motivo_suspension">
                <option value="0">Seleccione un motivo</option>
                <?php while($row = mysqli_fetch_array($cons)){ ?>
                    <option value="<?php echo $row['Motivo'] ?>"><?php echo  utf8_encode($row['Descripcion']) ?></option>
                <?php } ?>
            </select>
            <li class="list-inline-item"><span id="selectSuspen" hidden = ""></span></li>
            <li class="list-inline-item"><span id="idSuspender" hidden = ""></span></li>
            
            <script>
                    $('#motivo_suspension').on('change', function(){
                        var valor = this.value;
                        $('#selectSuspen').text(valor);
                    })
            </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <button type="button" class="btn btn-primary" onclick="suspenderCon()" >CONFIRMAR</button>
      </div>
    </div>
  </div>
</div>