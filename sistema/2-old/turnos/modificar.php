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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo Turno</title>
    <?php  include_once "dependencias.php" ;?>
    <style>
        label {
                display: block;
                font: 1rem 'Fira Sans', sans-serif;
                }
                input,
                label {
                    margin: .4rem 0;
                }
        #close {
            float: right;
            font-weight: bold;
            color: red;
        }

        #element {
            min-height: 100px;
            box-shadow: 0 2px 5px #666666;
            padding: 10px;
        }  
        #tabla {
            min-height: 100px;
            box-shadow: 0 2px 5px #666666;
            padding: 10px;
        }  
        #content {
            margin-bottom: 25px;
        }     
    </style>
    <link rel="icon" href="../../imagen/modelo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script type="text/javascript" src="time/jquery.timepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="time/jquery.timepicker.css" />
	<script type="text/javascript" src="time/documentation-assets/bootstrap-datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="time/documentation-assets/bootstrap-datepicker.css" />
	<script type="text/javascript" src="time/documentation-assets/site.js"></script>
	<link rel="stylesheet" type="text/css" href="time/documentation-assets/site.css" />

    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
</head>
<body style="background-color:#E9ECEE;">

    <?php  include_once "menuAdmin.php" ?>
    
           
<input hidden = "" id="vUserr" value = "<?php echo $userr; ?>"> </input> <!-- USUARIO -->
<input id="vMatricula" value = "<?php echo $matricula; ?>" hidden="">  </input> <!-- MATRICULA -->
<input id="NumReg" value = "<?php echo $numero; ?>" hidden="">  </input> <!-- MATRICULA -->

<div class="card text-center">

  <div class="card-body">
        <div class="accordion" id="acorTabla">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-center" type="button" data-toggle="collapse" data-target="#cTabla" aria-expanded="true" aria-controls="cPracticas">                                            
                            Mostrar / Ocultar
                        </button>
                    </h2>
                </div>

                <div id="cTabla" class="collapse show" aria-labelledby="headingOne" data-parent="#acorTabla">
                    <div class="card-body">
                        <?php  include_once "tablaquir.php" ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <ul class="list-group list-group-horizontal-sm ">
                <li class="list-group-item border-0">
                    
                </li>
                <li class="list-group-item border-0">
                    
                    <span id="vMatricula" hidden = ""><?php echo $matricula ?> </span> <!-- MATRICULA -->
                   
                </li>
                <li class="list-group-item border-0"></li>
                <li class="list-group-item border-0"></li>
                <li class="list-group-item border-0"> <!-- PRACTICA -->
                    <fieldset class="border p-2 border">
                        <legend  class="w-auto ">Practicas</legend>
                            <div class="table-responsive">
                                <table class="table table-borderless">                                                                    
                                    <tbody>
                                        <tr>
                                            <td width="200"> 
                                                <input placeholder="Codigo" type="text" class="form-control" id="codPrac1" name="valueInput"  value="<?php echo $cod1Q[0] ?> " readonly>
                                            </td>
                                            <td width="900">
                                                <input placeholder="Descripcion" type="text" class="form-control" id="codDesc1" name="valueInput" value="<?php echo utf8_encode($desc1Q[0]) ?> " readonly >
                                            </td>                                        
                                            
                                            <td  width="150">
                                                <button id="bb" type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPractica">
                                                    BUSCAR
                                                </button>
                                            </td>
                                            <td  width="100">                                                                                                                                                
                                                <button  onclick="javascript:mostrar1();" type="button" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i></button>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <!-- Practica 2 -->
                                        <tr id="flotante" style="display:none;">
                                            <td width="200"> 
                                                <input placeholder="Codigo" type="text" class="form-control" id="codPrac2" name="valueInput" readonly >
                                            </td>
                                            <td width="700">
                                                <input placeholder="Descripcion" type="text" class="form-control" id="codDesc2" name="valueInput" readonly >
                                            </td>                                        
                                            <!-- Button trigger modal -->
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPractica2">
                                                    BUSCAR
                                                </button>
                                            </td>
                                            <td>                                                                            
                                                <button  onclick="javascript:mostrar2();" type="button" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i></button>
                                            </td>
                                            <td>
                                                <button  onclick="javascript:cerrar1();" type="button" class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                                            </td>
                                        </tr>
                                        <!-- PRACTICA 3 -->
                                        <tr id="flotante2" style="display:none;">
                                            <td width="200"> 
                                                <input placeholder="Codigo" type="text" class="form-control" id="codPrac3" name="valueInput" readonly >
                                            </td>
                                            <td width="900">
                                                <input placeholder="Descripcion" type="text" class="form-control" id="codDesc3" name="valueInput" readonly >
                                            </td>                                        
                                            <!-- Button trigger modal -->
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPractica3">
                                                    BUSCAR
                                                </button>
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                <button  onclick="javascript:cerrar2();" type="button" class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                                <span id="cod1Tiem" hidden = ""></span> <!-- valor hora inicio -->
                                <span id="cod1Practica" hidden = ""></span> <!-- descripción practica -->
                            <script type='text/JavaScript'>
                                function mostrar1() {
                                    div = document.getElementById('flotante');
                                    div.style.display = '';
                                }

                                function cerrar1() {
                                    div = document.getElementById('flotante');
                                    div.style.display = 'none';
                                }

                                function mostrar2() {
                                    div = document.getElementById('flotante2');
                                    div.style.display = '';
                                }
                                function cerrar2() {
                                    div = document.getElementById('flotante2');
                                    div.style.display = 'none';
                                }
                            </script>                      
                    </fieldset>
                </li>                
            </ul>

            <ul class="list-group list-group-horizontal-md"> <!-- QUIROFANO -->
                <li class="list-group-item border-0">
                    Quirofanoㅤㅤㅤㅤㅤㅤ
                </li>
                <li class="list-group-item border-0">
                    <select  onchange="QuirModi()" class="custom-select" required id="menuQuirofano">
                            <option value="<?php echo $numQ?>"><?php echo $descQ?></option>
                            <?php 
                                while($row=mysqli_fetch_array($menQuirofano)) {
                            ?>
                                <option id="selqui" value="<?php echo $row['Numero']?>"> <?php echo $row['Descripcion']?> </option>
                            <?php }?>
                        </select>
                    <span id="selectMenuQuirofano" hidden = "" ></span> <!-- VALOR DEL QUIROFANO -->
                    <script>
                        $('#menuQuirofano').on('change', function(){
                            var valor = this.value;
                            $('#selectMenuQuirofano').text(valor);
                            HoraInicioM();                                                                                              
                        })
                    </script>
                </li>
                <li class="list-group-item border-0"></li>
            </ul>

            <ul class="list-group list-group-horizontal-lg"> <!-- FECHA -->
                <li class="list-group-item border-0">
                    <b> Fecha</b>ㅤㅤㅤㅤㅤㅤㅤㅤㅤ
                </li>
                <li class="list-group-item border-0">
                    <input onchange="FechaModificar()" id="fechaSelec" type="date" value="<?php echo substr($fechaQ , 0, -9)?>" required>
                    <span id="selecFecha" hidden = ""></span> <!-- VALOR FECHA -->
                    <script>                                            
                        /* $('#menuQuirofano').on('change', function(){
                            var valor = this.value;
                            $('#selecFecha').text(valor);
                            if ($(this).val() === "") {
                                $("#fechaSelec").prop("disabled", true);
                            } else {
                                $("#fechaSelec").prop("disabled", false);
                            }                                                                                                 
                        }) */
                    </script> 
                </li>
                <li class="list-group-item border-0"></li>
            </ul>
 
            <br>
            <ul class="list-group list-group-horizontal-xl"> <!-- Tabla turnos -->
                <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
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
                                                            $turnTabla = mysqli_query($conSanatorio,"SELECT tq.Estado,
                                                            tq.Quirofano AS NumQuir, 
                                                            DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
                                                            DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin,  
                                                            LTRIM(RTRIM(pr.Nombre))AS NomMedico, 
                                                            SUBSTRING(pa.Descripcion,1,50) AS DescriPractica
                                                            FROM turnosquirofano AS tq 
                                                            INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                                            INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
                                                            INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                                            INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
                                                            WHERE Estado IN ('PENDIENTE')
                                                            AND tq.Fecha = '$fechaQ'
                                                            AND tq.Quirofano = $numQ
                                                            GROUP BY tq.numero
                                                            ORDER BY HoraInicio");
                                                                                                      
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
                <li class="list-group-item border-0"></li>
            </ul>
            <br>

            <fieldset class="border p-2 border">
                
                    <ul class="list-inline">
                        
                        <li class="list-inline-item">Hora de Inicio Actual<h6><input id="selectHoraInicioAc" value ='<?php echo substr($horaI , 11, -3) ?>' disabled> </input></h6> </li> <!-- valor hora inicio -->
                        <li class="list-inline-item col-sm-1">
                            <p>Hora de Inicio Nueva</p>
                            <select id="Hinicio" class="sele custom-select" style="display:none;">                            
                               
                            </select>
                            <div id="element">                                        
                                <input id="disableTimeRangesExample" type="text" class="time" />
                                    <?php 
                                        $ocHora = mysqli_query($conSanatorio,"SELECT * FROM turnosquirofano 
                                                                                WHERE fecha ='$fechaQ' 
                                                                                AND numero <> $numero
                                                                                ORDER BY horaInicio");
                                        $H = array();
                                        $hi[0] = "00:00";
                                        $hf[0] = "00:00";
                                        while ($verConfig  = @mysqli_fetch_array($ocHora)) {
                                            $hi[] = substr($verConfig["HoraInicio"] , 11, -3);
                                            $hf[] = substr($verConfig["HoraFin"] , 11, -3);  
                                            $cont++;
                                        }
                                    ?>
                                <script>
                                    $(function() {
                                        $('#disableTimeRangesExample').timepicker({ 
                                            'timeFormat': 'H:i',
                                            'step': 5 ,
                                            'disableTimeRanges': [
                                                <?php for ($i=1; $i < $cont; $i++) { 
                                                    echo "['".$hi[$i]."', '".$hf[$i]."']";

                                                    if ($i < $cont-1) {
                                                        echo ",";
                                                    }
                                                } ?>                                                                                                                                                                                                                                                                  
                                            ],
                                            'minTime': '7:00',
                                            'maxTime': '00:00',
                                            'showDuration': true
                                        });
                                            
                                    });
                                </script>
                            </div>

                            <script>
                                $('#Hinicio').on('change', function(){
                                    var valor = this.value;
                                    HoraFinM(valor);
                                })
                                $('#disableTimeRangesExample').on('change', function(){
                                    var valor = this.value;
                                    HoraFinM(valor);
                                })
                            </script>

                        </li>

                        <li class="list-inline-item"> <span id="selectHoraInicio" hidden = ""></span> </li>

                        <li class="list-inline-item">Hora de Fin</li>
                        <li class="list-inline-item col-sm-2">                            
                            <input type="text" class="HfinModi form-control" id="HfinModi" name="HfinModi" value="<?php echo substr($horaF , 11, -3) ?>" readonly>
                            <span id="selectHoraFinModi" class="selectHoraFinModi" hidden = ""> <?php echo substr($horaF , 11, -3) ?> </span> <!-- valor hora fin -->
                        </li>

                        <li class="list-inline-item"> 
                            <span id="selectHoraFinModi" hidden=""></span> <!-- valor hora fin -->
                        </li>

                        <li class="list-inline-item">Agregar Tiempo</li>
                        <li class="list-inline-item">
                            <select class="sele custom-select" id="tiempomas" name="tiempomas" >
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
              
                    <ul class="list-inline"> 
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
                        
                        <li class="list-inline-item">

                        </li>
                    </ul>                                            
                
                <br>
                
                <div class="d-flex justify-content-center"> <!-- FORCE TRIAD -->
                    <ul class="list-inline">
                        <?php  if ((empty($forceS) or $forceS == "NO")&&(empty($forceP) or $forceP == "NO")){ ?>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="ForP custom-control-input" id="ForP" >
                                <label class="text-dark custom-control-label" for="ForP">FORCE TRIAD – LIGASURE (PROPIO)</label>
                            </div> 

                            <div class="custom-control custom-switch">                                                                                                               
                                <input type="checkbox" class="ForS custom-control-input" id="ForS">
                                <label class="text-dark custom-control-label" for="ForS">FORCE TRIAD – LIGASURE (SANATORIO)</label>
                            </div> 
                            <span id="selectforceProp" hidden="" >NO</span> 
                            <span id="selectforceSana" hidden="" >NO</span> 
                            <input value="0" id="selectforceSanaa" hidden="">
                            <input value="0" id="selectforcePropp" hidden=""> 
                        <?php  }elseif (empty($forceS) or $forceS == "NO"){ ?>
                            <div class="custom-control custom-switch">
                                <input checked type="checkbox" class="ForP custom-control-input" id="ForP" >
                                <label class="text-dark custom-control-label" for="ForP">FORCE TRIAD – LIGASURE (PROPIO)</label>
                            </div> 

                            <div class="custom-control custom-switch">                                                                                                               
                                <input type="checkbox" class="ForS custom-control-input" id="ForS">
                                <label class="text-dark custom-control-label" for="ForS">FORCE TRIAD – LIGASURE (SANATORIO)</label>
                            </div> 
                            <span id="selectforceProp" hidden="" >NO</span> 
                            <span id="selectforceSana" hidden="" >SI</span> 
                            <input value="0" id="selectforceSanaa" hidden="">
                            <input value="1" id="selectforcePropp" hidden="">
                        <?php }else{ ?>
                            <div class="custom-control custom-switch">
                                <input  type="checkbox" class="ForP custom-control-input" id="ForP" >
                                <label class="text-dark custom-control-label" for="ForP">FORCE TRIAD – LIGASURE (PROPIO)</label>
                            </div> 

                            <div class="custom-control custom-switch">                                                                                                               
                                <input checked type="checkbox" class="ForS custom-control-input" id="ForS">
                                <label class="text-dark custom-control-label" for="ForS">FORCE TRIAD – LIGASURE (SANATORIO)</label>
                            </div> 
                            <span id="selectforceProp" hidden="" >SI</span> 
                            <span id="selectforceSana" hidden="" >NO</span> 
                            <input value="1" id="selectforceSanaa" hidden="">
                            <input value="0" id="selectforcePropp" hidden="">
                        <?php  }?>                                                    
                    </ul>
                </div>
                
                <br>
               
                    <div class="custom-control custom-switch">
                        <ul class="list-inline">
                            <li class="list-inline-item"> <!-- MONITOREO -->
                                <?php  if (empty($monitoreoQ) or $monitoreoQ == "NO"){ ?>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="monitoreo custom-control-input" id="customSwitch2">
                                        <label class="custom-control-label text-dark" for="customSwitch2">
                                        <span class="text-dark" id="selectRadioMonitoreo">NO</span> Monitoreo</label>
                                        <input value="NO" id="selectRadioMonitoreoo" hidden="">
                                    </div> 
                                    <?php }else{ ?>
                                        <div class="custom-control custom-switch">
                                        <input type="checkbox" class="monitoreo custom-control-input" id="customSwitch2" checked>
                                        <label class="custom-control-label text-dark" for="customSwitch2">
                                        <span class="text-dark" id="selectRadioMonitoreo">SI</span> Monitoreo</label>
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
                                        <span id="selectRadioRX" class="text-dark">NO</span> RX</label>
                                        <input value="NO" id="selectRadioRXx" hidden="">
                                    </div>  
                                    <?php }else{ ?>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="rx custom-control-input" id="customSwitch3" checked>
                                            <label class="text-dark custom-control-label" for="customSwitch3">
                                            <span id="selectRadioRX" class="text-dark">SI</span> RX</label>
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
                            <li class="list-group-item border-0">
                                ㅤㅤㅤㅤㅤㅤ
                            </li>
                            <li class="list-group-item border-0">
                                <!-- tipo de sangre --->
                            </li>
                            <li class="list-group-item border-0">
                                <!-- select --->
                            </li>
                        </ul>
                    </div>
                
                
                    <div class="d-flex justify-content-center"> <!-- para internar -->
                        <ul class="list-inline">
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
                                <div class="col-sm-4">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input checked type="radio" id="customRadioInline1" name="tipocirugia" class="custom-control-input" value = 1>
                                        <label class="text-dark custom-control-label" for="customRadioInline1">Para internar</label>
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="tipocirugia" class="custom-control-input" value = 0>
                                        <label class="text-dark custom-control-label" for="customRadioInline2">Ambulatorio</label>
                                    </div>
                                    <span class="text-dark" id="selectRadiotipo_cirugia" hidden=""></span>
                                    <input value="0" id="selectRadiotipo_cirugiaa" hidden="">
                                </div>                                                    
                            <?php } ?>
                        </ul>
                    </div>
                <br>
                <div class="d-flex justify-content-center">
                        <label for="exampleFormControlTextarea1">DIAGNOSTICO PREOPERATORIO:</label>
                    <textarea class="form-control is-invalid" placeholder="Deberá escribir el/los nombre de los procedimientos que realizará en el Paciente
                        Ej: • Hernioplastia umbilical con malla
                            • Osteosíntesis de fémur
                            • Histerectomía laparoscopica" id="tarea" rows="3" required><?php echo $tareaQ ?></textarea>
                </div>
            </fieldset>

            <br>
            <br>

            <fieldset class="border p-2 border">
                <legend  class="w-auto ">Paciente</legend>                
                    <ul class="list-group list-group-horizontal-sm">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                            <li class="list-group-item border-0"> <!-- TIPO DE DNI -->
                                <label for="">Tipo de Documento </label>
                                <select class="custom-select" required id="menuDoc" required>
                                        <?php $tipDoc = mysqli_query($conSanatorio, "SELECT tipodocumentoidentidad AS tipo, descripcion FROM tiposdocumentoidentidad WHERE neonatologia='0' and TipoDocumentoIdentidad = $dniTQ");
                                        while($roww=mysqli_fetch_array($tipDoc)) { ?>
                                            <option value="<?php echo $roww['tipo']?>" > <?php echo $roww['descripcion']?> </option>
                                        <?php } ?>

                                    <?php 
                                        $menuDocumento = mysqli_query($conSanatorio, "SELECT tipodocumentoidentidad AS tipo, descripcion FROM tiposdocumentoidentidad WHERE neonatologia='0'");
                                        while($row=mysqli_fetch_array($menuDocumento)) {
                                    ?>
                                        <option value="<?php echo $row['tipo']?>" > <?php echo $row['descripcion']?> </option>
                                    <?php }?>
                                </select>
                                <span id="selectMenuDoc" hidden=""></span><!-- VALOR DEL Documento -->
                                <script>
                                    $('#menuDoc').on('change', function(){
                                        var valor = this.value;
                                        $('#selectMenuDoc').text(valor);
                                    })
                                </script>
                            </li>

                            <li class="list-group-item border-0"> <!-- DNI NUMERO -->
                                <label for="">Numero</label>                                    
                                <input type="text" name="doc" class="form-control is-invalid" id="doc" value="<?php echo $dniQ ?>" required>
                            </li>

                            <li class="list-group-item border-0">
                                <label> ㅤㅤ</label>
                                <button id="bus" type="button" class="btn btn-primary" onclick="buscar_datos();">
                                        BUSCAR
                                </button>
                            </li>
                    </ul>
                    <ul class="list-group list-group-horizontal-sm">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
                            <label for="">Nombre y Apellido:</label>                                                       
                            <INPUT required type="text" class="form-control" id="NomyApe" value="<?php echo $nombreQ ?>" >
                        </li>
                        <li class="list-group-item border-0">
                            <label for="">Teléfono:</label>
                            <INPUT required type="text" type="text" class="form-control" id="tel" value="<?php echo $telefonoQ ?>" > 
                        </li>
                    </ul>
                    <ul class="list-group list-group-horizontal-md">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
                            <label for="">Email:</label>
                            <INPUT type="email" class="form-control" id="email" value = "<?php echo $email ?>" >
                        </li>
                        <li class="list-group-item border-0">
                            <label for="">Obra Social:</label>
                                <select required class="custom-select" id="menuObraSoc" >    
                                    <option value="<?php echo $obraSocialQ ?>"><?php echo $obraSocialNom ?></option>
                                    <?php 
                                        $menuDocumento = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(CodigoObraSocial)) AS Codigo,Descripcion,Deshabilitada FROM obrassociales WHERE web = '1' ORDER BY Descripcion ASC");
                                        while($row=mysqli_fetch_array($menuDocumento)) {
                                    ?>
                                        <?php if ($row['Deshabilitada'] == '1'): ?>
                                        <!-- VALOR DEL Documento  <option value="DESHABILITADA" style="background:#F00; color: #fff;"><?php echo utf8_encode($row['Descripcion']) ?>  DESHABILITADA</option>  -->
                                        <?php else: ?>
                                            <option value="<?php echo utf8_encode($row['Codigo']) ?>"> <?php echo utf8_encode($row['Descripcion']) ?> </option>
                                        <?php endif; ?>
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
            </fieldset>

            <br>
                                    
            <div class="col text-center" id = "dosForm">
                <button type="button" class="btn btn-success" onclick="chequeaTurno()">GUARDAR DATOS</button>
            </div>
        </div>

  </div>

</div>

</body>
</html>

<script>
    $(document).ready(function() {
        $('#ModalBucarPractica').DataTable({ 
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });
        $('.js-example-basic-single').select2();
    });
</script>
<script src="funciones.js"></script>

<!-- Modal Practica1 -->
    <div class="modal fade" id="ModalPractica" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Buscar Practica</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <!-- Tabla --->
                    <table id="ModalBucarPractica" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th> Código </th>
                                <th> Descripción </th>
                                <th> Seleccionar </th>                 
                            </tr>
                        </thead>
                        <tbody>                
                            <?php 
                            $pracBusc1 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo, SUBSTRING(Descripcion,1,50) AS Descripcion2, Descripcion, TiempoEstimado 
                            FROM practicasquirofano
                            WHERE web = 0 AND TiempoEstimado > 0");; 
                            if(!$pracBusc1) {?>
                                <tr>
                                    <td colspan="6">NO hay datos para mostrar</td>
                                </tr>
                                <?php } 
                                else {
                                    while($row=mysqli_fetch_array($pracBusc1)) { 
                                        $practica1=$row[0]."||".
                                                $row[1]."||".
                                                utf8_encode($row[2])."||".
                                                $row[3];  
                                ?>                                                  
                                    <tr>
                                        <td ><?php echo $row['Codigo']; ?></td>
                                        <td ><?php echo utf8_encode($row['Descripcion']) ?></td>
                                        <td>
                                            <button id="modalid" class="btn btn-primary" onclick="practica1('<?php echo $practica1 ?>'), HoraInicioo('<?php echo $practica1 ?>'), HoraFin()" data-dismiss="modal" > seleccionar </button> 
                                        </td> 
                                    </tr>                                                                                                             
                                <?php
                                }//Fin while
                                }//Fin if   
                                ?>
                        </tbody>
                    </table>
        <!-- fin tabla--->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
<!-- fin Modal Practica1 -->

<!-- Modal Practica2 -->
    <div class="modal fade" id="ModalPractica2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Buscar Practica</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
    <!-- Tabla --->
                <table id="ModalBucarPractica1" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th> Código </th>
                            <th> Descripcion </th>
                            <th> Seleccionar </th>                 
                        </tr>
                    </thead>
                    <tbody>                
                        <?php 
                        $pracBusc1 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo,SUBSTRING(Descripcion,1,50) AS Descripcion2,Descripcion,TiempoEstimado FROM practicasquirofano");;                                        
                        if(!$pracBusc1) {?>
                            <tr>
                                <td colspan="6">NO hay datos para mostrar</td>
                            </tr>
                            <?php }
                            else {
                                while($row=mysqli_fetch_array($pracBusc1)) { 
                                    $datos=$row[0]."||".
                                            $row[1]."||".
                                            $row[2];  
                            ?>                                                  
                                <tr>
                                    <td ><?php echo $row['Codigo']; ?></td>
                                    <td > <?php echo utf8_encode($row['Descripcion']) ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="practica2('<?php echo $datos ?>')" data-dismiss="modal" > seleccionar </button> 
                                    </td> 
                                </tr>                                                                                                             
                            <?php
                            }//Fin while
                            }//Fin if   
                            ?>
                    </tbody>
                </table>
    <!-- fin tabla--->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
<!-- fin Modal Practica2 -->

<!-- Modal Practica3 -->
    <div class="modal fade" id="ModalPractica3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Buscar Practica</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
    <!-- Tabla --->
                <table id="tablaBucarPractica33" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th> Codigo </th>
                            <th> Descripcion </th>
                            <th> Seleccionar </th>                 
                        </tr>
                    </thead>
                    <tbody>                
                        <?php 
                        $pracBusc1 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo,SUBSTRING(Descripcion,1,50) AS Descripcion2,Descripcion,TiempoEstimado FROM practicasquirofano");;                                        
                        if(!$pracBusc1) {?>
                            <tr>
                                <td colspan="6">NO hay datos para mostrar</td>
                            </tr>
                            <?php }
                            else {
                                while($row=mysqli_fetch_array($pracBusc1)) { 
                                    $datos=$row[0]."||".
                                            $row[1]."||".
                                            $row[2];  
                            ?>                                                  
                                <tr>
                                    <td ><?php echo $row['Codigo']; ?></td>
                                    <td ><?php echo utf8_encode($row['Descripcion']) ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="practica3('<?php echo $datos ?>')" data-dismiss="modal" > seleccionar </button> 
                                    </td> 
                                </tr>                                                                                                             
                            <?php
                            }//Fin while
                            }//Fin if   
                            ?>
                    </tbody>
                </table>
    <!-- fin tabla--->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
<!-- fin Modal Practica3 -->