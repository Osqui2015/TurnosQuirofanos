<?php

header('Content-Type: text/html; charset=UTF-8');

session_start();

$DateAndTime = date('Y-m-d', time());  
require_once "../../conSanatorio.php";
$menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden");  //order by Orden 
$cons = mysqli_query($conSanatorio, "SELECT * FROM motivosuspension ");
/* echo $_SESSION['matricula'];

$matricula = $_SESSION['matricula']; VALOR MATRICULA */


/*$query = mysqli_query($conSanatorio, "SELECT tq.Estado AS Estado,
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
                                        SUBSTRING(pa.Descripcion,1,90) AS DescriPractica,
                                        pr.Nombre AS DocNombre,
                                        q.Descripcion AS quirdes,
                                        q.orden AS orden,
                                        tq.Arco AS Arco,
                                        tq.Uti AS  Uti ,
                                        tq.laparoscopica AS  laparoscopica ,
                                        tq.forcetriad_propio AS  forcetriad_propio ,
                                        tq.forcetriad AS forcetriad 
                                        FROM turnosquirofano AS tq 
                                        INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                        INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
                                        INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                        INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
                                        WHERE Fecha = '$DateAndTime'
                                        AND tq.Estado = 'PENDIENTE'        
                                        GROUP BY tq.numero
                                        ORDER BY Fecha,orden, HoraInicio"
                                        );*/



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
tq.DNIPaciente AS dniP,
tq.ObraSocial AS Ob,
SUBSTRING(pa.Descripcion,1,90) AS DescriPractica,
pr.Nombre AS DocNombre,
q.Descripcion AS quirdes,
q.orden AS orden,
tq.Arco AS Arco,
tq.Uti AS  Uti ,
tq.laparoscopica AS  laparoscopica ,
tq.forcetriad_propio AS  forcetriad_propio ,
tq.forcetriad AS forcetriad 
FROM turnosquirofano AS tq 
INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
WHERE Fecha = '$DateAndTime'
AND tq.Estado = 'PENDIENTE'        
GROUP BY tq.numero
ORDER BY Fecha,orden, HoraInicio"); 

$n= 1;
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todos Los Turnos</title>
<style>
    
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

    
</style> 
<?php  include_once "dependencias.php" ?>
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
    <!–– Principal -->            
            <!–– menu -->
             <?php  include_once "menuGerente.php" ?>
             
            <!–– fin menu -->
    <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
        <!--- TABLA Detalle---------------------------------> 

            <!–– Principal -->

        <br>            
            <div class="row justify-content-center"> <!-- Tabla Imagen-->                 
                <div class="card text-center " style="width: 60rem;">                    
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md">
                                    <h5 class="card-title">Fecha: </h5>
                                </div>
                                <div class="col-md">
                                    <input type="date" class="form-control" id="fecha" name="fecha" onchange = "VerTodosTurnos()" required>
                                </div>
                                <div class="col-md">
                                    <h5 class="card-title">Quirofano:</h5>
                                </div>
                                <div class="col-md">
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
                <div class="card" style="width: 50rem; height: 35rem;">
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
                    <div class="table-responsive">
                        <table class="table" id="example">
                            <thead>
                            <tr class="bg-light text-dark">
                            <th scope="col">Estado</th> 
                            <th scope="col">Num</th>
                            <th scope="col"> </th>
                            <th>Quirofano</th>                                       
                            <th>Fecha</th>
                            <th>Hora Inicio</th> 
                            <th>Hora Fin</th>     
                            <th>Paciente</th>
                            <th>DNI</th>  
                            <th>Obra Social</th>                              
                            <th>Doctor</th>
                            <th>Práctica</th>
                            <th>Arco</th>
                            <th>Uti</th>
                            <th>Laparoscopica</th>
                            <th>forcetriad propio</th>
                            <th>forcetriad</th>
                                
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
                                        
                                        <td> <?php echo $row['Estado']?> </td>
                                        <td> <?php echo $n++; ?> </td>
                                        <td>        
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalCenter" onclick="Sus(<?php echo $row['numero']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspender" > <img  src="../../images/file-x.svg"> </button> 
                                            <button type="button" class="btn btn-warning btn-sm" onclick="Modificar(<?php echo $row['numero']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar"> <img  src="../../images/pencil-square.svg"></img> </button> 
                                        </td>
                                        <td> <small> <?php echo $row['quirdes']; ?></small></td>
                                        <td>    <?php 
                                                        $date = substr($row['Fecha'], 0, -9);
                                                        $newDate = date("d-m-Y", strtotime($date));
                                                        echo $newDate;
                                                ?> 
                                        </td>
                                        <td> <?php echo $row['HoraInicio'] ?> </td>
                                        <td> <?php echo $row['HoraFin'] ?> </td>
                                        <td> <?php echo $row['Paciente'] ?> </td>
                                        <td> <?php echo $row['dniP'] ?> </td>
                                        <td> <?php echo $row['Ob'] ?> </td>
                                        <td> <?php echo utf8_encode($row['DocNombre']) ?> </td>
                                        <td> <?php echo utf8_encode($row['DescriPractica']) ?> </td>
                                        <td> <?php echo $row['Arco'] ?> </td>
                                        <td> <?php echo $row['Uti'] ?> </td>
                                        <td> <?php echo $row['laparoscopica'] ?> </td>
                                        <td> <?php echo $row['forcetriad_propio'] ?> </td>
                                        <td> <?php echo $row['forcetriad'] ?> </td>


                                        
                                        
                                    </tr>
                                    <?php
                                    }//Fin while
                                // }
                                    }//Fin if   
                                    mysqli_close($conSanatorio); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        -->
    </div>
    <!–– Fin Principal -->
    
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
    <script src="funciones.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({ 
                "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                pageLength : 100,
                dom: "Bfrtip",
                            buttons: [
                                {
                                    extend: "excel",
                                    split: [ "pdf", "print"],
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
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
      <li class="list-inline-item"><span id="selectSuspen" ></span></li>
            <?php 
                /// echo $conSanatorio;
                // $cons = mysqli_query($conSanatorio, "SELECT * FROM motivosuspension ");
            ?>
            <label>Motivo de la Suspensión</label>
            <select class="form-control" id="motivo_suspension">
                <option value="0">Seleccione un motivo</option>
                <?php while($row = mysqli_fetch_array($cons)){ ?>
                    <option value="<?php echo $row['Motivo'] ?>"><?php echo  utf8_encode($row['Descripcion']) ?></option>
                <?php } ?>
            </select>
           
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