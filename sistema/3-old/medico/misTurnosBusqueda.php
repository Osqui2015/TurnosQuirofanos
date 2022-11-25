<!---CONECION Y BUSQUEDA--->
<?php

    header('Content-Type: text/html; charset=UTF-8');

    session_start();

    // echo $_SESSION['matricula'];

    $matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
    $fechaSelec = $_POST['fecha'];
    $menQuirofano = $_POST['menuQuirofano'];
    $nom = $_POST['nom'];
    
    require_once "../../conSanatorio.php";
    $menQuirofanos = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden"); //order by Orden 
    // 1-1-1
    if (!empty($fechaSelec) && !empty($menQuirofano) && !empty($nom) ) {
        if ($menQuirofano == 00){
            $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
            tq.numero AS numeroT,
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
            q.Descripcion AS quirdes,
            tq.nombre,
            q.numero
            FROM turnosquirofano AS tq 
            INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
            INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
            INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
            INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
            WHERE MatriculaProfesional= $matricula
            AND tq.nombre LIKE '%$nom%'
            AND tq.Estado <> 'Modificado'
            AND Fecha = '$fechaSelec'
            GROUP BY tq.numero
            ORDER BY Fecha, HoraInicio;");
        }else{
            $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
            tq.numero AS numeroT,
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
            q.Descripcion AS quirdes,
            tq.nombre,
            q.numero
            FROM turnosquirofano AS tq 
            INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
            INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
            INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
            INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
            WHERE MatriculaProfesional= $matricula
            AND tq.nombre LIKE '%$nom%'
            AND tq.Estado <> 'Modificado'
            AND q.numero = $menQuirofano
            AND Fecha = '$fechaSelec'
            GROUP BY tq.numero
            ORDER BY Fecha, HoraInicio;");
        }
    }
    // 1-0-0
    if (!empty($fechaSelec) && empty($menQuirofano) && empty($nom) ) {
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
        tq.numero AS numeroT,
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
        q.Descripcion AS quirdes,
        tq.nombre,
        q.numero
        FROM turnosquirofano AS tq 
        INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
        INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
        INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
        INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
        WHERE MatriculaProfesional= $matricula
        AND tq.Estado <> 'Modificado'  
        AND Fecha = '$fechaSelec'
        GROUP BY tq.numero
        ORDER BY Fecha, HoraInicio;");
    }
    // 1-1-0
    if (!empty($fechaSelec) && !empty($menQuirofano) && empty($nom) ) {
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
        tq.numero AS numeroT,
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
        q.Descripcion AS quirdes,
        tq.nombre,
        q.numero
        FROM turnosquirofano AS tq 
        INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
        INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
        INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
        INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
        WHERE MatriculaProfesional= $matricula        
        AND tq.Estado <> 'Modificado'
        AND fecha = '$fechaSelec'
        AND q.numero = $menQuirofano
        GROUP BY tq.numero
        ORDER BY Fecha, HoraInicio;");
    }
    // 1-0-1
    if (!empty($fechaSelec) && empty($menQuirofano) && !empty($nom) ) {
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
        tq.numero AS numeroT,
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
        q.Descripcion AS quirdes,
        tq.nombre,
        q.numero
        FROM turnosquirofano AS tq 
        INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
        INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
        INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
        INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
        WHERE MatriculaProfesional= $matricula
        AND tq.nombre LIKE '%$nom%'
        AND tq.Estado <> 'Modificado'  
        AND Fecha = '$fechaSelec'
        GROUP BY tq.numero
        ORDER BY Fecha, HoraInicio;");
    }
    // 0-1-0
    if (empty($fechaSelec) && !empty($menQuirofano) && empty($nom) ) {
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
        tq.numero AS numeroT,
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
        q.Descripcion AS quirdes,
        tq.nombre,
        q.numero
        FROM turnosquirofano AS tq 
        INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
        INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
        INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
        INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
        WHERE MatriculaProfesional= $matricula        
        AND tq.Estado <> 'Modificado'
        AND q.numero = $menQuirofano
        GROUP BY tq.numero
        ORDER BY Fecha, HoraInicio;");
    }
    // 0-1-1
    if (empty($fechaSelec) && !empty($menQuirofano) && !empty($nom) ) {
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
        tq.numero AS numeroT,
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
        q.Descripcion AS quirdes,
        tq.nombre,
        q.numero
        FROM turnosquirofano AS tq 
        INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
        INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
        INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
        INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
        WHERE MatriculaProfesional= $matricula
        AND tq.nombre LIKE '%$nom%'
        AND tq.Estado <> 'Modificado'
        AND q.numero = $menQuirofano
        GROUP BY tq.numero
        ORDER BY Fecha, HoraInicio;");
    }
    // 0-0-1
    if (empty($fechaSelec) && empty($menQuirofano) && !empty($nom) ) {
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
        tq.numero AS numeroT,
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
        q.Descripcion AS quirdes,
        tq.nombre
        FROM turnosquirofano AS tq 
        INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
        INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
        INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
        INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
        WHERE MatriculaProfesional= $matricula
        AND tq.nombre LIKE '%$nom%'
        AND tq.Estado <> 'Modificado'
        GROUP BY tq.numero
        ORDER BY Fecha, HoraInicio;");
    }
    // 0-0-0
    if (empty($fechaSelec) && !empty($menQuirofano) && !empty($nom) ) {
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado,
            tq.numero AS numeroT,
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
            AND tq.Estado <> 'Modificado'
            AND Fecha >= CURDATE() 
            GROUP BY tq.numero
            ORDER BY Fecha, HoraInicio;"); 
    }    
    
    
    
    

?>
<!--------------------------------------------------------------------------->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Turnos Quirofanos</title>
    
   

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
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
<!--- TABLA Detalle--------------------------------->  
    <div class="table-responsive">
        <div class="alert alert-info" role="alert">             
            <h4>
                <span class="badge badge-primary"><FONT SIZE=5>Pendiente</FONT></span>
                <span class="badge badge-secondary "><FONT SIZE=5>No Realizado</FONT></span>
                
                <span class="badge badge-success"><FONT SIZE=5>Realizado</FONT></span>            
                <span class="badge badge-danger"><FONT SIZE=5>Suspendido</FONT></span>
            <!--- <span style="background-color:#E64A19;"><b class="text-white">ㅤSuspendidoㅤ</b></span>---->
            </h4>
                <!–– Principal -->
                    <div class="card-body">
                    <form method="post" action="misTurnosBusqueda.php">
                        <div class="row justify-content-center align-items-center minh-100">                   
                            
                                <div class="card">
                                    <div class="card-body">

                                    <ul class="list-group list-group-horizontal-sm">
                                        <li class="list-group-item border-0">
                                            Fecha:
                                        </li>
                                        <li class="list-group-item border-0">
                                            <input type="date" class="form-control" id="fecha" name="fecha">
                                        </li>
                                        <li class="list-group-item border-0">
                                            Seleccione Quirofano
                                        </li>
                                        <li class="list-group-item border-0">
                                            <select  class="custom-select" name="menuQuirofano">
                                                <option value=""></option>
                                                <option value="00">TODOS</option>
                                                <?php 
                                                    while($row=mysqli_fetch_array($menQuirofanos)) {
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
                                        </li>
                                        <li class="list-group-item border-0">
                                            Paciente:
                                        </li>
                                        <li class="list-group-item border-0">
                                            <input type="text" class="form-control" id="nom" name="nom">
                                        </li>                                        
                                    </ul>

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
        <table class="display compact table table-hover table-condensed" id="misTurnos">
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
                                    $newDate = date("d/m/Y", strtotime($date));
                                    echo $newDate;
                                ?> 
                        </td>
                        <td> <?php echo $row['HoraInicio'] ?> </td>
                        <td> <?php echo $row['HoraFin'] ?> </td>
                        <td> 
                            <?php 
                                $numero_turno = $row['numeroT']; 
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
                                 <button type="button" class="btn btn-warning btn-sm" onclick="Modificar(<?php echo $numero_turno ?>)"> <img  src="../../images/pencil-square.svg"></img> </button> 
                                <!--<button type="button" class="btn btn-warning btn-sm" onclick="ModificarError(<?php echo $row['numero']?>)"> <img  src="../../images/pencil-square.svg"></img> </button>-->
                            </td>
                            <td>   
                                <!-- <button type="button" class="btn btn-danger btn-sm" onclick="Suspenderr(<?php echo $row['numero']?>)"> <img  src="../../images/x-octagon-fill.svg"></img> </button> ---    -->

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" onclick="Sus(<?php echo $row['numero']?>)" >
                                    x
                                </button>
                                
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


<!--- TABLA PRINCIPAL--------------------------------->
    </div>
    <!–– Fin Principal -->
    </div>
        
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
    

    <script src="funciones.js"></script>
    <script type="text/javascript">
        
        $(document).ready(function() {
            $('#misTurnos').DataTable({  
                "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                fixedHeader: {
                    header: true,
                    footer: true,
                },
                columnDefs: [ {
                    targets: 2,
                    render: $.fn.dataTable.render.moment( 'DD/MM/YYYY', 'DD-MM-YYYY' )
                } ],
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



<!-- Button trigger modal -->


<!-- Modal -->
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