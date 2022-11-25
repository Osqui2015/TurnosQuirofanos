<?php
$v = 0;
session_start();

// echo $_SESSION['tipo'];

require_once "../../conSanatorio.php";


$fechaSelec = $_POST['fecha'];

$query = mysqli_query($conSanatorio, "SELECT tur.Numero, p.Nombre AS Medico, tur.Nombre AS Paciente, tip.Descripcion AS Tipo_Documento, DniPaciente, 
ObraSocial, tur.Telefono, Email, DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fecha, DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin, q.Descripcion AS Quirofano, CodigoPractica, Anestesista, Rx, Sangre, Monitoreo, 
Arco, ForceTriad, ForceTriad_Propio, Uti, Laparoscopica, ParaInternar, DescripcionCirugia, InsumosNoHabituales, Estado, usuario  

FROM turnosquirofano AS tur LEFT JOIN tiposdocumentoidentidad AS tip ON tip.TipoDocumentoIdentidad=tur.TipoDocumentoIdentidad 
INNER JOIN profesionales p ON p.Matricula=tur.MatriculaProfesional INNER JOIN quirofanos q ON q.Numero=tur.Quirofano 
INNER JOIN turnosquirofanospracticas tp ON tp.Numero=tur.Numero WHERE fecha = '$fechaSelec' 
GROUP BY tur.Numero ORDER BY HoraInicio,tur.Quirofano DESC");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Reporte de Turnos</title>
    <?php  include_once "dependencias.php" ?>
<link rel="icon" href="../../imagen/modelo.jpg">

    <!--  Datatables  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    
    <!-- searchPanes -->
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchPanes.dataTables.min.css">
    <!-- select -->
    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.css"/>
 

</head>
<body>
            <!–– menu -->
             <?php  include_once "menuAdmin.php" ?>
            <!–– fin menu -->
            
              
            
        <div class="jumbotron ">        
            <div class =" text-center">
                <h1><p> Reporte de Turnos </p> </h1>
            </div>
            <form method="post" action="reporteTurnoD.php">
            <div class="row justify-content-center align-items-center minh-100">                   
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Fecha</h5>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class =" text-center">
                <input type="submit">
            </div>
            </form>
        </div>

        <div class="card">
            <h5 class="card-header">turnos</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display compact table table-hover table-condensed" id="example" style="width:100%">
                        <thead>
                            <tr class="bg-info">
                                <th>Numero</th>
                                <th>Quirofano</th>
                                <th>Medico</th>
                                <th>Paciente</th>  
                                <th>Tipo Documento</th>
                                <th>DniPaciente</th>
                                <th>Obra Social</th> 
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Fecha</th>
                                <th>Hora Inicio</th> 
                                <th>hora Fin</th> 
                                
                                <th>Codigo Practica</th>
                                <th>Anestesista</th>
                                <th>Rx</th>
                                <th>Sangre</th>
                                <th>Monitoreo</th>
                                <th>Arco</th>
                                <th>ForceTriad</th>
                                <th>ForceTriad_Propio</th>
                                <th>Uti</th>
                                <th>Laparoscopica</th>
                                <th>ParaInternar</th>
                                <th>DescripcionCirugia</th>
                                <th>InsumosNoHabituales</th>
                                <th>Estado</th>
                                <th>Usuario</th>                                                      
                            </tr>
                        </thead>
                        <tbody>                
                            <?php if(!$query) {?>
                                <tr>
                                    <td colspan="6">No hay datos para mostrar</td>
                                </tr>

                                <?php }
                                else {
                                while($row=mysqli_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td scope="row"><?php echo $row['Numero'] ?></td>
                                    <td><?php echo $row['Quirofano'] ?></td>

                                    <td><?php echo $row['Medico'] ?></td>
                                    <td><?php echo $row['Paciente'] ?></td>
                                    <td><?php echo $row['Tipo_Documento'] ?></td>
                                    <td><?php echo $row['DniPaciente'] ?></td>
                                    <td><?php echo $row['ObraSocial'] ?></td>
                                    <td><?php echo $row['Telefono'] ?></td>
                                    <td><?php echo $row['Email'] ?></td>
                                    <td><?php echo $row['Fecha'] ?></td>
                                    <td><?php echo $row['HoraInicio'] ?></td>
                                    <td><?php echo $row['HoraFin'] ?></td>
                                    
                                    <td><?php echo $row['CodigoPractica'] ?></td>
                                    <td><?php echo $row['Anestesista'] ?></td>
                                    <td><?php echo $row['Rx'] ?></td>
                                    <td><?php echo $row['Sangre'] ?></td>
                                    <td><?php echo $row['Monitoreo'] ?></td>
                                    <td><?php echo $row['Arco'] ?></td>
                                    <td><?php echo $row['ForceTriad'] ?></td>
                                    <td><?php echo $row['ForceTriad_Propio'] ?></td>
                                    <td><?php echo $row['Uti'] ?></td>
                                    <td><?php echo $row['Laparoscopica'] ?></td>
                                    <td><?php echo $row['ParaInternar'] ?></td>
                                    <td><?php echo $row['DescripcionCirugia'] ?></td>
                                    <td><?php echo $row['InsumosNoHabituales'] ?></td>
                                    <td><?php echo $row['Estado'] ?></td>
                                    <td><?php echo $row['usuario'] ?></td>                                            
                                </tr>
                                <?php
                                }//Fin while
                            // }
                                }//Fin if   
                                mysqli_close($conSanatorio); ?>
                        </tbody>
                    </table>
                </div>
            </div>
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

        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.js"></script>

</body>

</html>
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
                scrollY:        300,
                scrollX:        true,
                scrollCollapse: true,
                paging:         true,
                fixedColumns:   true,
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
                }},
                responsive: "true",
                dom: 'Bfrtilp',       
                buttons:[ 
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fas fa-file-excel"></i> ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend:    'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        text:      '<i class="fas fa-file-pdf"></i> ',
                        titleAttr: 'Exportar a PDF',
                        className: 'btn btn-danger'
                    },
                    {
                        extend:    'print',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        text:      '<i class="fa fa-print"></i> ',				
                        className: 'btn btn-info',
                        messageTop: 'ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ <img src="../../images/logo_modelo.png">',
                    },
                ]	
        });

    });
</script>


