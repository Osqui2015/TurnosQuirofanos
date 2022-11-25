<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
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
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta charset="utf-8">
</head>
<body style="background-color:#E9ECEE;">

<?php  include_once "menuMedicos.php" ?> <!–– Menu Medico -->      
           
<span id="vMatricula" hidden = ""> <?php echo $matricula; ?> </span>
<input hidden = "" id="vUserr" value = "<?php echo $userr; ?>"> </input>

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
                        <div class="card-header text-white h5" style="background-color:#03588C;">NUEVO TURNO DE QUIROFANO</div>
                        <div class="card-body">
                            <!--- Búsqueda de Quirofanos para turno------------------------->                                
                                <div class="form-row">
                                    <div class="col-md-3 mb-3"> <!-- VALOR DEL Quirofano -->
                                        <label><i><big>Quirofano</i></big></label>                                        
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
                                    </div>
                                    <div class="col-md-2 mb-2"> <!-- CÓDIGO DE PRACTICA y Tiempo -->
                                        <label> <i><big>Código</i></big> </label> 
                                        <input type="text" class="form-control" id="cod1Prac" readonly required>
                                        <span id="cod1Tiem" hidden = ""></span> <!-- valor hora inicio -->
                                        <span id="cod1Practica" hidden = ""></span> <!-- descripción practica -->
                                    </div>
                                    <div class="col-md-2.5 mb-3.5"> <!-- bot BUSCAR -->
                                        <br> 
                                        <button id="bb" type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPractica">
                                            BUSCAR
                                        </button>
                                    </div>           
                                    <div class="col-md-6 mb-6">  <!-- DESCRP DE PRACTICA -->
                                        <label> <i><big>Descripción </big></i></label> 
                                        <input type="text" class="form-control" id="cod1Desc" readonly>
                                        <span id="cod1Descripcion" hidden = ""></span> <!-- Descripcion practica -->
                                    </div>                                   
                                </div>
                                <div class="form-row center"> <!-- Practica --->
                                    <div class="col-md-2.5 mb-3"> <!-- VALOR FECHA -->
                                        <label for="validationDefault02"><i><big>Fecha:</i></big></label>
                                        <input onchange="fecha()" type="date" name="fechaSelec" id="fechaSelec" placeholder="Introduce una fecha" required disabled min=<?php $hoy=date("Y-m-d"); echo $hoy;?> />                                        
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
                                    </div>
                                    <div class="col-md-2 mb-3"> <!-- hora INICIO -->
                                        <label ><i><big>Hora de Inicio</i></big></label>
                                        <select id="Hinicio" class="sele custom-select" required>
                                            
                                        </select>
                                        <span id="selectHoraInicio" hidden = ""></span> <!-- valor hora inicio -->
                                    </div>
                                    <div class="col-md-2 mb-3"> <!-- hora fin -->
                                        <label for="validationDefault04"><i><big>Hora de Fin</i></big></label>                                        
                                            <input type="text" class="Hfin form-control" id="Hfin" name="Hfin" value="" readonly>
                                        <span id="selectHoraFin" class="selectHoraFinc" hidden = ""></span> <!-- valor hora fin -->
                                    </div>
                                    <div class="col-md-2 mb-3"> <!-- AGREGA TIEMPO -->
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
                                <div class="form-row"> <!-- ANESTESISTA -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="micheckbox custom-control-input" id="customSwitch1" checked>
                                        <label class="custom-control-label" for="customSwitch1"> Requiere Anestesia </label>
                                    </div>                                            
                                    <span id="selectRadioAnestesista" hidden = "">Si</span> <!-- valor Radio -->
                                    <input value="Si" id="selectRadioAnestesistaa" hidden="">
                                </div>
                                <br>
                                <div class="form-row">                                    
                                    <label for="exampleFormControlTextarea1">DIAGNOSTICO PREOPERATORIO:</label>
                                    <textarea class="form-control is-invalid" placeholder="Deberá escribir el/los nombre de los procedimientos que realizará en el Paciente
Ej: • Hernioplastia umbilical con malla
    • Osteosíntesis de fémur
    • Histerectomía laparoscopica" id="tarea" rows="3" required></textarea>      
                                </div>
                                <br>                                
                                <div class="form-row"><!-- Segunda Parte del Formulario-->
                                    <div class="col text-center" id="cont">
                                        <button type="button" class="btn btn-info"  onclick="showHide('oldNews')">CONTINUAR</button>
                                    </div> 
                                </div>                                                             
                                <br>
                                <div class="form-row" id="tabla">    <!-- Tabla de Turnos Ocupados-->                                    
                                    <div  class="col-lg-12" style="display: block;">
                                            <div id="select2lista">
                                            </div>
                                    </div>
                                </div>        
                                <div id="oldNews">
                                    <div>
                                        <?php include_once "NuevoTurno3.php" ?>
                                    </div>
                                </div>
                                <br> 
                                <div class="form-row"><!-- Segunda Parte del Formulario-->
                                    <div class="col text-center" id = "dosForm" style="display:none;">
                                        <button type="button" class="btn btn-success" onclick="confirmar()">CONFIRMAR TURNO</button>
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
                                    <td colspan="6">No hay datos para mostrar</td>
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
