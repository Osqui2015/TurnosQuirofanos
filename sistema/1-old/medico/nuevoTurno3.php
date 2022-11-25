<div class="jumbotron">
    <div class="card ">
        <div class="card-body">
            <fieldset class="border p-2 border">
                <legend  class="w-auto"></legend>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-Paciente-tab" data-toggle="tab" href="#nav-Paciente" role="tab" aria-controls="nav-Paciente" aria-selected="true">Datos del Paciente</a>
                        <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-Practicas" role="tab" aria-controls="nav-profile" aria-selected="false">Practicas</a>
                        <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-Ayudantes" role="tab" aria-controls="nav-contact" aria-selected="false">Ayudantes</a>
                        <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-Anestesista" role="tab" aria-controls="nav-contact" aria-selected="false">Anestesista</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <!–– Paciente -->
                    <div class="tab-pane fade show active" id="nav-Paciente" role="tabpanel" aria-labelledby="nav-Paciente-tab">
                        <fieldset class="border p-2 border">
                            <legend  class="w-auto"></legend>
                            <div class="center">
                                <div class="d-flex justify-content-center">
                                    <label for="">Tipo de Documento </label>
                                    <div class="col-2">
                                        <select class="custom-select" required id="menuDoc" required>
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
                                    </div>
                                    <label for="">Numero</label>
                                    <div class="col-4">
                                        <input type="text" name="doc" class="form-control is-invalid" id="doc" required>
                                    </div>
                                        <button id="bus" type="button" class="btn btn-primary" onclick="buscar_datos();">
                                            BUSCAR
                                        </button>
                                </div>
                                <br>
                                <div class="d-flex justify-content-center">
                                    <label for="">Nombre y Apellido:</label>
                                    <div class="col-5">
                                        <INPUT required type="text" class="form-control" id="NomyApe"> 
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex justify-content-center">
                                    <label for="">ㅤㅤ ㅤㅤTeléfono:</label>
                                    <div class="col-5">
                                        <INPUT required type="text" type="text" class="form-control" id="tel"> 
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex justify-content-center">
                                    <label for="">ㅤㅤㅤㅤㅤㅤEmail:</label>
                                    <div class="col-5">
                                        <INPUT type="email" class="form-control" id="email"> 
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex justify-content-center">
                                    <label for="">ㅤ ㅤ Obra Social:</label>
                                    <div class="col-5">
                                        <select required class="custom-select" id="menuObraSoc" >
                                            <option value=""></option>
                                            <?php 
                                                $menuDocumento = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(CodigoObraSocial)) AS Codigo,Descripcion,Deshabilitada FROM obrassociales WHERE web = '1' ORDER BY Descripcion ASC");
                                                while($row=mysqli_fetch_array($menuDocumento)) {
                                            ?>
                                                <?php if ($row['Deshabilitada'] == '1'): ?>
                                                   <!-- VALOR DEL Documento  <option value="DESHABILITADA" style="background:#F00; color: #fff;"><?php echo utf8_encode($row['Descripcion']) ?>  DESHABILITADA</option>  -->
                                                <?php else: ?>
                                                    <option value="<?php echo utf8_encode($row['Descripcion']) ?>"> <?php echo utf8_encode($row['Descripcion']) ?> </option>
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
                            </div>
                             
                            <br>
                            <div class="d-flex justify-content-center">
                                <div class="col">
                                    <label >ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</label>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="monitoreo custom-control-input" id="customSwitch2">
                                        <label class="custom-control-label text-dark" for="customSwitch2">Monitoreo</label>
                                        <i class="text-dark" id="selectRadioMonitoreo">No</i>
                                        <input value="No" id="selectRadioMonitoreoo" hidden="">
                                    </div>  
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="rx custom-control-input" id="customSwitch3">
                                        <label class="text-dark custom-control-label" for="customSwitch3">RX</label>
                                        <span id="selectRadioRX" class="text-dark">No</span>
                                        <input value="No" id="selectRadioRXx" hidden="">
                                    </div>  
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="sangre custom-control-input" id="customSwitch4">
                                        <label class="text-dark custom-control-label" for="customSwitch4">Sangre</label>
                                        <span class="text-dark" id="selectRadioSangre">No</span>
                                        <input value="No" id="selectRadioSangree" hidden="">
                                    </div>  
                                </div>                                                                
                            </div>
                            <br>
                            <div class="form-row" >
                                <div class="col-md-3 mb-3">
                                        <label >ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</label>
                                </div>
                                <div class="col-md-2 mb-2">
                                        <label > </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="tipocirugia" class="custom-control-input" value = 1>
                                    <label class="text-dark custom-control-label" for="customRadioInline1">Para internar</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="tipocirugia" class="custom-control-input" value = 0>
                                    <label class="text-dark custom-control-label" for="customRadioInline2">Ambulatorio</label>
                                </div>
                                    <span class="text-dark" id="selectRadiotipo_cirugia" hidden=""></span>
                                    <input value="0" id="selectRadiotipo_cirugiaa" hidden="">
                            </div>
                        </fieldset>

                        <fieldset class="border p-2 border">
                            <legend  class="w-auto ">Información de la Cirugía</legend> 
                            <div class="form-row" >
                                <div class="col-md-2 mb-2"> <!-- monitoreo -->
                                    <label >ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</label>
                                </div>
                                <div class="col-md-3 mb-3"> <!-- monitoreo -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="aro custom-control-input" id="aro" onchange = "ArC()">
                                        <label class="text-dark custom-control-label" for="customSwitch5">arco en c</label>
                                    </div>                                            
                                    <span id="selectArco" hidden="">No</span> <!-- valor Radio -->
                                    <input value="No" id="selectArcoo" hidden="">
                                </div>
                                <div class="col-md-3 mb-3" > <!-- monitoreo -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="uti custom-control-input" id="customSwitch6">
                                        <label class="text-dark custom-control-label" for="customSwitch6">Uti</label>
                                    </div>                                            
                                    <span id="selectUti" hidden="">No</span> <!-- valor Radio -->
                                    <input value="No" id="selectUtii" hidden="">
                                </div>

                                <div class="col-md-3 mb-3"> <!-- monitoreo -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="laparo custom-control-input" id="customSwitch7" onchange = "Lapachar()">
                                        <label class="text-dark custom-control-label" for="customSwitch7">LAPAROSCÓPICA</label>
                                    </div>                                            
                                    <span id="selectLaparo" hidden="">No</span> <!-- valor Radio -->
                                    <input value="No" id="selectLaparoo" hidden="">
                                </div>

                            </div>

                            <div class="form-row" >
                                <div class="col-md-2 mb-2"> <!--  -->
                                    <label >ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</label>
                                </div>
                                
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline3" name="FORCE" class="custom-control-input" value = 1>
                                    <label class="text-dark custom-control-label" for="customRadioInline3">FORCE TRIAD – LIGASURE (PROPIO)</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline4" name="FORCE" class="custom-control-input" value = 0>
                                    <label class="text-dark custom-control-label" for="customRadioInline4">FORCE TRIAD – LIGASURE (SANATORIO)</label>
                                </div>
                                    <span id="selectforceProp" hidden="">No</span> <!-- valor Radio -->
                                    <span id="selectforceSana" hidden="">No</span> <!-- valor Radio -->
                                    <input value="0" id="selectforceSanaa" hidden="">
                                    <input value="0" id="selectforcePropp" hidden="">

                                <div class="col-md-3 mb-3"> <!--  -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="intru custom-control-input" id="customSwitch10">
                                        <label class="text-dark custom-control-label" for="customSwitch10">INSTRUMENTISTA (PROPIO):</label>
                                    </div>                                            
                                    <span id="selectintru" hidden="">No</span> <!-- valor Radio -->
                                </div>

                            </div>
                            <br>
                            <div align ="center">
                                <label for="">INSUMOS NO HABITUALES:</label> 
                                <textarea class="form-control" id="InsumoNH" rows="2"></textarea>
                            </div>
                        </fieldset>    
                    </div>
                    <!–– Fin Paciente -->



                    <!–– Practicas -->
                    <div class="tab-pane fade" id="nav-Practicas" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                <th scope="col">Codigo</th>
                                <th cope="col">Practicas</th>
                                <th>Buscar</th>
                                <th>Quitar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> 
                                        <input type="text" class="form-control" id="codPrac1" name="valueInput"  readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="codDesc1" name="valueInput" readonly >
                                    </td>                                        
                                    
                                    <td>

                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td> 
                                        <input type="text" class="form-control" id="codPrac2" name="valueInput" readonly >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="codDesc2" name="valueInput" readonly >
                                    </td>                                        
                                    <!-- Button trigger modal -->
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPractica2">
                                            BUSCAR
                                        </button>
                                    </td>
                                    <td>Quitar</td>
                                </tr>
                                <tr>
                                    <td> 
                                        <input type="text" class="form-control" id="codPrac3" name="valueInput" readonly >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="codDesc3" name="valueInput" readonly >
                                    </td>                                        
                                    <!-- Button trigger modal -->
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPractica3">
                                            BUSCAR
                                        </button>
                                    </td>
                                    <td>Quitar</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!–– Ayudantes -->
                    <div class="tab-pane fade" id="nav-Ayudantes" role="tabpanel" aria-labelledby="nav-contact-tab">
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
                                <tr>
                                    <td><input type="text" class="form-control" id="matAyu1" name="valueInput" readonly></td>
                                    <td><input type="text" class="form-control" id="nomAyu1" name="valueInput" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAyudante1">
                                            BUSCAR
                                        </button>
                                    </td>
                                    <td>Quitar</td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="matAyu2" name="valueInput" readonly ></td>
                                    <td><input type="text" class="form-control" id="nomAyu2" name="valueInput" readonly ></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAyudante2">
                                            BUSCAR
                                        </button>
                                    </td>
                                    <td>Quitar</td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="matAyu3" name="valueInput" readonly></td>
                                    <td><input type="text" class="form-control" id="nomAyu3" name="valueInput" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAyudante3">
                                            BUSCAR
                                        </button>
                                    </td>
                                    <td>Quitar</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!–– Anestesista -->
                    <div class="tab-pane fade" id="nav-Anestesista" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                <th scope="col">Matricula</th>
                                <th cope="col">Anestecista</th>
                                <th>Buscar</th>
                                <th>Quitar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" id="anMat" name="valueInput" readonly ></td>
                                    <td><input type="text" class="form-control" id="anAyud" name="valueInput" readonly ></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAnestesista">
                                            BUSCAR
                                        </button>
                                    </td>
                                    <td>Quitar</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                   
                </div>
            </fieldset>
        </div>
    </div>
</div>
        

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
                                <td colspan="6">No hay datos para mostrar</td>
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
                                <td colspan="6">No hay datos para mostrar</td>
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
                                <td colspan="6">No hay datos para mostrar</td>
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
                                <td colspan="6">No hay datos para mostrar</td>
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
                                <td colspan="6">No hay datos para mostrar</td>
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
                                <td colspan="6">No hay datos para mostrar</td>
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



