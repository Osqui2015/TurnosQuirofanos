<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
$userr = $_SESSION['usuario']; /*VALOR USUARIO*/
require_once "../../conUsuario.php";
require_once "../../conSanatorio.php";
$arrayObraSocial = array();
$arrayPractica = array();
$menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden"); //order by Orden 

$menuObraSocial = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(CodigoObraSocial)) AS Codigo,Descripcion,Deshabilitada FROM obrassociales WHERE web = '1' ORDER BY Descripcion ASC");
while($row=mysqli_fetch_array($menuObraSocial)) {
    $CodObra = utf8_encode($row['Descripcion']);    
    array_push($arrayObraSocial, $CodObra); // equipos
};


$CodDescPractica = mysqli_query($conSanatorio, "SELECT Codigo, 
                                                Descripcion,
                                                TiempoEstimado,
                                                CONCAT(Codigo, ' ', Descripcion) AS Total
                                                FROM practicasquirofano
                                                WHERE Web = '0'
                                                AND TiempoEstimado IS NOT NULL;");
while($row=mysqli_fetch_array($CodDescPractica)) {
    $CodDescPr = utf8_encode($row['Total']);    
    array_push($arrayPractica, $CodDescPr); // 
};



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo Turno Quirofano</title>
    <?php  include_once "dependencias.php" ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="css.css"> <link rel="icon" href="../../imagen/modelo.jpg">
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body>
    
<input hidden = "" id="vMatricula" value = "<?php echo $matricula; ?>"> </input>
<input hidden = "" id="vUserr" value = "<?php echo $userr; ?>"> </input>
            <!-- menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            

                <!–– Principal -->
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne" style="background-color:#03588C;">                    
                            <a class="btn btn-block text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4>NUEVO TURNO DE QUIROFANO</h4>
                            </a>                        
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body"> 
                                <ul class="list-group list-group-horizontal-xl justify-content-md-center"> <!-- Nuevo Turno Quirofano -->
                                    
                                    <li class="list-group-item border-0"><h5>Fecha</h5></li>
                                        <li class="list-group-item border-0">
                                            <input onchange="fechaTurno()" type="date" name="fechaSelec" id="fechaSelec" placeholder="Introduce una fecha" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> />
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
                                    <li class="list-group-item border-0"><h5>Quirófano</h5></li>
                                    <li class="list-group-item border-0 col-md-2">
                                                                <select  class="custom-select" required id="menuQuirofano">                 
                                                                    <option value=""></option>
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
                                                                        fechaTurno();
                                                                        HoraInicioTurno();
                                                                    })
                                                                </script>
                                                            </li>
                                        
                                    
                                    <li class="list-group-item border-0 "><h5>Práctica 1</h5></li>
                                    <li class="list-group-item border-0 col-md-4">
                                            <select class="js-pra1-codigo form-control form-control-lg" name="state" id="codPrac1" onchange = "tiempopractica()">
                                            <option value=""> <p class="text-justify"> ㅤCÓDIGOㅤㅤㅤㅤㅤㅤ DESCRIPCIÓNㅤ</p> </option>
                                                <?php  
                                                
                                                    $pracBusc1 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo, SUBSTRING(Descripcion,1,50) AS Descripcion2, Descripcion, TiempoEstimado 
                                                    FROM practicasquirofano
                                                    WHERE web = 0 AND TiempoEstimado > 0");
                                                    while($row=mysqli_fetch_array($pracBusc1)) {
                                                ?>
                                                    <option value="<?php echo utf8_encode($row['Codigo']) ?>"> <p class="text-justify"> <?php echo utf8_encode($row['Codigo']) ?>ㅤㅤㅤㅤ ||ㅤㅤㅤㅤ <?php echo utf8_encode(substr($row['Descripcion'], 0, 60));  ?> </p> </option>

                                                <?php }?>
                                            </select>
                                       <!-- <input type="text" class="form-control" id='nombrePractica1' size="70" onchange="cambiarPractica1()">
                                        <input type="text" class="form-control" id='codigoPractica1' hidden="" > -->
                                    </li>
                                    <li class="list-group-item border-0">
                                        <button id="mostrar2" type="button" class="btn btn-success"><i class="bi bi-plus-circle-fill">+</i></button>
                                    </li>
                                    <li class="list-group-item border-0"><h5></h5></li>
                                    
                                </ul>
                                <div id ="pr2" style="display: none">
                                    <ul  class="list-group list-group-horizontal-lg"  > <!-- PRACTICA 2-->
                                        <li class="list-group-item border-0" style="width: 48%"></li>
                                        <li class="list-group-item border-0"><h5>Práctica 2</h5></li>
                                        <li class="list-group-item border-0">
                                            <input type="text" class="form-control" id='nombrePractica2' size="70" onchange="cambiarPractica2()">
                                            <input type="text" class="form-control" id='codigoPractica2' hidden="">
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
                                        <li class="list-group-item border-0" style="width: 48%"></li>
                                        <li class="list-group-item border-0"><h5>Práctica 3</h5></li>
                                        <li class="list-group-item border-0">
                                            <input type="text" class="form-control" id='nombrePractica3' size="70" onchange="cambiarPractica3()">
                                            <input type="text" class="form-control" id='codigoPractica3' hidden="">
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
                                                    $('#nombrePractica2').val(' ');
                                                    document.getElementById("pr2").style.display = "none";
                                                });
                                                $( "#cerrar3" ).click(function() {
                                                    $('#nombrePractica3').val(' ');
                                                    document.getElementById("pr3").style.display = "none";
                                                });
                                            </script>
                                
                                
                                
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
 
                                <div class="mx-auto" style="width: 75%;">
                                    <div id="select2lista">
                                    </div>
                                </div>

                               

                                <div class="row justify-content-center">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id='tp' class="mx-auto">
                                    
                                            </div> 
                                        </div> 
                                    </div> 
                                </div> 
                                
                                <br>
                                
 

                                <div class="container text-right">
                                    <div class="row justify-content-md-center">
                                        <div class="col-md">
                                            Hora Inicio: 
                                        </div>
                                        <div class="col-md">
                                            <select id="Hinicio" class="sele custom-select" onchange="HoraFinTurno()" required>
                                            </select>
                                            <span id="selectHoraInicio" hidden = ""></span> <!-- valor hora inicio -->
                                        </div>
                                        <div class="col-md">
                                            Hora Fin:
                                        </div>
                                        <div class="col-md">
                                            <input type="text" class="Hfin form-control" id="Hfin" name="Hfin" value="" readonly>
                                        </div>
                                        <div class="col-md">
                                            AgregarTiempo:
                                        </div>
                                        <div class="col-md">
                                            <select class="sele custom-select" id="tiempomas" name="tiempomas" onchange="AgregarTiempo()">
                                                <option value="00"></option>
                                                <option value="10">10 Minutos</option>
                                                <option value="20">20 Minutos</option>
                                                <option value="30">30 Minutos</option>
                                                <option value="40">40 Minutos</option>
                                                <option value="50">50 Minutos</option>
                                                <option value="60">1 Hora</option> <!-- sumar -->
                                            </select>
                                            <span id="selectTiempoMas" hidden = "">
                                        </div>
                                    </div>
                                </div>



                                <br>
                                <ul class="list-group list-group-horizontal-xl justify-content-md-center">
                                    <li class="list-inline-item">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="micheckbox custom-control-input" id="customSwitch1" checked>
                                            <label class="custom-control-label" for="customSwitch1"> Requiere Anestesia </label>
                                        </div>
                                        <span id="selectRadioAnestesista" hidden = "">SI</span> <!-- valor Radio -->
                                        <input value="SI" id="selectRadioAnestesistaa" hidden="">
                                    </li>
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-inline-item" hidden = "">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="aro custom-control-input" id="aro">
                                            <label class="text-dark custom-control-label" for="aro">ARCO EN C</label>
                                        </div>                                            
                                        <span id="selectArco" hidden="">NO</span> <!-- valor Radio -->
                                        <input value="NO" id="selectArcoo" hidden="">
                                    </li>
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-inline-item">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="uti custom-control-input" id="Uti">
                                            <label class="text-dark custom-control-label" for="Uti">UTI</label>
                                        </div>                                            
                                        <span id="selectUti" hidden="">NO</span> <!-- valor Radio -->
                                        <input value="NO" id="selectUtii" hidden="">
                                    </li>
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-inline-item">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="laparo custom-control-input" id="laparo">
                                            <label class="text-dark custom-control-label" for="laparo">LAPAROSCÓPICA</label>
                                        </div>                                            
                                        <span id="selectLaparo" hidden="">NO</span> <!-- valor Radio -->
                                        <input value="NO" id="selectLaparoo" hidden="">
                                    </li>
                                    
                                    <li class="list-inline-item">

                                    </li>
                                </ul>
                                
                                
                                <div class="row justify-content-md-center">
                                    <div class="col col-lg-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="ForP custom-control-input" id="ForP" >
                                            <label class="text-dark custom-control-label" for="ForP">FORCE TRIAD – LIGASURE (PROPIO)</label>
                                        </div> 
                                    </div>
                                    <div class="col-md-auto">
                                    
                                    </div>
                                    <div class="col col-lg-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="ForS custom-control-input" id="ForS">
                                            <label class="text-dark custom-control-label" for="ForS">FORCE TRIAD – LIGASURE (SANATORIO)</label>
                                        </div> 
                                    </div>
                                    <span id="selectforceProp" hidden="" >NO</span> <!-- valor Radio -->
                                    <span id="selectforceSana" hidden="" >NO</span> <!-- valor Radio -->
                                </div>

                                <br>
                                <ul class="list-group list-group-horizontal-xl justify-content-md-center">

                                    <div class="custom-control custom-switch">
                                        <li class="list-inline-item">
                                            <input type="checkbox" class="monitoreo custom-control-input" id="customSwitch2">
                                            <label class="custom-control-label text-dark" for="customSwitch2">Monitoreo Intraoperatorio</label>
                                            <i class="text-dark" id="selectRadioMonitoreo">NO</i>
                                            <input value="NO" id="selectRadioMonitoreoo" hidden="">
                                        </li>
                                        <li class="list-inline-item">ㅤㅤㅤㅤㅤㅤㅤ</li>

                                        <li class="list-inline-item">
                                            <input type="checkbox" class="rx custom-control-input" id="customSwitch3">
                                            <label class="text-dark custom-control-label" for="customSwitch3">Intensificador de imagen</label>
                                            <span id="selectRadioRX" class="text-dark">NO</span>
                                            <input value="NO" id="selectRadioRXx" hidden="">
                                        </li>
                                        <li class="list-inline-item">ㅤㅤㅤㅤㅤㅤㅤ</li>

                                        <li class="list-inline-item">
                                            <input type="checkbox" class="sangre custom-control-input" id="customSwitch4">
                                            <label class="text-dark custom-control-label" for="customSwitch4">Sangre</label>
                                            <span class="text-dark" id="selectRadioSangre">NO</span>
                                            <input value="NO" id="selectRadioSangree" hidden="">
                                        </li>                                        
                                    </div>
                                </ul>
                                
                                <ul class="list-group list-group-horizontal-xl">
                                    <li class="list-inline-item">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-inline-item" id="TS" style="display: none">Tipo de Sangre</li>
                                    <li class="list-inline-item" id="TSangre" style="display: none">
                                        <select class="sele custom-select" id="tipoSangre" name="tipoSangre" >
                                            <option value="0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</option>
                                            <option value="1">Tipo A</option>
                                            <option value="2">Tipo B</option>
                                            <option value="3">Tipo AB</option>
                                            <option value="4">Tipo O</option>
                                        </select>
                                    </li>
                                </ul>
                                
                                <div class="mx-auto " style="width: 30%;">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        
                                            <input checked type="radio" id="customRadioInline1" name="tipocirugia" class="custom-control-input" value = 1>
                                            <label class="text-dark custom-control-label" for="customRadioInline1">Para internar</label>
                                        
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        
                                        <input type="radio" id="customRadioInline2" name="tipocirugia" class="custom-control-input" value = 0>
                                        <label class="text-dark custom-control-label" for="customRadioInline2">Ambulatorio</label>
                                        
                                    </div>
                                        <span class="text-dark" id="selectRadiotipo_cirugia" hidden=""></span>
                                        <input value="1" id="selectRadiotipo_cirugiaa" hidden="">
                                </div> 
                               
                                <div class="mx-auto " style="width: 80%;">
                                <form class="was-validated">
                                <label for="exampleFormControlTextarea1">DIAGNOSTICO PREOPERATORIO y/o PROCEDIMIENTO A REALIZAR:</label>
                                            <textarea class="form-control is-invalid prevenir-envio" placeholder="Deberá escribir el/los nombre de los procedimientos que realizará en el Paciente
                                                Ej: • Hernioplastia umbilical con malla
                                                    • Osteosíntesis de fémur
                                                    • Histerectomía laparoscopica" id="tarea" rows="3" required></textarea>
                                </form>
                                </div> 
                                <br>
                                <div class="col text-center" id = "dosForm">
                                    <button type="button" class="btn btn-success" onclick="Confirmar()">CONFIRMAR</button> 
                                </div> 
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingOne" style="background-color:#03588C;">                    
                            <a class="btn btn-block text-white" type="button" onclick="Confirmar()" data-toggle="collapse" data-target="#collapseTwom" aria-expanded="true" aria-controls="collapseTwo">
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
                                                    $c = 0;
                                                    $menuDocumento = mysqli_query($conSanatorio, "SELECT tipodocumentoidentidad AS tipo, descripcion FROM tiposdocumentoidentidad WHERE neonatologia='0'");
                                                    while($row=mysqli_fetch_array($menuDocumento)) {
                                                    if ($c == 0){
                                                        $c = 1;?>
                                                        <option value="<?php echo $row['tipo']?>" selected="selected" > <?php echo $row['descripcion']?> </option>
                                                    <?php    
                                                    }else{?>
                                                        <option value="<?php echo $row['tipo']?>" > <?php echo $row['descripcion']?> </option>
                                                <?php } ?>
                                                    
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
                                    <li class="list-group-item border-0">
                                        <label for="">Numero</label>
                                        <form class="was-validated">
                                            <input type="number" maxlength="8" name="doc" class="form-control is-invalid prevenir-envio" id="doc" onblur="buscar_datos();" required>
                                        </form>
                                    </li>
                                    <li class="list-group-item border-0" hidden="" >
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
                                        <INPUT required type="text" class="form-control prevenir-envio" id="NomyApe"> 
                                    </li>
                                    <li class="list-group-item border-0">
                                        <label for="">Teléfono:</label>
                                        <INPUT type="number" maxlength="12" type="text" class="form-control" id="tel" required> 
                                    </li>
                                </ul>
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                                    <li class="list-group-item border-0 col-sm-5 col-md-3">
                                        <label for="">Email:</label>
                                        <INPUT type="email" class="form-control prevenir-envio" id="email"> 
                                    </li>
                                    <li class="list-group-item border-0">
                                        <label for="">Obra Social:</label>
                                        <br>
                                        <input type="text" class="form-control prevenir-envio" id='nombreObraSocial' size="70" onchange="camObra()">
                                        <input type="text" class="form-control" id='codigoObraSocial' hidden="">
                                    </li>
                                </ul>                             
                                <br>
                                <div class="col text-center" id = "dosForm">
                                    <button id="GuardarC" type="button" class="btn btn-success" onclick="GuardarConfirmar()">GUARDAR DATOS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!–– Fin Principal -->
            
            
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
</body>
<script type="text/javascript">
		$(document).ready(function () {
			var itemsObraSocial = <?= json_encode($arrayObraSocial) ?>;
            var itemsPractica = <?= json_encode($arrayPractica) ?>;

			$("#nombreObraSocial").autocomplete({
				source: itemsObraSocial,				
			});
            $("#nombrePractica1").autocomplete({
				source: itemsPractica,				
			});
            $("#nombrePractica2").autocomplete({
				source: itemsPractica,				
			});
            $("#nombrePractica3").autocomplete({
				source: itemsPractica,				
			});
		});
	</script>
<script>
    $(document).ready(function() {
        $('#ModalBucarPractica').DataTable({ 
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });
        $('.js-example-basic-single').select2();
        $('.js-quirofano').select2();
        $('.js-pra1-codigo').select2();
        $('.js-pra2-codigo').select2();
        $('.js-pra3-codigo').select2();

        const $elementos = document.querySelectorAll(".prevenir-envio");

        $elementos.forEach(elemento => {
            elemento.addEventListener("keydown", (evento) => {
                if (evento.key == "Enter") {
                    // Prevenir
                    evento.preventDefault();
                    return false;
                }
            });
        });
         
    });
</script>
<script src="funcionesNueva.js"></script>
</html>

