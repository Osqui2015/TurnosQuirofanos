<?php
    session_start();
    //echo $_SESSION['tipo'];
    if(!empty($_SESSION['active'])){
        
    }else{
        header('location: ../../index.php');
    }

    require_once "../../conUsuario.php";
    require_once "../../conSanatorio.php";

    $menQuirofano = mysqli_query($conSanatorio, "SELECT * FROM Quirofanos WHERE web='1' ORDER BY orden") //order by Orden 

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php  include_once "dependencias.php" ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <title>Administración Gerencia</title>
  </head>
  <body>
  <input hidden = "" id="vUserr" value = "<?php echo $_SESSION['nombre'] ?>"> </input>
    <?php  include_once "menuGerente.php" ?>
   <br><br>
   
<div class="accordion" id="accordionExample">
  <div class="accordion-item" >
    <h2 class="accordion-header" id="headingOne" >
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Nuevo Turno
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div class="container">
          <div class="row justify-content-start">
              <div class="col-md-4">
                  <select style="width:450px" class="js-select-Doctor" id="profesional" name="profesional" required>
                      <option value="">ㅤㅤㅤㅤㅤㅤㅤㅤㅤSeleccioneㅤㅤㅤㅤㅤㅤㅤㅤㅤ</option>
                      <?php 
                          $sql = "SELECT Matricula, Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre";
                          $result = mysqli_query($conSanatorio, $sql);
                          while($row = mysqli_fetch_array($result)){ ?>
                              <option value="<?php echo $row['Matricula'] ?>" ><?php echo $row['Matricula'] ?> | <?php echo utf8_encode($row['Nombre']) ?> </option>";
                             
                      <?php   } ?>
                  </select>                  
              </div>
          </div>
          <br>
          <div class="row">
              <div class="col-md-1">Fecha</div>
              <div class="col">
                  <input onchange="fechaTurno()" type="date" name="fechaSelec" id="fechaSelec" placeholder="Introduce una fecha" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> />
              </div>

              <div class="col-md-1">Quirófano</div>        
              <div class="col">
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
              </div>

              <div class="col-md-1">Practica 1</div>
              <div class="col-md-5">
                  <div class="row">
                      <div class="col-md">
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
                      </div>
                      <div class="col-1"></div>
                      <div class="col-1">
                          <button id="mostrar2" type="button" class="btn btn-success"><i class="bi bi-plus-circle-fill">+</i></button>
                      </div>
                  </div>
              </div>
          </div>
          <br>
          <div class="row d-flex justify-content-end">
              <div class="col-md-1">Practica 2</div>
              <div class="col-md-5">
                  <div class="row">
                      <div class="col">
                          <select class="js-pra2-codigo form-control form-control-lg" name="state" id="codPrac2" onchange = "tiempopractica()">
                              <option value=""> <p class="text-justify"> ㅤCÓDIGOㅤㅤㅤㅤㅤㅤ DESCRIPCIÓNㅤ</p> </option>
                                  <?php  
                                  
                                      $pracBusc2 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo, SUBSTRING(Descripcion,1,50) AS Descripcion2, Descripcion, TiempoEstimado 
                                      FROM practicasquirofano
                                      WHERE web = 0 AND TiempoEstimado > 0");
                                      while($row=mysqli_fetch_array($pracBusc2)) {
                                  ?>
                                      <option value="<?php echo utf8_encode($row['Codigo']) ?>"> <p class="text-justify"> <?php echo utf8_encode($row['Codigo']) ?>ㅤㅤㅤㅤ ||ㅤㅤㅤㅤ <?php echo utf8_encode(substr($row['Descripcion'], 0, 60));  ?> </p> </option>

                                  <?php }?>
                          </select>
                      </div>
                      <div class="col-md-1">
                          <button id="cerrar2" type="button" class="btn btn-danger"><i class="bi bi-plus-circle-fill">x</i></button>
                      </div>
                      <div class="col-1">
                          <button id="mostrar3" type="button" class="btn btn-success"><i class="bi bi-plus-circle-fill">+</i></button>
                      </div>
                  </div>
              </div>
          </div>
          <br>
          <div class="row d-flex justify-content-end">
              <div class="col-md-1">Practica 3</div>
              <div class="col-md-5">
                  <div class="row">
                      <div class="col">
                          <select class="js-pra3-codigo form-control form-control-lg" name="state" id="codPrac3" onchange = "tiempopractica()">
                              <option value=""> <p class="text-justify"> ㅤCÓDIGOㅤㅤㅤㅤㅤㅤ DESCRIPCIÓNㅤ</p> </option>
                                  <?php  
                                  
                                      $pracBusc3 = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(Codigo)) AS Codigo, SUBSTRING(Descripcion,1,50) AS Descripcion2, Descripcion, TiempoEstimado 
                                      FROM practicasquirofano
                                      WHERE web = 0 AND TiempoEstimado > 0");
                                      while($row=mysqli_fetch_array($pracBusc3)) {
                                  ?>
                                      <option value="<?php echo utf8_encode($row['Codigo']) ?>"> <p class="text-justify"> <?php echo utf8_encode($row['Codigo']) ?>ㅤㅤㅤㅤ ||ㅤㅤㅤㅤ <?php echo utf8_encode(substr($row['Descripcion'], 0, 60));  ?> </p> </option>

                                  <?php }?>
                          </select>
                      </div>
                      <div class="col-md-1">
                          <button id="cerrar3" type="button" class="btn btn-danger"><i class="bi bi-plus-circle-fill">x</i></button>
                      </div>
                      <div class="col-md-1">
                          
                      </div>
                  </div>
              </div>
          </div>
          <br>
          <div class="row justify-content-center">
              <div class="card">
                      <!-- <img class="img-fluid" src="../../images/diagrama.png" /> -->
                      <div class="table-responsive">
                          <?php  include_once "tablaquir.php" ?>
                      </div>
                      <p class="text-break text-center alert alert-info"  role="alert">La prioridad de programación según el esquema presentado en la tabla rige hasta las 14 horas de cada día, luego la programación es libre en todos los quirófanos.</p>
              </div>
          </div>
          <br>
          <div class="mx-auto" style="width: 75%;">
              <div id="select2lista">
              </div>
          </div>
          <br>
          <div class="row justify-content-center">
              <div class="card">
                  <div id='tp' class="mx-auto">
          
                  </div>
              </div>
          </div>
          <br>
          <div class="row justify-content-md-center text-right">
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
          <br>
          <ul class="list-group list-group-horizontal-xl justify-content-md-center">
              <li class="list-inline-item">
                  <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="Anestesia" onchange="anestesia()" checked>
                      <label class="custom-control-label" for="Anestesia"> Requiere Anestesia </label>
                  </div>                  
              </li>
              <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
              <li class="list-inline-item" hidden = "">
                  <div class="custom-control custom-switch">
                      <input type="checkbox" class="aro custom-control-input" id="aro">
                      <label class="text-dark custom-control-label" for="aro">ARCO EN C</label>
                  </div>
              </li>
              <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
              <li class="list-inline-item">
                  <div class="custom-control custom-switch">
                      <input type="checkbox" class="uti custom-control-input" id="Uti" onchange="Uti()">
                      <label class="text-dark custom-control-label" for="Uti">UTI</label>
                  </div>                                            
                  <span id="selectUti" hidden="">NO</span> <!-- valor Radio -->
                  <input value="NO" id="selectUtii" hidden="">
              </li>
              <li class="list-group-item border-0">ㅤㅤㅤㅤㅤㅤㅤ</li>
              <li class="list-inline-item">
                  <div class="custom-control custom-switch">
                      <input type="checkbox" class="laparo custom-control-input" id="laparo" onchange="laparo()">
                      <label class="text-dark custom-control-label" for="laparo">LAPAROSCÓPICA</label>
                  </div>
              </li>
              
              <li class="list-inline-item">

              </li>
          </ul>
          <br>
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
                      <input type="checkbox" class="monitoreo custom-control-input" id="Monitoreo" onchange="Monitoreo()">
                      <label class="custom-control-label text-dark" for="Monitoreo">Monitoreo Intraoperatorio</label>                      
                  </li>
                  <li class="list-inline-item">ㅤㅤㅤㅤㅤㅤㅤ</li>

                  <li class="list-inline-item">
                      <input type="checkbox" class="rx custom-control-input" id="Intensificador" onchange="Intensificador()">
                      <label class="text-dark custom-control-label" for="Intensificador">Intensificador de imagen</label>
                  </li>
                  <li class="list-inline-item">ㅤㅤㅤㅤㅤㅤㅤ</li>

                  <li class="list-inline-item">
                      <input type="checkbox" class="sangre custom-control-input" id="Sangre" onchange="Sangre()">
                      <label class="text-dark custom-control-label" for="Sangre">Sangre</label>
                  </li>                                        
              </div>
          </ul>
          <br>
          <div class="mx-auto " style="width: 30%;">
              <div class="custom-control custom-radio custom-control-inline">                 
                      <input checked type="radio" id="customRadioInline1" name="tipocirugia" class="custom-control-input" value = "1" >
                      <label class="text-dark custom-control-label" for="customRadioInline1">Para internar</label>                  
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                  
                  <input type="radio" id="customRadioInline2" name="tipocirugia" class="custom-control-input" value = "0" >
                  <label class="text-dark custom-control-label" for="customRadioInline2">Ambulatorio</label>
                  
              </div>                  
          </div> 
          <br>
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
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Datos Paciente
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        
        <div class="row text-right">
            <div class="col">Tipo de Documento</div>
            <div class="col">
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
            </div>
            <div class="col">Numero</div>
            <div class="col-3">
                <form class="was-validated">
                    <input type="number" maxlength="8" name="doc" class="form-control is-invalid prevenir-envio" id="doc" onblur="buscar_datos();" required>
                </form>
            </div>
            <div class="col-5"> </div>
        </div>
        <br>
        
        <br>

        <div class="row text-right">
            <div class="col">Telefono</div>
            <div class="col">
                <INPUT type="number" maxlength="12" class="form-control" id="tel" required> 
            </div>
            <div class="col">Nombre y Apellido</div>
            <div class="col-3">
                <INPUT required type="text" class="form-control prevenir-envio" id="NomyApe"> 
            </div>
            <div class="col-5"> </div>
        </div>
        <br>

        <div class="row text-right">
            <div class="col">Email</div>
            <div class="col-md">
                <INPUT type="email" class="form-control prevenir-envio" id="email"> 
            </div>
            <div class="col">Obra Social</div>
            <div class="col-md-3">
                <select class="js-example-basic-single" name="state" id="menuObraSoc" >                                        
                            <option value="">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤSeleccioneㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</option>
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
            </div>
            <div class="col-5"> </div>
        </div>
        <br>
        <div class="col text-center" id = "dosForm">
            <button type="button" class="btn btn-success" onclick="GuardarConfirmar()">GUARDAR DATOS</button>
        </div>
        
</div>

        
      
        
      </div>
    </div>
  </div>
</div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#ModalBucarPractica').DataTable({ 
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                }
            });
            $('.js-example-basic-single').select2();
            $('.js-select-Doctor').select2();
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
  </body>
</html>