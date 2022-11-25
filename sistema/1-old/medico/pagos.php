<?php
session_start();
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
$value = $_SESSION['matricula'];
require_once "../../conPagos.php";
$objcon = new Conexion();
$conPagos = $objcon->conectar();
/* BUSQUEDA SEGUN MATRICULA */
$sql = "SELECT spcscc_ID, spctco_Cod, scc_FEmision, sccpro_RazSoc, sccpro_CUIT, sdccon_Cod, sdc_Desc, sdc_CantOrigUM1, sdc_PrecioUn, sdc_ImpTot
FROM SegTiposC AS st
INNER JOIN SegCabC AS sc on sc.SCC_ID = st.spcscc_ID
INNER JOIN proveed AS pr ON pr.pro_Cod = sc.sccpro_Cod
INNER JOIN SegDetC AS sd on sd.sdcscc_id = st.spcscc_ID
WHERE st.spctco_Cod = 'OCM' 
AND SD.sdccon_Cod IS NOT NULL
AND pr.pro_Fax = '$matricula'
ORDER BY scc_FEmision desc";



$res = sqlsrv_query( $conPagos, $sql);
if( $res === false) {
    die( print_r( sqlsrv_errors(), true) );
}


?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pagos Medico <?php echo $_SESSION['nombre']?></title>
    <link rel="stylesheet" href="main.css">
    <?php  include_once "dependencias.php" ?>
    <link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body>
    <!–– Principal -->
        <!–– menu -->
            <?php  include_once "menuMedicos.php" ?>
        <!–– fin menu -->
            <div class="jumbotron">
                <img src="../../images/logo_modelo.png">
                <div>
                    <h3><p class="text-center font-weight-bold"">Listados de Prestaciones</p></h3>                
                </div>
                <div class="text-right">
                    
                </div>
                

                <hr class="my-4">
                <div >
<!--- TABLA PRINCIPAL--------------------------------->
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover table-condensed" id="tablaPagosDT">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Fecha Emisión </th>
                    <th> Descripcion </th>
                    <th> Total </th>
                    <th> detalle </th>                    
                </tr>
            </thead>
            <tbody>                
                <?php if(!$res) {?>
                    <tr>
                        <td colspan="6">No hay datos para mostrar</td>
                    </tr>
                    <?php }
                    else {
                    while($row=sqlsrv_fetch_array($res)) {
                        $idPagos = $row['spcscc_ID'] ;   
                    ?>
                    <tr>
                        <td> <?php echo $row['spcscc_ID'] ?> </td>
                        <td> <?php echo $row['scc_FEmision']->format('d/m/Y'); ?> </td> 
                        <td> <?php echo $row['sdc_Desc'] ?> </td>
                        <!---CONVIERTE A DECIMAL---->   
                        <?php 
                                $var1 = '$  ';
                                $var2 = number_format($row['sdc_ImpTot'], 2,',','.');
                                $texto_completo = $var1 . $var2;                                
                            ?>
                        <td> <?php echo $texto_completo ?> </td>
                        <!---FIN CONVIERTE A DECIMAL----> 
                        <td>  
                          <!---PASAR DATOS A DETALLES---->                               
                            <form  action="detalles.php" method="post" >
                                <input value= "<?php echo $idPagos ?>" type="text" name="idP" hidden= " ">
                                <input value= "<?php echo $value ?>" type="text" name="idM" hidden= " ">
                                <input class="btn btn-info btn-sm" type="submit" value="DETALLE">
                            </form> 
                        <!---FIN PASAR DATOS A DETALLES----> 
                        </td>
                    </tr>
                    <?php
                    }//Fin while
                    }//Fin if   
                    ?>
            </tbody>
        </table>
    </div>
  </div>
</div>
<!--- TABLA PRINCIPAL--------------------------------->

                </div>
                
                <span class="footer">© 2022 Todos los derechos reservados SANATORIO MODELO S.A.</span>
                
            </div>               


<script type="text/javascript">
    $(document).ready(function() {
    $('#tablaPagosDT').DataTable({ 
        "language": {
           "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
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
				text:      '<i class="fas fa-file-pdf"></i> ',
				titleAttr: 'Exportar a PDF',
				className: 'btn btn-danger'
			},
			{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',				
				className: 'btn btn-info',
                messageTop: 'ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ <img src="../../images/logo_modelo.png">',
			},
		]	    

    });
});
</script>
    <!–– Fin Principal -->


</body>
</html>




<!––- Modal Practica --->
