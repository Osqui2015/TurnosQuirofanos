<?php

header('Content-Type: text/html; charset=UTF-8');

session_start();


require_once "../../conSanatorio.php";
$menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden");  //order by Orden 
/* echo $_SESSION['matricula'];

$matricula = $_SESSION['matricula']; VALOR MATRICULA */

require_once "../../conSanatorio.php";
$query = mysqli_query($conSanatorio, "SELECT tq.Estado AS Estado,
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
    pr.Nombre AS DocNombre,
    q.Descripcion AS quirdes,
    q.orden AS orden
    FROM turnosquirofano AS tq 
    INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
    INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
    INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
    INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
    WHERE Fecha = CURDATE ()
    AND tq.Estado <> 'Modificado'
    GROUP BY tq.numero
    ORDER BY Fecha,orden, HoraInicio");

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todos Los Turnos</title>
<!-- <style>
    
    .tooltip {

    left: 30%;
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

    
</style> -->
<?php  include_once "dependencias.php" ?>
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
    <!–– Principal -->            
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
    <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
        <!--- TABLA Detalle---------------------------------> 

            <!–– Principal -->

        <br>            
            <div class="mx-auto" style="width: 1100px;"> <!-- Tabla Imagen-->                 
                <div class="card text-center">                    
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">Fecha: </h5>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" id="fecha" name="fecha" onchange = "VerTodosTurnos()" required>
                                </div>
                                <div class="col">
                                    <h5 class="card-title">Quirofano:</h5>
                                </div>
                                <div class="col">
                                    <select  class="custom-select" name="menuQuirofano" id="menuQuirofano" onchange = "VerTodosTurnos()">
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
                        </form> 
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
            </div>         <br>

        

        <div class="card">
            <div class="card-body">
                <div id='TodosTurnos'>
                                   
                </div>
            </div>
        </div>


        <!--
        <div class="card"> 
            <div class="card-header">
                    <h5> Fecha: <?php $DateAndTime = date('d-m-Y', time());  echo $DateAndTime ?> </h5>
            </div>
            <div class="table-responsive">
                <table class="display compact table table-condensed table-striped table-bordered table-hover" id="example">
                    <thead>
                        <tr class="bg-light text-dark">
                            <th scope="col"><small>E</small></th> 
                            <th>Quirofano</th>                                       
                            <th>Fecha</th>
                            <th>Desde</th> 
                            <th>Hasta</th> 
                            <th>Paciente</th> 
                            <th>Práctica</th>
                            <th>Doctor</th>                                                                        
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
                                <td> <small> <?php echo $row['quirdes']; ?></small></td>
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
                                        <?php echo $row['Paciente'] ?>
                                        <span class="tooltip">  <u><b> Datos del Pasiente: </b></u> <br>
                                                                <b> DNI: </b> <?php echo $r['DniPaciente']?> <br>
                                                                <b>Telefono:</b> <?php echo $r['Telefono']?> <br>
                                                                <b>ObraSocial:</b> <?php echo $r['ObraSocial']?> <br>
                                        </span>
                                    </div>
                                </td>
                                <td> <small> <?php echo utf8_encode($row['DescriPractica']) ?></small></td>
                                <td> <small> <?php echo $row['DocNombre']; ?></small></td>
                                
                            </tr>
                            <?php
                            }//Fin while
                        // }
                            }//Fin if   
                            mysqli_close($conSanatorio); ?>
                    </tbody>
                </table>
                <br>
                <br>
            </div>  
        </div>
        -->
    </div>
    <!–– Fin Principal -->
    
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
    <script src="funcionesNueva.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({ 
                "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                fixedHeader: {
                    header: true,
                    footer: true,
                },                            
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