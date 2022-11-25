<?php

    header('Content-Type: text/html; charset=UTF-8');

    session_start();

    // echo $_SESSION['matricula'];

    $matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/

    require_once "../../conSanatorio.php";

    
    $menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden"); //order by Orden 


    $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
                            tq.numero AS numero,
                            CASE DAYOFWEEK(fecha)
                                WHEN 1 THEN 'Domingo'
                                WHEN 2 THEN 'Lunes'
                                WHEN 3 THEN 'Martes'
                                WHEN 4 THEN 'Miércoles'
                                WHEN 5 THEN 'Jueves'
                                WHEN 6 THEN 'Viernes'
                                WHEN 7 THEN 'Sábado'
                                END Dia,
                            Fecha, 
                            DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
                            DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin, 
                            LTRIM(RTRIM(tq.Nombre)) AS Paciente, 
                            SUBSTRING(pa.Descripcion,1,50) AS DescriPractica,
                            q.Descripcion AS quirdes
                            FROM turnosquirofano AS tq 
                            INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                            INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
                            INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                            INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
                            WHERE MatriculaProfesional= $matricula
                            AND tq.Estado = 'PENDIENTE'
                            AND Fecha >= CURDATE() 
                            GROUP BY tq.numero
                            ORDER BY Fecha, HoraInicio;"); 

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis Turnos</title>
<style>
    
    .tooltip {

    left: 20%;

    background-color:black;
    color:white;
    border-radius:5px;
    opacity:0;
    position:absolute;
    -webkit-transition: opacity 0.5s;
    -moz-transition:  opacity 0.5s;
    -ms-transition: opacity 0.5s;
    -o-transition:  opacity 0.5s;
    transition:  opacity 0.5s;
    }

    .hover:hover .tooltip {
    opacity:0.9;
    }

    
</style>
<?php  include_once "dependencias.php" ?>
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
    <!–– Principal -->            
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <input hidden = "" id="vMatricula" value = "<?php echo $matricula; ?>"> </input>
    <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
        <!--- TABLA Detalle---------------------------------> 

            <!–– Principal -->

        <br>            
            <div class="row justify-content-center"> <!-- Tabla Imagen-->                 
                <div class="card text-center">                    
                    <div class="card-body">                        
                            <div class="row">                            
                                <div class="col-md">
                                    <h5 class="card-title">Desde: </h5>
                                </div>
                                <div class="col-md">
                                    <input type="date" class="form-control" id="fecha" name="fecha" onchange = "ModiNuevo()" required>
                                </div>
                                <!--<div class="col-md">
                                    <h5 class="card-title">Quirofano:</h5>
                                </div>
                                <div class="col-md">
                                    <select  class="custom-select" name="menuQuirofano" id="menuQuirofano" onchange = "ModiNuevo()">
                                        <option value="00">TODOS</option>
                                        <?php 
                                            while($row=mysqli_fetch_array($menQuirofano)) {
                                        ?>
                                            <option value="<?php echo $row['Numero']?>"> <?php echo $row['Descripcion']?> </option>
                                        <?php }?>
                                    </select>
                                    <span id="selectMenuQuirofano" hidden=""></span>  VALOR DEL QUIROFANO 
                                    <script>
                                        $('#menuQuirofano').on('change', function(){
                                            var valor = this.value;
                                            $('#selectMenuQuirofano').text(valor);                                                   
                                        })
                                    </script> 
                                </div> -->
                                <div class="col-md">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="checkfechaFin custom-control-input" id="checkfechaFin">
                                        <label class="custom-control-label" for="checkfechaFin"><h5 class="card-title">Hasta:</h5></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <input type="date" class="form-control" id="fechaFin" name="fechaFin" onchange = "ModiNuevo()" disabled required>
                                </div>           
                                <div class="col-md">
                                    <h5 class="card-title">Paciente</h5>
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control" id="paciente" onkeyup = "ModiNuevo()">
                                </div>
                                <div class="col-md">
                                    <button type="button" class="btn btn-info" onclick = "BorrarFiltro()">Borrar Filtro</button>
                                </div>
                            </div>
                    </div>                    
                </div>                   
            </div>
        
        
  
    

            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <!-- <img class="img-fluid" src="../../images/diagrama.png" /> -->
                        <div class="table-responsive">
                            <?php  include_once "tablaquir.php" ?>
                        </div>
                        <p class="text-break text-center alert alert-info"  role="alert">La prioridad de programación según el esquema presentado en la tabla rige hasta las 14 horas de cada día, luego la programación es libre en todos los quirófanos.</p>
                    </div>
                </div>
            </div> 
        
        
        

        
        <div class="card text-center">            
            <div class="card-body">
                <div id='misTurnos'>
                                  <!--- TABLA ----> 
                    <div class="table-responsive">    
                        <table class="display compact table table-striped table-hover table-condensed" id="misTurnosPrincipal">
                            <thead>
                                <tr class="p-3 mb-2 bg-light text-dark">
                                    <th><small>E</small></th>                   
                                    <th>Dia</th>
                                    <th>Fecha</th>
                                    <th>Desde</th> 
                                    <th>Hasta</th> 
                                    <th>Paciente</th> 
                                    <th>Práctica</th>
                                    <th>Quirófano</th> 
                                    <th>Modif.</th>
                                    <th>Susp.</th>                 
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
                                        <td class="text-white"> <?php echo $row['Estado'][0] ?> </td>                         
                                        <td> <?php echo $row['Dia'];?> </td> 
                                        <td>    <?php 
                                                    $date = substr($row['Fecha'], 0, -9);
                                                    $newDate = date("d-m-Y", strtotime($date));
                                                    echo $newDate;
                                                ?> 
                                        </td>
                                        <td> <?php echo $row['HoraInicio'] ?> </td>
                                        <td> <?php echo $row['HoraFin'] ?> </td>
                                        <td> 
                                            <?php 
                                                $numero_turno = $row['numero']; 
                                                $rr = mysqli_query($conSanatorio,"SELECT Numero,
                                                Nombre, 
                                                tur.TipoDocumentoIdentidad, 
                                                tip.Descripcion AS Tipo_Documento, 
                                                DniPaciente, 
                                                ObraSocial, 
                                                Telefono
                                                FROM turnosquirofano AS tur 
                                                LEFT JOIN tiposdocumentoidentidad AS tip 
                                                ON tip.TipoDocumentoIdentidad=tur.TipoDocumentoIdentidad  
                                                WHERE numero = $numero_turno");
                                                $r = mysqli_fetch_array($rr)
                                            ?>

                                                <div class="hover"> 
                                                    <?php echo utf8_encode($row['Paciente']) ?>
                                                    <span class="tooltip">  <u><b> Datos del Paciente: </b></u> <br>
                                                                            <b> DNI: </b> <?php echo $r['DniPaciente']?> <br>
                                                                            <b>Telefono:</b> <?php echo $r['Telefono']?> <br>
                                                                            <b>ObraSocial:</b> <?php echo $r['ObraSocial']?> <br>
                                                    </span>
                                                </div>

                 
                                            
                                        </td>
                                        <td> <?php echo utf8_encode($row['DescriPractica']) ?></td>
                                        <td> <small> <?php echo $row['quirdes']; ?></small></td>
                                        
                                        <?php if ($row['Estado'][0] == "P"){ ?>
                                            <td> 
                                                <span id="numero" hidden=""><?php echo $row['numero'] ?></span>                        
                                                <button type="button" class="btn btn-warning btn-sm" onclick="Modificar(<?php echo $row['numero']?>)"> <img  src="../../images/pencil-square.svg"></img> </button> 
                                                <!--<button type="button" class="btn btn-warning btn-sm" onclick="ModificarError(<?php echo $row['numero']?>)"> <img  src="../../images/pencil-square.svg"></img> </button>-->
                                            </td>
                                            <td>   
                                                <!-- <button type="button" class="btn btn-danger btn-sm" onclick="Suspenderr(<?php echo $row['numero']?>)"> <img  src="../../images/x-octagon-fill.svg"></img> </button> ---    -->

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" onclick="Sus(<?php echo $row['numero']?>)" >x</button>
                                                
                                            </td>
                                        <?php } else{ ?>
                                            <td> 
                                            </td>
                                            <td>                                   
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    }//Fin while
                                // }
                                    }//Fin if   
                                    ?>
                            </tbody>
                        </table>
                    </div>
                                  <!--- TABLA ----> 

                </div>
            </div>
            <div class="card-footer text-muted">
                <span class="badge badge-primary"><FONT SIZE=5>Pendiente</FONT></span>
                <span class="badge badge-secondary "><FONT SIZE=5>No Realizado</FONT></span>
                
                <span class="badge badge-success"><FONT SIZE=5>Realizado</FONT></span>            
                <span class="badge badge-danger"><FONT SIZE=5>Suspendido</FONT></span>
            </div>
        </div>
        
    </div>
    <!–– Fin Principal -->
    
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
    <script src="funcionesNueva.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#misTurnosPrincipal').DataTable({ 
                "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                fixedHeader: {
                    header: true,
                    footer: true,
                },
                dom: 'Bfrtip',
                buttons:[ 
                        {
                                extend:    'excelHtml5',
                                text:      'Exportar a Excel',
                                titleAttr: 'Exportar a Excel',
                                title:     'Título del documento',
                                exportOptions: {
                                    columns: [2,3,4,5,6,7]
                                }
                        },
                        {
                                extend:    'pdfHtml5',
                                text:      'Exportar a PDF',
                                titleAttr: 'Exportar a PDF',
                                className: 'btn btn-danger',
                                title:     'Título del documento',
                                exportOptions: {
                                    columns: [2,3,4,5,6,7]
                                }                    
                        },
                        {
                                extend:    'print',
                                text:      'Imprimir',
                                titleAttr: 'Imprimir',
                                className: 'btn btn-info',
                                exportOptions: {
                                    columns: [2,3,4,5,6,7]
                                }
  
                        }
                ],
                pageLength : 100,
                lengthMenu: [[-1], ['Todos']],
                ordering: true,  
                rowCallback:function(row,data){
                    if(data[0] == "M")
                    {
                        $($(row).find("td")[0]).css("background-color","orange");
                    }
                    if(data[0] == "P"){
                        $($(row).find("td")[0]).css("background-color","blue");
                    }
                    if(data[0] == "N"){
                        $($(row).find("td")[0]).css("background-color","gray");
                    }
                    if(data[0] == "R"){
                        $($(row).find("td")[0]).css("background-color","green");
                    }
                    if(data[0] == "A"){
                        $($(row).find("td")[0]).css("background-color","beige");
                    }
                    if(data[0] == "S"){
                        $($(row).find("td")[0]).css("background-color","red");
                    }
                }
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
                $cons = mysqli_query($conSanatorio, "SELECT * FROM motivosuspension WHERE Estado = 1");
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