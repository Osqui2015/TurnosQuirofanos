<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../login.php');
}

require_once "../../conSanatorio.php";

$menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden");

$numero = $_GET["num"];
$userr = $_SESSION['usuario']; 

$consl = mysqli_query($conSanatorio,"SELECT * FROM turnosquirofano AS tq
                                    INNER JOIN Quirofanos AS q
                                    ON tq.Quirofano = q.Numero
                                    WHERE  tq.numero = $numero"); 
while($mod=mysqli_fetch_array($consl)) {
    $matricula = $mod['MatriculaProfesional'];
    $numQ = $mod['Quirofano'];
    $descQ = $mod['Descripcion'];
    $fechaQ = $mod['Fecha'];
    $horaI = $mod['HoraInicio'];
    $horaF = $mod['HoraFin'];
    $aneQ = $mod['Anestesista'];
    $tareaQ = $mod['DescripcionCirugia'];
    $dniQ = $mod['DNIPaciente'];
    $dniTQ = $mod['TipoDocumentoIdentidad'];
    $nombreQ = $mod['Nombre'];
    $telefonoQ = $mod['Telefono'];
    $obraSocialNom = $mod['ObraSocial'];
    $obraSocialQ = $mod['CodigoObraSocial'];
    $rxQ = $mod['RX'];
    $sangreQ = $mod['Sangre'];
    $monitoreoQ = $mod['Monitoreo'];
    $arco = $mod['Arco'];
    $forceS = $mod['ForceTriad'];
    $uti = $mod['Uti'];
    $laparo = $mod['Laparoscopica'];
    $intruPro = $mod['Instrumentista_Propio'];
    $insumo = $mod['InsumosNoHabituales'];
    $email = $mod['Email'];
    $forceP = $mod['ForceTriad_Propio'];
    $InterAmbu = $mod['ParaInternar'];
}

 $numeroQuirofano = $numQ;

$prac = mysqli_query($conSanatorio,"SELECT * 
                                    FROM turnosquirofanospracticas AS tqp
                                    INNER JOIN practicasquirofano AS pq ON tqp.CodigoPractica = pq.Codigo
                                    WHERE tqp.Numero = $numero");
$cod1Q = array();
$desc1Q = array();
$cont = 0;
$cod1Q[1]  = " ";
$desc1Q[1] = " ";
$cod1Q[2] = " ";
$desc1Q[2] = " ";
while ($verConfig  = mysqli_fetch_array($prac)) {
					$cod1Q[$cont] = $verConfig["Codigo"];  
					$desc1Q[$cont] = $verConfig["Descripcion"];  
					$cont++;
		        }


require_once "../../conSanatorio.php";
    $pp = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo, TiempoEstimado 
                                    FROM practicasquirofano
                                    WHERE web = 0 AND TiempoEstimado > 0 AND codigo = '$cod1Q[0]'");


while($mod = mysqli_fetch_array($pp)) {                   
    $tiempoQ = $mod['TiempoEstimado'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modificar Turno</title>
    <?php  include_once "dependencias.php" ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="css.css"> <link rel="icon" href="../../imagen/modelo.jpg">
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body onload="HoraInicioTurnoModificar()">
    
<input hidden = "" id="vUserr" value = "<?php echo $userr; ?>"> </input> <!-- USUARIO -->
<input id="vMatricula" value = "<?php echo $matricula; ?>" hidden="">  </input> <!-- MATRICULA -->
<input id="NumReg" value = "<?php echo $numero; ?>" hidden="">  </input> <!-- registro -->
<input id="Cpra" value = "<?php echo $cod1Q[0] ?>"  hidden="">  </input> <!-- MATRICULA -->

            <!-- menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <div >
                <!–– Principal -->
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne" style="background-color:#03588C;">                    
                            <a class="btn btn-block text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4>MODIFICAR TURNO DE QUIROFANO</h4>
                            </a>                        
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body"> 
                                <ul class="list-group list-group-horizontal-lg"> <!-- Nuevo Turno Quirofano -->
                                    <li class="list-group-item border-0"><h5>ㅤㅤㅤㅤ</h5></li>
                                    <li class="list-group-item border-0"><h5>Fecha</h5></li>
                                        <li class="list-group-item border-0">
                                            <input onchange="fechaTurno()" type="date" name="fechaSelec" id="fechaSelec" placeholder="Introduce una fecha" value="<?php echo substr($fechaQ , 0, -9)?>" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> />
                                            <span id="selecFecha" hidden = ""></span> <!-- VALOR FECHA -->
                                            <script>
                                                $('#menuQuirofano').on('change', function(){
                                                    var valor = this.value;
                                                    $('#selecFecha').text(valor);
                                                    if ($(this).val() === "") {
                                                        $("#fechaSelec").prop("disabled", true);
                                                    } else {
                                                        $("#fechaSelec").prop("disabled", false);

                                                    }                                                                                                 
                                                })                                            
                                            </script>
                                        </li>
                                    <li class="list-group-item border-0"><h5>Quirofano</h5></li>
                                        <li class="list-group-item border-0">                                            
                                            <select  onchange="QuirModi()" class="custom-select" required id="menuQuirofano">                            
                                                <?php                             
                                                    while($row=mysqli_fetch_array($menQuirofano)) {                                                                        
                                                    if ($numeroQuirofano == $row['Numero']){
                                                ?>
                                                    <option id="selqui" value="<?php echo $row['Numero']?>" selected="selected"> <?php echo $row['Descripcion']?> </option>
                                                <?php }else{?>
                                                    <option id="selqui" value="<?php echo $row['Numero']?>" > <?php echo $row['Descripcion']?> </option>
                                                <?php }}?>
                                            </select>
                                            <span id="selectMenuQuirofano" hidden = "" ></span> <!-- VALOR DEL QUIROFANO -->
                                            <script>
                                                $('#menuQuirofano').on('change', function(){
                                                    var valor = this.value;
                                                    $('#selectMenuQuirofano').text(valor);
                                                    fechaTurno();
                                                    HoraInicioTurnoModificar();
                                                })
                                            </script>
                                        </li>
                                    <li class="list-group-item border-0"><h5>Practicas</h5></li>
                                    <li class="list-group-item border-0"> <!-- PRACTICA 1 -->
                                        <div class="table-responsive-md">
                                            <select class="js-pra1-codigo" name="state" id="codPrac1" onchange = "practicaUno()">                                                
                                                <?php 
                                                    $pracBusc1 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo, SUBSTRING(Descripcion,1,50) AS Descripcion2, Descripcion, TiempoEstimado 
                                                    FROM practicasquirofano
                                                    WHERE web = 0 AND TiempoEstimado > 0");
                                                    while($row=mysqli_fetch_array($pracBusc1)) {
                                                        if ($cod1Q[0] == $row['Codigo']){ ?>
                                                            <option value="<?php echo utf8_encode($row['Codigo']) ?>" selected="selected"> <?php echo utf8_encode($row['Codigo']) ?>ㅤㅤㅤㅤ ||ㅤㅤㅤㅤ <?php echo utf8_encode(substr($row['Descripcion'], 0, 60));  ?></option>
                                                    <?php }else{ ?>
                                                            <option value="<?php echo utf8_encode($row['Codigo']) ?>"> <?php echo utf8_encode($row['Codigo']) ?>ㅤㅤㅤㅤ ||ㅤㅤㅤㅤ <?php echo utf8_encode(substr($row['Descripcion'], 0, 60));  ?></option>
                                                    <?php } ?>                                                        
                                                <?php }?>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0">
                                        <button id="mostrar2" type="button" class="btn btn-success"><i class="bi bi-plus-circle-fill">+</i></button>
                                    </li>
                                    <li class="list-group-item border-0"><h5></h5></li>
                                </ul>
                                <div id ="pr2" style="display: none">
                                    <ul  class="list-group list-group-horizontal-lg" > <!-- PRACTICA 2-->
                                        <li class="list-group-item border-0"><h5>ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</h5></li>
                                        <li class="list-group-item border-0"><h5>Practicas 2</h5></li>
                                        <li class="list-group-item border-0">
                                            <div class="table-responsive-md">
                                                <select class="js-pra2-codigo" name="state" id="codPrac2">
                                                    <option value="">ㅤCODIGOㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ DESCRIPCIONㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</option>
                                                    <?php 
                                                        $pracBusc1 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo, SUBSTRING(Descripcion,1,50) AS Descripcion2, Descripcion, TiempoEstimado 
                                                        FROM practicasquirofano
                                                        WHERE web = 0 AND TiempoEstimado > 0");
                                                        while($row=mysqli_fetch_array($pracBusc1)) {
                                                    ?>
                                                            <option value="<?php echo utf8_encode($row['Codigo']) ?>"> <?php echo utf8_encode($row['Codigo']) ?>ㅤㅤㅤㅤ ||ㅤㅤㅤㅤ <?php echo utf8_encode(substr($row['Descripcion'], 0, 60));  ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <button id="mostrar3" type="button" class="btn btn-success"><i class="bi bi-plus-circle-fill">+</i></button>
                                        </li>
                                        <li class="list-group-item border-0">
                                            <button id="cerrar2" type="button" class="btn btn-danger"><i class="bi bi-plus-circle-fill">x</i></button>
                                        </li>
                                    </ul>
                                </div>
                                <div id ="pr3" style="display: none">
                                    <ul  class="list-group list-group-horizontal-lg"> <!-- PRACTICA 3-->
                                        <li class="list-group-item border-0"><h5>ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</h5></li>
                                        <li class="list-group-item border-0"><h5>Practicas 3</h5></li>
                                        <li class="list-group-item border-0">
                                            <div class="table-responsive-md">
                                                <select class="js-pra3-codigo" name="state" id="codPrac3" >
                                                    <option value="">ㅤCODIGOㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ DESCRIPCIONㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</option>
                                                    <?php 
                                                        $pracBusc1 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo, SUBSTRING(Descripcion,1,50) AS Descripcion2, Descripcion, TiempoEstimado 
                                                        FROM practicasquirofano
                                                        WHERE web = 0 AND TiempoEstimado > 0");
                                                        while($row=mysqli_fetch_array($pracBusc1)) {
                                                    ?>
                                                            <option value="<?php echo utf8_encode($row['Codigo']) ?>"> <?php echo utf8_encode($row['Codigo']) ?>ㅤㅤㅤㅤ ||ㅤㅤㅤㅤ <?php echo utf8_encode(substr($row['Descripcion'], 0, 60));  ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0">ㅤ ㅤ</li>
                                        <li class="list-group-item border-0">
                                            <button id="cerrar3" type="button" class="btn btn-danger"><i class="bi bi-plus-circle-fill">x</i></button>
                                        </li>
                                    </ul>
                                </div>
                                            <script type='text/JavaScript'>                                                
                                                $( "#mostrar2" ).click(function() {
                                                    document.getElementById("pr2").style.display = "block";
                                                });
                                                $( "#mostrar3" ).click(function() {
                                                    document.getElementById("pr3").style.display = "block";
                                                });
                                                $( "#cerrar2" ).click(function() {
                                                    document.getElementById("pr2").style.display = "none";
                                                });
                                                $( "#cerrar3" ).click(function() {
                                                    document.getElementById("pr3").style.display = "none";
                                                });
                                            </script>
                                <br>
                                <ul class="list-group list-group-horizontal-xl"> <!-- Tabla de Turnos Ocupados--> 
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-group-item border-0">
                                        <div class="accordion" id="cImg"> <!-- Tabla de Turnos Ocupados--> 
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
                                    </li>                                    
                                </ul>
                                <ul class="list-group list-group-horizontal-xl">
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-group-item border-0">
                                        <div class="accordion" id="cTurnosc">
                                            <div class="card">
                                                <div class="card-header" id="headingOne">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#cTurnos" aria-expanded="true" aria-controls="cTurnos">
                                                        Mostrar / Ocultar
                                                    </button>
                                                </h2>
                                                </div>

                                                <div id="cTurnos" class="collapse show" aria-labelledby="headingOne" data-parent="#cTurnosc">
                                                    <div class="card-body">
                                                        <div class="form-row" id="tabla">    <!-- Tabla de Turnos Ocupados-->                                    
                                                            <div  class="col-lg-12" style="display: block;">
                                                                    <div id="select2lista">
                                                                        <?php 
                                                                                    $turnTabla = mysqli_query($conSanatorio,"SELECT tq.Numero,tq.Estado,
                                                                                    tq.Quirofano AS NumQuir, 
                                                                                    DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
                                                                                    DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin,  
                                                                                    LTRIM(RTRIM(pr.Nombre))AS NomMedico, 
                                                                                    SUBSTRING(pa.Descripcion,1,50) AS DescriPractica,tq.Quirofano
                                                                                    FROM turnosquirofano AS tq 
                                                                                    INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                                                                    INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
                                                                                    INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                                                                    INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
                                                                                    WHERE tq.Estado = 'PENDIENTE'
                                                                                    AND tq.Fecha = '$fechaQ'
                                                                                    AND tq.Quirofano = $numQ
                                                                                    ORDER BY HoraInicio;");
                                                                                                                            
                                                                        ?> 

                                                                            <div class="table-responsive">
                                                                                <p>ㅤEstadoㅤㅤㅤㅤㅤㅤ Desde ㅤㅤㅤㅤㅤHasta ㅤㅤㅤㅤㅤㅤㅤㅤㅤProfesionalㅤㅤㅤㅤㅤㅤㅤㅤㅤ Practicaㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</p>
                                                                                <table class="table">                                                       
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th scope="col"></th>
                                                                                            <th scope="col"></th>
                                                                                            <th scope="col"></th>
                                                                                            <th scope="col"></th>
                                                                                            <th scope="col"></th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>                                                                    
                                                                                        <tr>
                                                                                            
                                                                                        <?php while($fila=mysqli_fetch_array($turnTabla)) { ?>
                                                                                            
                                                                                                <td><?php echo $fila['Estado'] ?><td>
                                                                                                <td><?php echo $fila['HoraInicio'] ?><td>
                                                                                                <td><?php echo $fila['HoraFin'] ?><td>
                                                                                                <td><?php echo $fila['NomMedico'] ?><td>
                                                                                                <td><?php echo utf8_encode($fila['DescriPractica']) ?><td>
                                                                                            </tr>
                                                                                        <?php }//Fin while ?>
                                                                                    </tbody>                                                        
                                                                                </table>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                
                                <div id='tp' class="mx-auto" style="width: 900px;">
                                    
                                </div>
                                <br>
                                <ul class="list-group list-group-horizontal-xl">
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-inline-item">Hora de Inicio Actual</li>
                                        <li class="list-inline-item col-sm-2">
                                            <input id="hiactual" class="form-control" type="text" value ='<?php echo substr($horaI , 11, -3) ?>' readonly>
                                        </li>
                                    <li class="list-inline-item">Hora de Fin Actual</li>
                                        <li class="list-inline-item col-sm-2">
                                            <input id="hfactual" class="form-control" type="text" value ='<?php echo substr($horaF , 11, -3) ?>' readonly>
                                        </li>
                                </ul>
                                <br>
                                <ul class="list-group list-group-horizontal-xl">
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-inline-item">Hora de Inicio</li>
                                    <li class="list-inline-item col-sm-2">
                                        <select id="Hinicio" class="sele custom-select" onchange="HoraFinTurnoM()" required>
                                        </select>
                                        <span id="selectHoraInicio" hidden = ""></span> <!-- valor hora inicio -->
                                        
                                    </li>
                                    <li class="list-inline-item"> <span id="selectHoraInicio" hidden = ""></span> </li>

                                    <li class="list-inline-item">Hora de Fin</li>
                                    <li class="list-inline-item col-sm-2">
                                        <input type="text" class="Hfin form-control" id="Hfin" name="Hfin" value="" readonly>
                                    </li>
                                    <li class="list-inline-item"> 
                                        <span id="selectHoraFin" class="selectHoraFinc" hidden = ""></span> 
                                    </li>

                                    <li class="list-inline-item">Agregar Tiempo</li>
                                    <li class="list-inline-item">
                                        <select class="sele custom-select" id="tiempomas" name="tiempomas" onchange="AgregarTiempoModi()">
                                            <option value="00"></option>
                                            <option value="10">10 Minutos</option>
                                            <option value="20">20 Minutos</option>
                                            <option value="30">30 Minutos</option>
                                            <option value="40">40 Minutos</option>
                                            <option value="50">50 Minutos</option>
                                            <option value="60">1 Hora</option> <!-- sumar -->
                                        </select>
                                    </li>
                                    <li class="list-inline-item"><span id="selectTiempoMas" hidden = ""></span></li>   
                                </ul>
                                <br>
                                
                                <ul class="list-group list-group-horizontal-xl">
                                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                        <li class="list-inline-item"><!-- REQUIERE ANESTESIA -->
                                            <?php  if (empty($aneQ)){ ?>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="micheckbox custom-control-input" id="customSwitch1" >
                                                    <label class="custom-control-label" for="customSwitch1"> Requiere Anestesia </label>
                                                </div>                                            
                                                <span id="selectRadioAnestesista" hidden = "">NO</span> 
                                                <input value="NO" id="selectRadioAnestesistaa" hidden=""><!-- valor Radio -->
                                                <?php }else{ ?>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="micheckbox custom-control-input" id="customSwitch1" checked>
                                                    <label class="custom-control-label" for="customSwitch1"> Requiere Anestesia </label>
                                                </div>                                            
                                                <span id="selectRadioAnestesista" hidden = "">SI</span> <!-- valor Radio -->
                                                <input value="SI" id="selectRadioAnestesistaa" hidden="">
                                            <?php  } ?>
                                        </li>
                                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                        <li class="list-inline-item"> <!-- ARCO C -->
                                            <?php  if (empty($arco) or $arco == "NO"){ ?>
                                                <div class="custom-control custom-switch">                                                            
                                                    <input type="checkbox" class="aro custom-control-input" id="aro" onchange = "ArC()">
                                                    <label class="text-dark custom-control-label" for="aro">ARCO EN C</label>
                                                </div>                                            
                                                <span id="selectAro" hidden="">NO</span> <!-- valor Radio -->
                                                <input value="NO" id="selectArcoo" hidden="">

                                                <?php }else{ ?>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="aro custom-control-input" id="aro" onchange = "ArC()" checked>
                                                        <label class="text-dark custom-control-label" for="aro">ARCO EN C</label>
                                                    </div>                                            
                                                    <span id="selectAro" hidden="">SI</span> <!-- valor Radio -->
                                                    <input value="SI" id="selectArcoo" hidden="">
                                            <?php  } ?>
                                        </li>
                                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                        <li class="list-inline-item"> <!-- UTI -->
                                            <?php  if (empty($uti) or $uti == "NO"){ ?>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="uti custom-control-input" id="customSwitch6">
                                                    <label class="text-dark custom-control-label" for="customSwitch6">Uti</label>
                                                </div>                                            
                                                <span id="selectUti" hidden="">NO</span> <!-- valor Radio -->
                                                <input value="NO" id="selectUtii" hidden="">
                                                <?php }else{ ?>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="uti custom-control-input" id="customSwitch6" checked>
                                                        <label class="text-dark custom-control-label" for="customSwitch6">Uti</label>
                                                    </div>                                            
                                                    <span id="selectUti" hidden="">SI</span> <!-- valor Radio -->
                                                    <input value="SI" id="selectUtii" hidden="">
                                            <?php  } ?> 
                                        </li>
                                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                        <li class="list-inline-item"> <!-- LAPARO -->
                                            <?php  if (empty($uti) or $uti == "NO"){ ?>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="laparo custom-control-input" id="customSwitch7">
                                                    <label class="text-dark custom-control-label" for="customSwitch7">LAPAROSCÓPICA</label>
                                                </div>                                            
                                                <span id="selectLaparo" hidden="">NO</span> <!-- valor Radio -->
                                                <input value="NO" id="selectLaparoo" hidden="">
                                            <?php }else{ ?>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="laparo custom-control-input" id="customSwitch7" checked>
                                                    <label class="text-dark custom-control-label" for="customSwitch7">LAPAROSCÓPICA</label>
                                                </div>                                            
                                                <span id="selectLaparo" hidden="">SI</span> <!-- valor Radio -->
                                                <input value="SI" id="selectLaparoo" hidden="">
                                            <?php  } ?> 
                                        </li>
                                                                                                 
                                </ul> 

                                <br>

                                <div class="mx-auto" style="width: 800px;"> <!-- FORCE TRIAD -->
                                    <ul class="list-group list-group-horizontal-xl">
                                        <?php  if ((empty($forceS) or $forceS == "NO")&&(empty($forceP) or $forceP == "NO")){ ?>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="ForP custom-control-input" id="ForP" >
                                                <label class="text-dark custom-control-label" for="ForP">FORCE TRIAD – LIGASURE (PROPIO)</label>
                                            </div> 
                                                <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                            <div class="custom-control custom-switch">                                                                                                               
                                                <input type="checkbox" class="ForS custom-control-input" id="ForS">
                                                <label class="text-dark custom-control-label" for="ForS">FORCE TRIAD – LIGASURE (SANATORIO)</label>
                                            </div> 
                                            
                                        <?php  }elseif (empty($forceS) or $forceS == "NO"){ ?>

                                            <div class="custom-control custom-switch">
                                                <input checked type="checkbox" class="ForP custom-control-input" id="ForP" >
                                                <label class="text-dark custom-control-label" for="ForP">FORCE TRIAD – LIGASURE (PROPIO)</label>
                                            </div> 
                                                <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                            <div class="custom-control custom-switch">                                                                                                               
                                                <input type="checkbox" class="ForS custom-control-input" id="ForS">
                                                <label class="text-dark custom-control-label" for="ForS">FORCE TRIAD – LIGASURE (SANATORIO)</label>
                                            </div> 
                                                                                        
                                        <?php }elseif ($forceP == "SI"){ ?>
                                            <div class="custom-control custom-switch">
                                                <input  type="checkbox" class="ForP custom-control-input" id="ForP" >
                                                <label class="text-dark custom-control-label" for="ForP">FORCE TRIAD – LIGASURE (PROPIO)</label>
                                            </div> 
                                                <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                            <div class="custom-control custom-switch">                                                                                                               
                                                <input checked type="checkbox" class="ForS custom-control-input" id="ForS">
                                                <label class="text-dark custom-control-label" for="ForS">FORCE TRIAD – LIGASURE (SANATORIO)</label>
                                            </div> 
                                            
                                            
                                        <?php  }?> 
                                            <span id="selectforceProp" hidden=""><?php echo $forceP ?></span> 
                                            <input value="<?php echo $forceP ?>" id="selectforcePropp" hidden="" >
                                            <span id="selectforceSana" hidden="" ><?php echo $forceS ?></span> 
                                            <input value="<?php echo $forceS ?>" id="selectforceSanaa"hidden=""  >
                                            
                                    </ul>
                                </div>

                                <br>
                                <div class="mx-auto" style="width: 1100px;">
                                    <div class="custom-control custom-switch">
                                        <ul class="list-group list-group-horizontal-xl">
                                            <li class="list-inline-item"> <!-- MONITOREO -->
                                                <?php  if (empty($monitoreoQ) or $monitoreoQ == "NO"){ ?>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="monitoreo custom-control-input" id="customSwitch2">
                                                        <label class="custom-control-label text-dark" for="customSwitch2">
                                                        <span class="text-dark" id="selectRadioMonitoreo">NO</span> Monitoreo Intraoperatorio</label>
                                                        <input value="NO" id="selectRadioMonitoreoo" hidden="">
                                                    </div> 
                                                    <?php }else{ ?>
                                                        <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="monitoreo custom-control-input" id="customSwitch2" checked>
                                                        <label class="custom-control-label text-dark" for="customSwitch2">
                                                        <span class="text-dark" id="selectRadioMonitoreo">SI</span> Monitoreo Intraoperatorio</label>
                                                        <input value="SI" id="selectRadioMonitoreoo" hidden="">
                                                    </div> 
                                                <?php  } ?>
                                            </li>

                                            <li class="list-inline-item">ㅤㅤㅤㅤㅤㅤㅤ</li>
                
                                            <li class="list-inline-item"> <!-- RX -->
                                                <?php  if (empty($rxQ) or $rxQ == "NO"){ ?>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="rx custom-control-input" id="customSwitch3">
                                                        <label class="text-dark custom-control-label" for="customSwitch3">
                                                        <span id="selectRadioRX" class="text-dark">NO</span> Intensificador de imagen</label>
                                                        <input value="NO" id="selectRadioRXx" hidden="">
                                                    </div>  
                                                    <?php }else{ ?>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="rx custom-control-input" id="customSwitch3" checked>
                                                            <label class="text-dark custom-control-label" for="customSwitch3">
                                                            <span id="selectRadioRX" class="text-dark">SI</span> Intensificador de imagen</label>
                                                            <input value="SI" id="selectRadioRXx" hidden="">
                                                        </div>  
                                                <?php  } ?>  
                                            </li>
                                            <li class="list-inline-item">ㅤㅤㅤㅤㅤㅤㅤ</li>

                                            <li class="list-inline-item"> <!-- SANGRE -->
                                                <?php  if (empty($sangreQ) or $sangreQ == "NO"){ ?>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="sangre custom-control-input" id="customSwitch4">
                                                        <label class="text-dark custom-control-label" for="customSwitch4">
                                                        <span class="text-dark" id="selectRadioSangre">NO</span> Sangre</label>
                                                        <input value="NO" id="selectRadioSangree" hidden="">
                                                    </div> 
                                                    <?php }else{ ?>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="sangre custom-control-input" id="customSwitch4" checked>
                                                            <label class="text-dark custom-control-label" for="customSwitch4" >
                                                            <span class="text-dark" id="selectRadioSangre">SI</span> Sangre</label>
                                                            <input value="SI" id="selectRadioSangree" hidden="">
                                                        </div>                                                         
                                                <?php  } ?> 
                                            </li>
                                            <li class="list-inline-item">ㅤㅤ</li>
                                            <li class="list-inline-item" id="TS" style="display:none;"> <!-- SANGRE -->
                                                <select class="sele custom-select" id="TSangre" name="TSangre" > 
                                                    <option value="0">Tipo de Sangre</option>
                                                    <option value="1">A positivo (A +)</option>
                                                    <option value="2">A negativo (A-)</option>
                                                    <option value="3">B positivo (B +)</option>
                                                    <option value="4">B positivo (B -)</option>
                                                    <option value="5">AB positivo (AB +)</option>
                                                    <option value="6">AB positivo (AB -)</option>
                                                    <option value="7">O positivo (O +)</option>
                                                    <option value="8">O positivo (O -)</option>
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <br>                                
                                <ul class="list-group list-group-horizontal-xl">
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <?php  if ($InterAmbu == 0 ){ ?>
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline1" name="tipocirugia" class="custom-control-input" value = 1>
                                                <label class="text-dark custom-control-label" for="customRadioInline1">Para internar</label>
                                            </div> 
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input checked type="radio" id="customRadioInline2" name="tipocirugia" class="custom-control-input" value = 0>
                                                <label class="text-dark custom-control-label" for="customRadioInline2">Ambulatorio</label>
                                            </div>
                                            <span class="text-dark" id="selectRadiotipo_cirugia" hidden=""></span>
                                            <input value="0" id="selectRadiotipo_cirugiaa" hidden="">
                                        </div>                                                    
                                    <?php } else{ ?>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input checked type="radio" id="customRadioInline1" name="tipocirugia" class="custom-control-input" value = 1>
                                                <label class="text-dark custom-control-label" for="customRadioInline1">Para internar</label>
                                            </div> 
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline2" name="tipocirugia" class="custom-control-input" value = 0>
                                                <label class="text-dark custom-control-label" for="customRadioInline2">Ambulatorio</label>
                                            </div>
                                            <span class="text-dark" id="selectRadiotipo_cirugia" hidden=""></span>
                                            <input value="0" id="selectRadiotipo_cirugiaa" hidden="">
                                        </div>                                                    
                                    <?php } ?>
                                </ul>
                                <form class="was-validated">
                                    <label for="exampleFormControlTextarea1">DIAGNOSTICO PREOPERATORIO y/o PROCEDIMIENTO A REALIZAR:</label>
                                                <textarea class="form-control is-invalid" placeholder="Deberá escribir el/los nombre de los procedimientos que realizará en el Paciente
                                                    Ej: • Hernioplastia umbilical con malla
                                                        • Osteosíntesis de fémur
                                                        • Histerectomía laparoscopica" id="tarea" rows="3" required> <?php echo $tareaQ ?> </textarea>
                                </form>                                                    
                                
                                <br>
                                <div class="col text-center" id = "dosForm">
                                    <button type="button" class="btn btn-success" onclick="confirmarM()">CONFIRMAR</button> 
                                </div> 
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingOne" style="background-color:#03588C;">                    
                            <a class="btn btn-block text-white" type="button" data-toggle="collapse" data-target="#collapseTwom" aria-expanded="true" aria-controls="collapseTwo">
                                <h5>DATOS DEL PACIENTE</h5>
                            </a>                        
                        </div> 
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-group-item border-0">
                                        <label for="">Tipo de Documento </label>
                                            <select   select class="custom-select" required id="menuDoc" required>                                                
                                                <?php 
                                                    $menuDocumento = mysqli_query($conSanatorio, "SELECT tipodocumentoidentidad AS tipo, descripcion FROM tiposdocumentoidentidad WHERE neonatologia='0'");
                                                    while($row=mysqli_fetch_array($menuDocumento)) {
                                                    if ( $dniTQ == $row['tipo']) { ?>
                                                    <option value="<?php echo $row['tipo']?>"  selected="selected" > <?php echo $row['descripcion']?> </option>  
                                                <?php }else{ ?>
                                                    <option value="<?php echo $row['tipo']?>" > <?php echo $row['descripcion']?> </option>
                                            <?php }}?>
                                            </select>
                                            <span id="selectMenuDoc" hidden=""></span><!-- VALOR DEL Documento -->
                                            <script>
                                                $('#menuDoc').on('change', function(){
                                                    var valor = this.value;
                                                    $('#selectMenuDoc').text(valor);
                                                })
                                            </script>
                                    </li>
                                    <li class="list-group-item border-0">
                                        <label for="">Numero</label>
                                        <form class="was-validated">
                                            <input type="number" maxlength="8" name="doc" class="form-control is-invalid" id="doc" value="<?php echo $dniQ ?>" onblur="buscar_datos();"  required >
                                        </form>
                                    </li>
                                    <li class="list-group-item border-0" hidden="">
                                        <label> ㅤㅤ</label>
                                        <button id="bus" type="button" class="btn btn-primary" onclick="buscar_datos();">
                                                BUSCAR
                                        </button>
                                    </li>
                                </ul>
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-group-item border-0">
                                        <label for="">Nombre y Apellido:ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</label>                                                       
                                        <INPUT required type="text" class="form-control" id="NomyApe" value="<?php echo $nombreQ ?>" > 
                                    </li>
                                    <li class="list-group-item border-0">
                                        <label for="">Teléfono:</label>
                                        <INPUT type="number" maxlength="12" type="text" class="form-control" id="tel" value="<?php echo $telefonoQ ?>" required> 
                                    </li> 
                                </ul> 
                                <ul class="list-group list-group-horizontal-md">
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-group-item border-0 col-sm-5 col-md-3" >
                                        <label for="">Email:</label>
                                        <INPUT type="email" class="form-control" id="email" value ="<?php echo $email ?>"> 
                                    </li>
                                    <li class="list-group-item border-0">
                                        <label for="">Obra Social:</label>
                                        <br>
                                            <select class="js-example-basic-single" name="state" id="menuObraSoc" >                                                                                        
                                                <?php 
                                                    $menuObraSoc = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(CodigoObraSocial)) AS Codigo,Descripcion,Deshabilitada FROM obrassociales WHERE web = '1' ORDER BY Descripcion ASC");
                                                    while($row = mysqli_fetch_array($menuObraSoc)) {
                                                ?>
                                                    <?php if ($row['Codigo'] == $obraSocialQ){?>
                                                        <option value="<?php echo utf8_encode($row['Codigo']) ?>"  selected="selected" > <?php echo utf8_encode($row['Descripcion']) ?> </option>
                                                    <?php }else{ ?>
                                                        <option value="<?php echo utf8_encode($row['Codigo']) ?>"> <?php echo utf8_encode($row['Descripcion']) ?> </option>
                                                    <?php }?>
                                                <?php }?>
                                            </select>
                                            <input id="selectObraSoc" hidden = ""> <!-- VALOR de la obra sc -->
                                            <script>                                           
                                                $('#menuObraSoc').on('change', function(){
                                                    var valor = this.value;
                                                    $('#selectObraSoc').val(valor);
                                                })                                            
                                            </script> 
                                    </li>
                                </ul>                             
                                <br>
                                <div class="col text-center" id = "dosForm">
                                    <button type="button" class="btn btn-success" onclick="PreGuardarDatos()">GUARDAR DATOS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!–– Fin Principal -->
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>
<script>
    $(document).ready(function() {
        $('#ModalBucarPractica').DataTable({ 
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });
        $('.js-example-basic-single').select2();
        $('.js-pra1-codigo').select2();
        $('.js-pra2-codigo').select2();
        $('.js-pra3-codigo').select2();        
         
    });
</script>
<script src="funcionesNueva.js"></script>
</html>