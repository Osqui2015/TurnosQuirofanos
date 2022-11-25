<!---CONECION Y BUSQUEDA--->
<?php

header('Content-Type: text/html; charset=UTF-8');

session_start();

// echo $_SESSION['matricula'];

$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/

require_once "../../conSanatorio.php";
$query = mysqli_query($conSanatorio, "SELECT tq.Estado as Estado,
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
DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fechas, 
DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin, 
LTRIM(RTRIM(tq.Nombre)) AS Paciente, 
SUBSTRING(pa.Descripcion,1,50) AS DescriPractica,
pr.Nombre as DocNombre,
q.Descripcion AS quirdes
FROM turnosquirofano AS tq 
INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
WHERE YEAR(Fecha) >= YEAR(CURDATE())
and Estado = 'Pendiente'
GROUP BY tq.numero
ORDER BY numero DESC;");

?>
<!--------------------------------------------------------------------------->
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
<body>
    <!–– Principal -->            
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <div class="jumbotron">
    <!–– Principal -->

<!--- TABLA Detalle-------------------------
<div class="row justify-content-md-center"> 
			<div class="col-8">
				<div class="text-muted">
					Busqueda Avanzada
				</div>
				<div class="row">
					<div class="col-md-5">
						<select class="form-control" id="select-column">
							<option selected value="5">Nombre Paciente</option>
							<option value="2"> Fecha</option>							
						</select>
					</div>
					<div class="col-md-7">
						<input class="form-control" type="text" id="search-by-column" placeholder="Cuadro de Busqueda">
					</div>
				</div>
			</div>
		</div>-------->  
<br>

<!--- TABLA Detalle---------------------------------> 
    <div class="card-body">
<!--- TABLA Detalle--------------------------------->  
    <div class="table-responsive">
        <table class="display compact table table-hover table-condensed" id="example" style="width:100%">
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
                        <td> <?php echo $row['Fechas']?> </td>
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
        <br>
        <br>
    </div>  
<!--- TABLA PRINCIPAL--------------------------------->
    </div>
    <!–– Fin Principal -->
    </div>
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
    <script src="funciones.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
           $('#example').DataTable({ 
                 
               /* dom: 'Plfrtip',
                
                columnDefs: [
                    {
                        searchPanes: {
                            show: false
                        },
                        targets: [0,1,3,4,6]
                    },
                    {
                        searchPanes: {
                            show: true
                        },
                        targets: [2,5,7,8]
                    }
                ], */


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
                }}
            });
        });
    </script>
</body>
</html>