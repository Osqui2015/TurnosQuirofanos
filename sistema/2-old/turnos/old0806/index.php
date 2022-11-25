<?php
session_start();
// echo $_SESSION['tipo'];

require_once "../../conSanatorio.php";
$query = mysqli_query($conSanatorio, "SELECT tq.Numero,
tq.Estado,
DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fechas, 
DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin, 
CASE DAYOFWEEK(tq.Fecha)
     WHEN 1 THEN 'Domingo'
    WHEN 2 THEN 'Lunes'
    WHEN 3 THEN 'Martes'
    WHEN 4 THEN 'Miércoles'
    WHEN 5 THEN 'Jueves'
    WHEN 6 THEN 'Viernes'
     WHEN 7 THEN 'Sábado'
     END Dia,
tq.Nombre AS Paciente,
p.Matricula,
p.Nombre,
pq.Descripcion,
q.Descripcion AS Quirofano
FROM turnosquirofano AS tq 
INNER JOIN profesionales AS p ON tq.MatriculaProfesional = p.Matricula
INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano
INNER JOIN turnosquirofanospracticas AS tp ON tq.Numero = tp.Numero 
INNER JOIN practicasquirofano AS pq ON pq.Codigo = tp.CodigoPractica
WHERE Fecha = CURDATE() and Estado = 'Pendiente'
GROUP BY tq.numero");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema Turnos</title>
    <?php  include_once "dependencias.php" ?>
    <link rel="icon" href="../../imagen/modelo.jpg">


    <!--  Datatables  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    
    <!-- searchPanes -->
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchPanes.dataTables.min.css">
    <!-- select -->
    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">


</head>
<body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
            <!–– menu -->
             <?php  include_once "menuAdmin.php" ?>
            <!–– fin menu -->
            <div style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
                <!–– Principal -->
                <div class="card">
                    <h5 class="card-header">turnos de hoy</h5>
                    <div class="card-body">
                        <table class="display compact table table-hover table-condensed" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>E</th>
                                    <th>Dia</th>
                                    <th>Fecha</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Paciente</th>
                                    <th>Practica </th>
                                    <th>Quirofano</th>
                                    <th>Matricula</th>
                                    <th>Doctor</th>
                                    <th>Modif.</th>
                                    <th>Susp.</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row=mysqli_fetch_array($query)) {
                                     $numero_turno = $row['Numero'];
                                    ?>
                                    <tr>
                                    <td class="text-white">  <?php echo $row['Estado'][0] ?></td>                       
                                        <td> <?php echo $row['Dia'];?> </td> 
                                        <td> <?php echo $row['Fechas']?> </td>
                                        <td> <?php echo $row['HoraInicio'] ?> </td>
                                        <td> <?php echo $row['HoraFin'] ?> </td>
                                        <td> 
                                            <?php echo $row['Paciente'] ?>
                                            <!-- <?php 
                                                $numero_turno = $row['numero']; 
                                                $rr = mysqli_query($conSanatorio,"SELECT Numero,
                                                Nombre, 
                                                tur.TipoDocumentoIdentidad, 
                                                tip.Descripcion AS Tipo_Documento, 
                                                DniPaciente, 
                                                ObraSocial, 
                                                Telefono
                                                FROM turnosquirofano AS tur 
                                                LEFT JOIN tiposdocumentoidentidad AS tip 
                                                ON tip.TipoDocumentoIdentidad=tur.TipoDocumentoIdentidad  
                                                WHERE numero = $numero_turno");
                                                $r = mysqli_fetch_array($rr)
                                            ?>
                                                <div class="hover"> 
                                                    <?php echo $row['Paciente'] ?>
                                                    <span class="tooltip">                                                             
                                                        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">                                            
                                                            <div class="card-body">
                                                                <u><b> Datos del Paciente: </b></u> <br> 
                                                                <b> DNI: </b> <?php echo $r['DniPaciente']?> <br>
                                                                <b>Teléfono:</b> <?php echo $r['Telefono']?> <br>
                                                                <b>ObraSocial:</b> <?php echo $r['ObraSocial']?> <br>                                               
                                                            </div>
                                                        </div>
                                                    </span>                                    
                                                </div>  -->                          
                                        </td>
                                        <td ><?php echo utf8_encode($row['Descripcion']) ?></div></td>
                                        <td><?php echo $row['Quirofano']; ?></td>                        
                                        <td> <?php echo $row['Matricula']; ?></td>
                                        <td><?php echo $row['Nombre']; ?></td>

                                        <?php if ($row['Estado'][0] == "P"){ ?>
                                            <td>
                                                <span id="numero" hidden=""><?php echo $row['Numero'] ?></span>                        
                                                <button type="button" class="btn btn-warning btn-sm" onclick="Modificar(<?php echo $row['Numero']?>)"> <img  src="../../images/pencil-square.svg"></img> </button>                                                             
                                            </td> 
                                            <td>   
                                                <!-- <button type="button" class="btn btn-danger btn-sm" onclick="Suspenderr(<?php echo $row['Numero']?>)"> <img  src="../../images/x-octagon-fill.svg"></img> </button> ---    -->

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" onclick="Sus(<?php echo $row['Numero']?>)" >
                                                    x
                                                </button>
                                                
                                            </td>
                                        <?php } else{ ?>
                                            <td> 
                                            </td>
                                            <td>                                   
                                            </td>
                                        <?php } ?>  


                                    </tr>
                                    <?php
                                    }//Fin while
                                // 
                                    
                                    ?>                                                
                            </tbody>                
                        </table
                    </div>
                </div>
                
                <!–– Fin Principal -->
            </div>
       
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
                
        <!--   Datatables-->
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  

        <!-- searchPanes   -->
        <script src="https://cdn.datatables.net/searchpanes/1.0.1/js/dataTables.searchPanes.min.js"></script>
        <!-- select -->
        <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
        <script src="funciones.js"></script>
        
<script>
    $(document).ready(function(){
        $('#example').DataTable({

            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                fixedHeader: {
                header: true,
                footer: true,
                },
                ordering: false,                
                rowCallback:function(row,data){
                if(data[0] == "M")
                {
                    $($(row).find("td")[0]).css("background-color","orange");
                }
                if(data[0] == "P"){
                    $($(row).find("td")[0]).css("background-color","blue");
                }
                if(data[0] == "N"){
                    $($(row).find("td")[0]).css("background-color","gray");
                }
                if(data[0] == "R"){
                    $($(row).find("td")[0]).css("background-color","green");
                }
                if(data[0] == "A"){
                    $($(row).find("td")[0]).css("background-color","beige");
                }
                if(data[0] == "S"){
                    $($(row).find("td")[0]).css("background-color","red");
                }}
        });

    });
</script>
</body>

</html>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">SUSPENDER TURNO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <?php 
                $cons = mysqli_query($conSanatorio, "SELECT * FROM motivosuspension");
            ?>
            <label>Motivo de la Suspensión</label>
            <select class="form-control" id="motivo_suspension">
                <option value="0">Seleccione un motivo</option>
                <?php while($row = mysqli_fetch_array($cons)){ ?>
                    <option value="<?php echo $row['Motivo'] ?>"><?php echo  utf8_encode($row['Descripcion']) ?></option>
                <?php } ?>
            </select>
            <li class="list-inline-item"><span id="selectSuspen" hidden = ""></span></li>
            <li class="list-inline-item"><span id="idSuspender" hidden = ""></span></li>
            
            <script>
                    $('#motivo_suspension').on('change', function(){
                        var valor = this.value;
                        $('#selectSuspen').text(valor);
                    })
            </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <button type="button" class="btn btn-primary" onclick="suspenderCon()" >CONFIRMAR</button>
      </div>
    </div>
  </div>
</div>
