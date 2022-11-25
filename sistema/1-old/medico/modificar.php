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
        $uti = $mod['Uti'];
        $laparo = $mod['Laparoscopica'];
        $intruPro = $mod['Instrumentista_Propio'];
        $insumo = $mod['InsumosNoHabituales'];
        $email = $mod['Email'];
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
<script>
    $(document).ready(function(){
        fecha()
    });
</script>
<?php  include_once "menuMedicos.php" ?> <!–– Menu Medico -->
<span id="vMatricula" hidden = ""> <?php echo $matricula; ?> </span>
<input value="<?php echo $numero ?>" id="nNumero" hidden="">
                    <div class="accordion" id="acorTabla">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block " type="button" data-toggle="collapse" data-target="#cTabla" aria-expanded="true" aria-controls="cPracticas">                                            
                                        Mostrar / Ocultar
                                    </button>
                                </h2>
                            </div>

                            <div id="cTabla" class="collapse show" aria-labelledby="headingOne" data-parent="#acorTabla">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php  include_once "tablaquir.php" ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
       <br>
<!–– Principal --> 

<div class="card-body">
    <div class="accordion" id="accordionExample">
        <!-- Fecha y Quirofano -->
        <div class="card">
            <div class="card-header" id="headingOne" style="background-color:#03588C;">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-center text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                       <h4>FECHA Y QUIROFANO</h4>
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <ul class="list-group list-group-horizontal">
                    </ul>
                    <ul class="list-group list-group-horizontal-sm ">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
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
                        </li>
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
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
                        </li>
                    </ul>

                    <ul class="list-group list-group-horizontal-md">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
                            <label> <i><big>Código</i></big> </label> 
                            <input type="text" class="form-control" id="cod1Prac" value="<?php echo $cod1Q[0] ?> "readonly required>
                            <span id="cod1Tiem" hidden = ""> <?php echo $tiempoQ ?> </span> <!-- valor hora inicio -->
                            <span id="cod1Practica" hidden = ""> <?php echo $cod1Q[0] ?> </span> <!-- descripción practica -->
                        </li>
                        <li class="list-group-item border-0">
                            <label>ㅤㅤㅤ</label>
                            <button id="bb" type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPractica">
                                BUSCAR
                            </button>
                        </li>
                        <li class="list-group-item border-0">
                            <label> <i><big>Descripción ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</big></i></label> 
                            <input type="text" class="form-control" id="cod1Desc" value ="<?php echo  utf8_encode($desc1Q[0]) ?>" readonly>
                            <span id="cod1Descripcion" hidden = ""></span> <!-- Descripcion practica -->
                        </li>
                    </ul>

                    <ul class="list-group list-group-horizontal-lg">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
                            <label ><i><big>Hora de Inicioㅤㅤㅤㅤ</i></big></label>  
                            <h6><span id="selectHoraInicio" ><?php echo substr($horaI , 11, -3) ?></span></h6> <!-- valor hora inicio -->
                            <select id="Hinicio" class="sele custom-select" required>
                                    <option value="<?php echo substr($horaI , 11, -3) ?>" > <?php echo substr($horaI , 11, -3) ?></option>
                            </select>
                        </li>
                        <li class="list-group-item border-0">
                            <label for="validationDefault04"><i><big>Hora de Fin</i></big></label>                                        
                            <input type="text" class="Hfin form-control" id="Hfin" name="Hfin" value="<?php echo substr($horaF , 11, -3) ?>" readonly>
                            <span id="selectHoraFin" class="selectHoraFinc" hidden = ""> <?php echo substr($horaF , 11, -3) ?> </span> <!-- valor hora fin -->
                        </li>
                        <li class="list-group-item border-0">
                            <label> <i><big>  Agregar Tiempo ㅤㅤㅤㅤㅤㅤㅤㅤ</i></big> </label> 
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
                        </li>
                    </ul>

                    <ul class="list-group list-group-horizontal-xl">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
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
                        <li class="list-group-item border-0">ㅤ</li>
                    </ul>

                    <ul class="list-group list-group-horizontal-xl">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
                            <label for="exampleFormControlTextarea1">DIAGNOSTICO PREOPERATORIO:ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</label>
                            <textarea class="form-control is-invalid" placeholder="Deberá escribir el/los nombre de los procedimientos que realizará en el Paciente
                            Ej: • Hernioplastia umbilical con malla
                                • Osteosíntesis de fémur
                                • Histerectomía laparoscopica" id="tarea" rows="3" value= required> <?php echo $tareaQ ?> </textarea> 
                        </li>
                        <li class="list-group-item border-0">ㅤ</li>
                    </ul>

                    <ul class="list-group list-group-horizontal-xl">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
                            <div id="select2lista"></div>
                        </li>
                        <li class="list-group-item border-0">ㅤ</li>
                    </ul>

                </div>
            </div>
        </div>
        <!-- Practicas -->
        <div class="card">
            <div class="card-header" id="headingThree" style="background-color:#03588C;">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-center text-white collapsed" type="button" data-toggle="collapse" data-target="#collapsefor" aria-expanded="false" aria-controls="collapsefor">
                   <h4>Practicas</h4> 
                </button>
            </h2>
            </div>
            <div id="collapsefor" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
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
            </div>
        </div>
        <!-- Paciente -->
        <div class="card">
            <div class="card-header" id="headingTwo" style="background-color:#03588C;">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-center text-white collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h4>Paciente</h4>
                </button>
            </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <ul class="list-group list-group-horizontal-sm">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                            <li class="list-group-item border-0">
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
                            <li class="list-group-item border-0">
                                <label for="">Numero</label>                                    
                                <input type="text" name="doc" class="form-control is-invalid" id="doc" value="<?php echo $dniQ ?>">
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
                                <label for="">Nombre y Apellido:ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</label>                                                       
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
                            </li>
                        </ul>

                        <ul class="list-group list-group-horizontal-lg">
                            <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                            <li class="list-group-item border-0">
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
                            <li class="list-group-item border-0">
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
                            <li class="list-group-item border-0">
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
                        </ul>

                        <ul class="list-group list-group-horizontal-xl">
                            <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                            <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                            <li class="list-group-item border-0">

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

                            </li>
                            <li class="list-group-item border-0"></li>
                    </ul>
                
                </div>
            </div>
        </div>
        <!-- Fecha y Quirofano -->
        <div class="card">
            <div class="card-header" id="headingThree" style="background-color:#03588C;">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-center text-white collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <h4>Informacion de Cirugia</h4>
                </button>
            </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                
                    <ul class="list-group list-group-horizontal-sm">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
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
                        <li class="list-group-item border-0">
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
                        <li class="list-group-item border-0">
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

                    <ul class="list-group list-group-horizontal-md">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">

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

                        </li>
                        
                    </ul>

                    <ul class="list-group list-group-horizontal-lg">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
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
                        </li>
                    </ul>

                    <ul class="list-group list-group-horizontal-xl">
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
                        <li class="list-group-item border-0">
                            <label for="">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤINSUMOS NO HABITUALES:ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</label> 
                            <textarea value="<?php echo $insumo ?>" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
</div>

    <div class="card text-center">
    
    <div class="card-body">
            <button type="button" class="btn btn-secondary" onclick="CancelarMod()"><h4>CANCELAR</h4></button>
            <button type="button" class="btn btn-success" onclick="confirmarM()"><h4>CONFIRMAR MODIFICACIÓN DE TURNO</h4></button>
    </div>
    
    </div>







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