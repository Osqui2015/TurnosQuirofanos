<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
$userr = $_SESSION['usuario']; /*VALOR USUARIO*/

require_once "../../conSanatorio.php";
$menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden") //order by Orden 

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

    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
</head>
<body style="background-color:#E9ECEE;">

<?php  include_once "menuAdmin.php" ?>    
           
<input hidden = "" id="vUserr" value = "<?php echo $userr; ?>"> </input> <!-- USUARIO -->

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
                    Profesional
                </li>
                <li class="list-group-item border-0">
                    <select style="width:450px" class="js-example-basic-single" id="profesional" name="profesional" required>
                        <option value="">???????????????????????????Seleccione???????????????????????????</option>
                        <?php 
                            $sql = "SELECT Matricula, Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre";
                            $result = mysqli_query($conSanatorio, $sql);
                            while($row = mysqli_fetch_array($result)){ ?>
                                <option value="<?php echo $row['Matricula'] ?>" ><?php echo $row['Matricula'] ?> | <?php echo utf8_encode($row['Nombre']) ?> </option>";
                                <option value="">??????</option>
                            <?php   } ?>
                    </select>
                    <span id="vMatricula" hidden = ""></span> <!-- MATRICULA -->
                    <script>
                        $('#profesional').on('change', function(){
                            var valor = this.value;
                            $('#vMatricula').text(valor);                            
                        })
                    </script>
                </li>
                <li class="list-group-item border-0"></li>
                <li class="list-group-item border-0"></li>
                <li class="list-group-item border-0">
                    <fieldset class="border p-2 border">
                        <legend  class="w-auto ">Practicas</legend>
                            <div class="table-responsive-sm">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td width="200"> 
                                                <input placeholder="Codigo" type="text" class="form-control" id="codPrac1" name="valueInput"  readonly>
                                            </td>
                                            <td width="900">
                                                <input placeholder="Descripcion" type="text" class="form-control" id="codDesc1" name="valueInput" readonly >
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
                                            <td width="900">
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
                            <span id="cod1Practica" hidden = ""></span> <!-- descripci??n practica -->
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

            <ul class="list-group list-group-horizontal-md">
                <li class="list-group-item border-0">
                    Quirofano??????????????????
                </li>
                <li class="list-group-item border-0">
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
                        })
                    </script>
                </li>
                <li class="list-group-item border-0"></li>
            </ul>

            <ul class="list-group list-group-horizontal-lg">
                <li class="list-group-item border-0">
                    Fecha???????????????????????????
                </li>
                <li class="list-group-item border-0">
                    <input onchange="fecha()" type="date" name="fechaSelec" id="fechaSelec" placeholder="Introduce una fecha" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> />
                    <span id="selecFecha" hidden = ""></span> <!-- VALOR FECHA -->
                    <script>
                        $('#menuQuirofano').on('change', function(){
                            var valor = this.value;
                            $('#selecFecha').text(valor);
                            fecha();
                        })
                    </script>
                </li>
                <li class="list-group-item border-0"></li>
            </ul>
            <br>
            <ul class="list-group list-group-horizontal-xl">
                <li class="list-group-item border-0">????????????????????????????????????????????????????????????????????????</li>
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
                        <li class="list-inline-item">Hora de Inicio</li>
                        <li class="list-inline-item col-sm-2">
                            <select id="Hinicio" class="sele custom-select" required>
                            </select>
                            <span id="selectHoraInicio" hidden=""></span> <!-- valor hora inicio -->
                        </li>
                        <li class="list-inline-item"> <span id="selectHoraInicio" hidden = ""></span> </li>

                        <li class="list-inline-item">Hora de Fin</li>
                        <li class="list-inline-item col-sm-2">
                            <input type="text" class="Hfin form-control" id="Hfin" name="Hfin" value="" readonly>                            
                        </li>
                        <li class="list-inline-item"> 
                            <span id="selectHoraFin" hidden=""></span> <!-- valor hora fin -->
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
                        <li class="list-inline-item">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="micheckbox custom-control-input" id="customSwitch1" checked>
                                <label class="custom-control-label" for="customSwitch1"> Requiere Anestesia </label>
                            </div>
                            <span id="selectRadioAnestesista" hidden = "">SI</span> <!-- valor Radio -->
                            <input value="SI" id="selectRadioAnestesistaa" hidden="">
                        </li>

                        <li class="list-inline-item">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="aro custom-control-input" id="aro" onchange = "ArC()">
                                <label class="text-dark custom-control-label" for="aro">ARCO EN C</label>
                            </div>                                            
                            <span id="selectArco" hidden="">NO</span> <!-- valor Radio -->
                            <input value="NO" id="selectArcoo" hidden="">
                        </li>

                        <li class="list-inline-item">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="uti custom-control-input" id="Uti">
                                <label class="text-dark custom-control-label" for="Uti">UTI</label>
                            </div>                                            
                            <span id="selectUti" hidden="">NO</span> <!-- valor Radio -->
                            <input value="NO" id="selectUtii" hidden="">
                        </li>

                        <li class="list-inline-item">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="laparo custom-control-input" id="laparo" onchange = "Lapachar()">
                                <label class="text-dark custom-control-label" for="laparo">LAPAROSC??PICA</label>
                            </div>                                            
                            <span id="selectLaparo" hidden="">NO</span> <!-- valor Radio -->
                            <input value="NO" id="selectLaparoo" hidden="">
                        </li>
                        
                        <li class="list-inline-item">

                        </li>
                    </ul>                                            
                
                <br>
                
                <div class="d-flex justify-content-center">
                    <ul class="list-inline">

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="ForP custom-control-input" id="ForP" >
                                <label class="text-dark custom-control-label" for="ForP">FORCE TRIAD ??? LIGASURE (PROPIO)</label>
                            </div> 
                            <div class="custom-control custom-switch">                                                                                                               
                                <input type="checkbox" class="ForS custom-control-input" id="ForS">
                                <label class="text-dark custom-control-label" for="ForS">FORCE TRIAD ??? LIGASURE (SANATORIO)</label>
                            </div> 


                        <span id="selectforceProp" hidden="" >NO</span> <!-- valor Radio -->
                        <span id="selectforceSana" hidden="" >NO</span> <!-- valor Radio -->
                        <input value="NO" id="selectforceSanaa" hidden="">
                        <input value="NO" id="selectforcePropp" hidden="">
                        <!--  -->
                    </ul>
                </div>
                
                <br>
               
                    <div class="custom-control custom-switch">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <input type="checkbox" class="monitoreo custom-control-input" id="customSwitch2">
                                <label class="custom-control-label text-dark" for="customSwitch2">Monitoreo</label>
                                <i class="text-dark" id="selectRadioMonitoreo">NO</i>
                                <input value="NO" id="selectRadioMonitoreoo" hidden="">
                            </li>
                            <li class="list-inline-item">?????????????????????</li>

                            <li class="list-inline-item">
                                <input type="checkbox" class="rx custom-control-input" id="customSwitch3">
                                <label class="text-dark custom-control-label" for="customSwitch3">RX</label>
                                <span id="selectRadioRX" class="text-dark">NO</span>
                                <input value="NO" id="selectRadioRXx" hidden="">
                            </li>
                            <li class="list-inline-item">?????????????????????</li>

                            <li class="list-inline-item">
                                <input type="checkbox" class="sangre custom-control-input" id="customSwitch4">
                                <label class="text-dark custom-control-label" for="customSwitch4">Sangre</label>
                                <span class="text-dark" id="selectRadioSangre">NO</span>
                                <input value="NO" id="selectRadioSangree" hidden="">
                            </li>
                            <li class="list-group-item border-0">
                                ??????????????????
                            </li>
                            <li class="list-group-item border-0">
                                <!-- tipo de sangre --->
                            </li>
                            <li class="list-group-item border-0">
                                <!-- select --->
                            </li>
                        </ul>
                    </div>
                
                <br>
                    <div class="d-flex justify-content-center">
                        <ul class="list-inline">
                            <div class="custom-control custom-radio custom-control-inline">
                                <li class="list-inline-item">
                                    <input checked type="radio" id="customRadioInline1" name="tipocirugia" class="custom-control-input" value = 1>
                                    <label class="text-dark custom-control-label" for="customRadioInline1">Para internar</label>
                                </li>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <li class="list-inline-item">
                                    <input type="radio" id="customRadioInline2" name="tipocirugia" class="custom-control-input" value = 0>
                                    <label class="text-dark custom-control-label" for="customRadioInline2">Ambulatorio</label>
                                </li>
                                <span class="text-dark" id="selectRadiotipo_cirugia" hidden=""></span>
                                <input value="1" id="selectRadiotipo_cirugiaa" hidden="">
                            </div>
                        </ul>
                    </div>
                <br>
                <div class="d-flex justify-content-center">
                        <label for="exampleFormControlTextarea1">DIAGNOSTICO PREOPERATORIO:</label>
                    <textarea class="form-control is-invalid" placeholder="Deber?? escribir el/los nombre de los procedimientos que realizar?? en el Paciente
                        Ej: ??? Hernioplastia umbilical con malla
                            ??? Osteos??ntesis de f??mur
                            ??? Histerectom??a laparoscopica" id="tarea" rows="3" required></textarea>
                </div>
            </fieldset>

            <br>
            <br>

            <fieldset class="border p-2 border">
                <legend  class="w-auto ">Paciente</legend>                
                    <ul class="list-group list-group-horizontal-sm">
                        <li class="list-group-item border-0">?????????????????????</li>
                            <li class="list-group-item border-0">
                                <label for="">Tipo de Documento </label>
                                    <select   select class="custom-select" required id="menuDoc" required>
                                        <option value=""></option>
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
                                <input type="number" maxlength="8" name="doc" class="form-control is-invalid" id="doc" required>
                            </li>
                            <li class="list-group-item border-0">
                                <label> ??????</label>
                                <button id="bus" type="button" class="btn btn-primary" onclick="buscar_datos();">
                                        BUSCAR
                                </button>
                            </li>
                    </ul>
                    <ul class="list-group list-group-horizontal-sm">
                        <li class="list-group-item border-0">?????????????????????</li>
                        <li class="list-group-item border-0">
                            <label for="">Nombre y Apellido:??????????????????????????????????????????</label>                                                       
                            <INPUT required type="text" class="form-control" id="NomyApe"> 
                        </li>
                        <li class="list-group-item border-0">
                            <label for="">Tel??fono:</label>
                            <INPUT type="number" maxlength="12" type="text" class="form-control" id="tel" required> 
                        </li>
                    </ul>
                    <ul class="list-group list-group-horizontal-md">
                        <li class="list-group-item border-0">?????????????????????</li>
                        <li class="list-group-item border-0">
                            <label for="">Email:</label>
                            <INPUT type="email" class="form-control" id="email"> 
                        </li>
                        <li class="list-group-item border-0">
                            <label for="">Obra Social:</label>
                                <select class="js-example-basic-single" name="state" id="menuObraSoc" >                                        
                                    <option value="">??????????????????Seleccione??????????????????</option>
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
                <button type="button" class="btn btn-success" onclick="GuardarDatos()">GUARDAR DATOS</button>
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
                                <th> C??digo </th>
                                <th> Descripci??n </th>
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
                            <th> C??digo </th>
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