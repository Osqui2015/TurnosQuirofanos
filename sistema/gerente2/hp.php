<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
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
                              <option value="">ㅤㅤ</option>
                      <?php   } ?>
                  </select>
                  <span id="vMatricula" hidden = ""> <?php echo $matricula; ?> </span>
                  <script>
                      $('#profesional').on('change', function(){
                          var valor = this.value;
                          $('#vMatricula').text(valor);                                                                                                
                      })
                  </script>
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
          <br>
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
        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
</div>