<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}

$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/

require_once "../../conSanatorio.php";
require_once "dependencias.php";
$menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden");

$numero = $_GET["num"];

$consl = mysqli_query($conSanatorio,"SELECT * FROM turnosquirofano AS tq
                                    INNER JOIN Quirofanos AS q
                                    ON tq.Quirofano = q.Numero
                                    WHERE  tq.numero = $numero");
while($mod=mysqli_fetch_array($consl)) {
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
    $obraSocialQ = $mod['ObraSocial'];
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
    <title>Modificar Turno Quirofanos</title>
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
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta charset="utf-8">

</head>
<div> 
<body style="background-color:#E9ECEE;">

<?php  include_once "menuMedicos.php" ?> <!–– Menu Medico -->
<script>
    $(document).ready(function(){
        fecha()
    });
</script>
<span id="vMatricula" hidden = ""> <?php echo $matricula; ?> </span>
        <div class="container">
            <div class="row">
                <div class="col-11">
                    <?php  include_once "tablaquir.php" ?>
                </div>
            </div>
        </div>
       <br>
<!–– Principal --> 
<form class="was-validated">                                                       
                     <div class="card text">
                        <div class="card-header text-white h5" style="background-color:#03588C;">Modificar Turno</div> 
                        <input value="<?php echo $numero ?>" id="nNumero" hidden="">
                            <div class="row">
                                <div class="col-2">
                                    <div class="nav flex-column nav-pills text-center font-weight-bold" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <br>
                                        <a class="nav-link active" id="v-Fecha-Quirofano-tab" data-toggle="pill" href="#v-Fecha-Quirofano" role="tab" aria-controls="v-Fecha-Quirofano" aria-selected="true"> Fecha y Quirófano </a>
                                        <br>
                                        <a class="nav-link" id="v-Paciente-tab" data-toggle="pill" href="#v-Paciente" role="tab" aria-controls="v-Paciente" aria-selected="false"> Paciente </a>
                                        <br>
                                        <a class="nav-link" id="v-Practicas-tab" data-toggle="pill" href="#v-Informacion" role="tab" aria-controls="v-Informacion" aria-selected="false"> Información de la Cirugía </a>
                                        <br>
                                        <a class="nav-link" id="v-Practicas-tab" data-toggle="pill" href="#v-Practicas" role="tab" aria-controls="v-Practicas" aria-selected="false"> Practicas </a>
                                        <br>
                                        <br>
                                    </div>
                                </div>                                
                            
                                <!-- dentro del menu -->
                                <div class="col-9">
                                    <div class="tab-content text-center" id="v-pills-tabContent">

                                        <!---- Fecha-Quirofano ----->
                                        <div class="tab-pane fade show active" id="v-Fecha-Quirofano" role="tabpanel" aria-labelledby="v-Fecha-Quirofano-tab">
                                            
                                                <div class="row">
                                                    <div class="col-sm-1"></div>                                               
                                                    <div class="col-sm-3">
                                                        <label><i><big>Quirofano</i></big></label>                                                                            
                                                            <select  class="custom-select" required id="menuQuirofano">
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
                                                            })
                                                        </script>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="validationDefault02"><i><big>Fecha:</i></big></label>
                                                        <input onchange="fecha()" id="fechaSelec" type="date" value="<?php echo substr($fechaQ , 0, -9) ?>"required>
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
                                                    </div>
                                                </div>
                                                <br>                                            
                                                <div class = "row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-2">
                                                        <label> <i><big>Código</i></big> </label> 
                                                        <input type="text" class="form-control" id="cod1Prac" value="<?php echo $cod1Q[0] ?> "readonly required>
                                                        <span id="cod1Tiem" hidden = ""> <?php echo $tiempoQ ?> </span> <!-- valor hora inicio -->
                                                        <span id="cod1Practica" hidden = ""> <?php echo $cod1Q[0] ?> </span> <!-- descripción practica -->
                                                    </div>
                                                    <div class="col.sm-1">
                                                        <label>ㅤㅤㅤ</label>
                                                        <button id="bb" type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPractica">
                                                            BUSCAR
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <label> <i><big>Descripción </big></i></label> 
                                                        <input type="text" class="form-control" id="cod1Desc" value ="<?php echo  utf8_encode($desc1Q[0]) ?>" readonly>
                                                        <span id="cod1Descripcion" hidden = ""></span> <!-- Descripcion practica -->
                                                    </div>
                                                                                                
                                                </div> 
                                                <br>
                                                <div class = "row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-2">
                                                        <label ><i><big>Hora de Inicio</i></big></label>
                                                        <h6><span id="selectHoraInicio" > <?php echo substr($horaI , 11, -3) ?> </span></h6> <!-- valor hora inicio -->
                                                        <select id="Hinicio" class="sele custom-select">
                                                                <option value="<?php echo substr($horaI , 11, -3) ?>" > <?php echo substr($horaI , 11, -3) ?></option>
                                                        </select>
                                                        
                                                    </div> 
                                                    
                                                    <div class="col-sm-2">
                                                        <label for="validationDefault04"><i><big>Hora de Fin</i></big></label>                                        
                                                        <input type="text" class="Hfin form-control" id="Hfin" name="Hfin" value="<?php echo substr($horaF , 11, -3) ?>" readonly>
                                                        <span id="selectHoraFin" class="selectHoraFinc" hidden = ""> <?php echo substr($horaF , 11, -3) ?> </span> <!-- valor hora fin -->
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label> <i><big>  Agregar Tiempo</i></big> </label> 
                                                        <select class="sele custom-select" id="tiempomas" name="tiempomas" >
                                                            <option value="00"></option>
                                                            <option value="10">10 Minutos</option>
                                                            <option value="20">20 Minutos</option>
                                                            <option value="30">30 Minutos</option>
                                                            <option value="40">40 Minutos</option>
                                                            <option value="50">50 Minutos</option>
                                                            <option value="60">1 Hora</option> <!-- sumar -->
                                                        </select>    
                                                        <span id="selectTiempoMas" hidden = ""></span>
                                                    </div>
                                                    
                                                </div>
                                                <br>
                                                <div class = "row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-4">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        
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
                                                    </div>                                                
                                                </div>
                                                <br>
                                                <div class = "row">
                                                    <div class="col-sm-1"></div>
                                                    <div class="col-sm-9">
                                                    <label for="exampleFormControlTextarea1">DIAGNOSTICO PREOPERATORIO:</label>
                                            <textarea class="form-control is-invalid" placeholder="Deberá escribir el/los nombre de los procedimientos que realizará en el Paciente
                                            Ej: • Hernioplastia umbilical con malla
                                                • Osteosíntesis de fémur
                                                • Histerectomía laparoscopica" id="tarea" rows="3" value= required> <?php echo $tareaQ ?> </textarea> 
                                                    </div>
                                                </div>
                                                <br>
                                                <div class = "row">
                                                    <div class="col-sm-10">
                                                        <div id="select2lista"></div>
                                                    </div>                                                    
                                                </div>
                                        </div>

                                        <!---- Paciente ----->
                                        <div class="tab-pane fade" id="v-Paciente" role="tabpanel" aria-labelledby="v-Paciente-tab">
                                                <br>
                                                <div class = "row">
                                                        <div class="col-sm-1"></div>
                                                        <div class="col-sm-2">
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
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <label for="">Numero</label>                                    
                                                            <input type="text" name="doc" class="form-control is-invalid" id="doc" value="<?php echo $dniQ ?>" required>
                                                        </div>  
                                                        <div class="col-sm-2">
                                                            <label> ㅤㅤ</label>
                                                            <button id="bus" type="button" class="btn btn-primary" onclick="buscar_datos();">
                                                                BUSCAR
                                                            </button>
                                                        </div>                                                          
                                                </div>
                                                <br>
                                                <div class = "row">
                                                        <div class="col-sm-1">
                                                        </div> 
                                                        <div class="col-sm-5">
                                                            <label for="">Nombre y Apellido:</label>                                                       
                                                            <INPUT required type="text" class="form-control" id="NomyApe" value="<?php echo $nombreQ ?>" >
                                                        </div>                                                        
                                                        <div class="col-sm-4">
                                                            <label for="">Teléfono:</label>
                                                            <INPUT required type="text" type="text" class="form-control" id="tel" value="<?php echo $telefonoQ ?>" > 
                                                        </div>                                                        
                                                </div>
                                                <br>
                                                <div class = "row">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <label for="">Email:</label>
                                                            <INPUT type="email" class="form-control" id="email" value = "<?php echo $email ?>" >
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <label for="">Obra Social:</label>
                                                            <select required class="custom-select" id="menuObraSoc" >
                                                                <option value="<?php echo $obraSocialQ ?>"><?php echo $obraSocialQ ?></option>
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
                                                        </div>
                                                </div>
                                                <br>
                                                <div class = "row">
                                                        <div class="col-sm-3">
                                                        </div>
                                                        <div class="col-sm-2">
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
                                                        </div>
                                                        <div class="col-sm-2">
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
                                                        </div>
                                                        <div class="col-sm-2">
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
                                                        </div>
                                                </div>
                                                <br>
                                                <div class = "row">
                                                    <div class="col-sm-4">
                                                    </div>                                                   
                                                    <?php  if ($InterAmbu == 0 ){ ?>
                                                        <div class="col-sm-2">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline1" name="tipocirugia" class="custom-control-input" value = 1>
                                                                <label class="text-dark custom-control-label" for="customRadioInline1">Para internar</label>
                                                            </div> 
                                                        </div>
                                                        <div class="col-sm-2">
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
                                                   


                                                </div>
                                            
                                        </div>

                                        <!---- Información de la Cirugía ----->
                                        <div class="tab-pane fade" id="v-Informacion" role="tabpanel" aria-labelledby="v-Informacion-tab">
                                            <br>
                                            <br>
                                            <div class = "row">
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
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
                                                </div>
                                                <div class="col-sm-2">
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
                                                </div>
                                                <div class="col-sm-2">
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
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class = "row">
                                                <div class="col-sm-2">
                                                </div>
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

                                                    
                                                                                                                                                           
                                            </div>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php  if (empty( $intruPro ) or $intruPro == "NO"){ ?>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="intru custom-control-input" id="customSwitch10">
                                                            <label class="text-dark custom-control-label" for="customSwitch10">INSTRUMENTISTA (PROPIO):</label>
                                                        </div>                                            
                                                        <span id="selectintru" hidden="">NO</span> <!-- valor Radio -->
                                                    <?php }else{ ?>
                                                        <div class="custom-control custom-switch">
                                                            <input checked type="checkbox" class="intru custom-control-input" id="customSwitch10">
                                                            <label class="text-dark custom-control-label" for="customSwitch10">INSTRUMENTISTA (PROPIO):</label>
                                                        </div>                                            
                                                        <span id="selectintru" hidden="">SI</span> <!-- valor Radio -->
                                                    <?php  } ?>

                                                </div> 
                                            </div>
                                            <br>
                                            <br>
                                            <div class = "row">
                                                <div class="col-sm-1">
                                                </div>
                                                <div class="col-sm-10">
                                                    <label for="">INSUMOS NO HABITUALES:</label> 
                                                    <textarea value="<?php echo $insumo ?>" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>                                                        
                                            </div>
                                        </div>
                                        
                                         <!---- Practicas ----->
                                        <div class="tab-pane fade" id="v-Practicas" role="tabpanel" aria-labelledby="v-Practicas-tab">
                                            <br>

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


                                            
                                        </div>

                                        <!---- Ayudantes ----->
                                       <!----  <div class="tab-pane fade" id="v-Ayudantes" role="tabpanel" aria-labelledby="v-Ayudantes-tab">
                                            <br>
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Matriculas</th>
                                                    <th cope="col">Ayudantes</th>
                                                    <th>Buscar</th>
                                                    <th>Quitar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    
                                                        $ayu = mysqli_query ($conSanatorio ,"SELECT pr.Matricula,
                                                                            pr.Nombre,
                                                                            tAyuQ.Numero FROM 
                                                                            turnosquirofanoayudante AS tAyuQ
                                                                            INNER JOIN profesionales AS pr
                                                                            ON pr.matricula = tAyuQ.MatProfesional
                                                                            WHERE numero = $numero AND TipoAyudante = 1;");
                                                        $c = 0;
                                                        while ($ay = mysqli_fetch_array($ayu)){
                                                            $c++;?>
                                                            <tr>
                                                                <td><input type="text" class="form-control" id="matAyu<?php echo $c ?>" name="valueInput" Value="<?php echo $ay['Matricula'] ?>" readonly></td>
                                                                <td><input type="text" class="form-control" id="nomAyu<?php echo $c ?>" name="valueInput" Value="<?php echo $ay['Nombre'] ?>" readonly></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAyudante<?php echo $c ?>">
                                                                        BUSCAR
                                                                    </button>
                                                                </td>
                                                                <td>Quitar</td>
                                                            </tr>

                                                    <?php  };
                                                    for ($i=$c; $i < 4; $i++) { ?>
                                                            <tr>
                                                                <td><input type="text" class="form-control" id="matAyu<?php echo $i ?>" name="valueInput" readonly></td>
                                                                <td><input type="text" class="form-control" id="nomAyu<?php echo $i ?>" name="valueInput" readonly></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAyudante<?php echo $i ?>">
                                                                        BUSCAR
                                                                    </button>
                                                                </td>
                                                                <td>Quitar</td>
                                                            </tr>
                                                       
                                                    <?php  } ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div> ----->

                                        <!---- Anestesista ----->
                                       <!--- <div class="tab-pane fade" id="v-Anestesista" role="tabpanel" aria-labelledby="v-Anestesista-tab">
                                            <br>
                                            <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Matricula</th>
                                                    <th cope="col">Anestesista</th>
                                                    <th>Buscar</th>
                                                    <th>Quitar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php                                                        
                                                        $ayu = mysqli_query ($conSanatorio ,"SELECT pr.Matricula,
                                                                            pr.Nombre,
                                                                            tAyuQ.Numero FROM 
                                                                            turnosquirofanoayudante AS tAyuQ
                                                                            INNER JOIN profesionales AS pr
                                                                            ON pr.matricula = tAyuQ.MatProfesional
                                                                            WHERE numero = $numero AND TipoAyudante = 2;");
                                                        $con = 0;
                                                        while ($ay = mysqli_fetch_array($ayu)){
                                                            $con = 1;
                                                    ?>
                                                    <tr>
                                                        <td><input type="text" class="form-control" id="anMat" name="valueInput" Value="<?php echo $ay['Matricula'] ?>" readonly></td>
                                                        <td><input type="text" class="form-control" id="anAyud" name="valueInput" Value="<?php echo $ay['Nombre'] ?>" readonly></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAnestesista">
                                                                BUSCAR
                                                            </button>
                                                        </td>
                                                        <td>Quitar</td>
                                                    </tr>
                                                    <?php } 
                                                            if ($con == 0){ ?>
                                                            <tr>
                                                                <td><input type="text" class="form-control" id="anMat" name="valueInput" readonly></td>
                                                                <td><input type="text" class="form-control" id="anAyud" name="valueInput" readonly></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAnestesista">
                                                                        BUSCAR
                                                                    </button>
                                                                </td>
                                                                <td>Quitar</td>
                                                            </tr>
                                                                
                                                    <?php }?>

                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div> ---> 
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-md-8">
                                    <button type="button" class="btn btn-secondary" onclick="CancelarMod()">CANCELAR</button>
                                    <button type="button" class="btn btn-success" onclick="confirmarM()">CONFIRMAR MODIFICACIÓN DE TURNO</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                <!–– Fin Principal -->
            </div>
         
                  
</form> <!–– Fin formulario -->
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
   

</body>
<script>
    $(document).ready(function() {
        $('#ModalBucarPractica').DataTable({ 
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });
    });
</script>
<script src="funciones.js"></script>
</html>

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
                                            <button id="modalid" class="btn btn-primary" onclick="practica1('<?php echo $practica1 ?>'), HoraFin()" data-dismiss="modal" > seleccionar </button> 
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
                                            utf8_encode($row[2]);  
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
                                            utf8_encode($row[2]);  
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

<!-- ----------------------------------------------->
<!-- Modal Ayudantes 1-->
    <div class="modal fade" id="ModalAyudante1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <table id="tablaBucarAyudante1" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th> Codigo </th>
                            <th> Descripcion </th>
                            <th> Seleccionar </th>                 
                        </tr>
                    </thead>
                    <tbody>                
                        <?php 
                        $pracBusc1 = mysqli_query($conSanatorio, "SELECT Matricula, ltrim(rtrim(Nombre)) as Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre ASC");
                        if(!$pracBusc1) {?>
                            <tr>
                                <td colspan="6">NO hay datos para mostrar</td>
                            </tr>
                            <?php }
                            else {
                                while($row=mysqli_fetch_array($pracBusc1)) { 
                                    $datos=$row[0]."||".
                                            $row[1]."||";
                            ?>                                                  
                                <tr>
                                    <td ><?php echo $row['Matricula']; ?></td>
                                    <td ><?php echo $row['Nombre']; ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="Ayudante1('<?php echo $datos ?>')" data-dismiss="modal" > seleccionar </button> 
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
<!-- fin Modal Ayudantes1-->

<!-- Modal Ayudantes 2-->
    <div class="modal fade" id="ModalAyudante2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <table id="tablaBucarAyudante2" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th> Codigo </th>
                            <th> Descripcion </th>
                            <th> Seleccionar </th>                 
                        </tr>
                    </thead>
                    <tbody>                
                        <?php 
                        $pracBusc1 = mysqli_query($conSanatorio, "SELECT Matricula, ltrim(rtrim(Nombre)) as Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre ASC");
                        if(!$pracBusc1) {?>
                            <tr>
                                <td colspan="6">NO hay datos para mostrar</td>
                            </tr>
                            <?php }
                            else {
                                while($row=mysqli_fetch_array($pracBusc1)) { 
                                    $datos=$row[0]."||".
                                            $row[1]."||";
                            ?>                                                  
                                <tr>
                                    <td ><?php echo $row['Matricula']; ?></td>
                                    <td ><?php echo $row['Nombre']; ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="Ayudante2('<?php echo $datos ?>')" data-dismiss="modal" > seleccionar </button> 
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
<!-- fin Modal Ayudantes 2-->

<!-- Modal Ayudantes 3-->
    <div class="modal fade" id="ModalAyudante3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <table id="tablaBucarAyudante3" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th> Codigo </th>
                            <th> Descripcion </th>
                            <th> Seleccionar </th>                 
                        </tr>
                    </thead>
                    <tbody>                
                        <?php 
                        $pracBusc1 = mysqli_query($conSanatorio, "SELECT Matricula, ltrim(rtrim(Nombre)) as Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre ASC");
                        if(!$pracBusc1) {?>
                            <tr>
                                <td colspan="6">NO hay datos para mostrar</td>
                            </tr>
                            <?php }
                            else {
                                while($row=mysqli_fetch_array($pracBusc1)) { 
                                    $datos=$row[0]."||".
                                            $row[1]."||";
                            ?>                                                  
                                <tr>
                                    <td ><?php echo $row['Matricula']; ?></td>
                                    <td ><?php echo $row['Nombre']; ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="Ayudante3('<?php echo $datos ?>')" data-dismiss="modal" > seleccionar </button> 
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
<!-- fin Modal Ayudantes 3--> 

<!-- ----------------------------------------------->
<!-- Modal Anestesista-->
    <div class="modal fade" id="ModalAnestesista" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <table id="tablaAnestesista" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th> Codigo </th>
                            <th> Descripcion </th>
                            <th> Seleccionar </th>                 
                        </tr>
                    </thead>
                    <tbody>                
                        <?php 
                        $pracBusc1 = mysqli_query($conSanatorio, "SELECT Matricula, ltrim(rtrim(Nombre)) as Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre ASC");
                        if(!$pracBusc1) {?>
                            <tr>
                                <td colspan="6">NO hay datos para mostrar</td>
                            </tr>
                            <?php }
                            else {
                                while($row=mysqli_fetch_array($pracBusc1)) { 
                                    $datos=$row[0]."||".
                                            $row[1]."||";
                            ?>                                                  
                                <tr>
                                    <td ><?php echo $row['Matricula']; ?></td>
                                    <td ><?php echo $row['Nombre']; ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="Anestesista('<?php echo $datos ?>')" data-dismiss="modal" > seleccionar </button> 
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
<!-- fin Modal Ayudantes1-->