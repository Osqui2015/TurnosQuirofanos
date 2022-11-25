<?php
session_start();
// echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
require_once "../../conSanatorio.php";
$menuQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden"); //order by Orden 




$fechaSelec = $_POST['fecha'];
$menQuirofano = $_POST['menuQuirofano'];

if ($menQuirofano == 00){
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
    q.Descripcion AS quirdes
    FROM turnosquirofano AS tq 
    INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
    INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
    INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
    INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
    WHERE Fecha = '$fechaSelec'
    AND Estado = 'Pendiente'
    GROUP BY tq.numero
    ORDER BY numero DESC");
}else{
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
    q.Descripcion AS quirdes
    FROM turnosquirofano AS tq 
    INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
    INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
    INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
    INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
    WHERE Fecha = '$fechaSelec'
    AND Estado = 'Pendiente'
    AND q.numero = $menQuirofano
    GROUP BY tq.numero
    ORDER BY numero DESC");
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CONSULTA</title>
    <?php  include_once "dependencias.php" ?>
    <link rel="stylesheet" href="css.css"> <link rel="icon" href="../../imagen/modelo.jpg">
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
                <!–– Principal -->
                <div class="card-body">
                    <form method="post" action="reporteTurno.php">
                        <div class="row justify-content-center align-items-center minh-100">                   
                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Fecha</h5>
                                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Seleccione Quirofano</h5>
                                        <select  class="custom-select" name="menuQuirofano">
                                            <option value=""></option>
                                            <option value="00">TODOS</option>
                                            <?php 
                                                while($row=mysqli_fetch_array($menuQuirofano)) {
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
                                    </div>
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
                
                <div class="card text-center">
                    <div class="card-header">
                        FECHA: <?php echo $fechaSelec; ?>
                    </div>
                    <div class="card-body">
                        <table class="display compact table table-hover table-condensed" id="example">
                            <thead>
                                <tr class="bg-info">
                                    <th><small>E</small></th>                   
                                    <th>Dia</th>
                                    <th>Fecha</th>
                                    <th>Desde</th> 
                                    <th>Hasta</th> 
                                    <th>Paciente</th> 
                                    <th>Práctica</th>
                                    <th>Doctor</th>
                                    <th>Quirofano</th> 
                                                    
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
                                        <td> <small> <?php echo $row['quirdes']; ?></small></td>
                                    </tr>
                                    <?php
                                    }//Fin while
                                // }
                                    }//Fin if   
                                    mysqli_close($conSanatorio); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-muted">
                        2 days ago
                    </div>
                </div>
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>
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
</html>