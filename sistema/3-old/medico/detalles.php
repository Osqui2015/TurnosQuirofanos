<!---CONECION Y BUSQUEDA--->
<?php
    $matricula = $_POST['idM']; /*VALOR MATRICULA*/
    $detalle = $_POST['idP']; /*VALOR MATRICULA*/
    require_once "../../conPagos.php";
    $objcon = new Conexion();
    $conexion = $objcon->conectar();
    /* BUSQUEDA SEGUN MATRICULA */
    $sql = "SELECT spcscc_ID, spctco_Cod, scc_FEmision, sccpro_RazSoc, sccpro_CUIT, sdccon_Cod, sdc_Desc, sdc_CantOrigUM1, sdc_PrecioUn, sdc_ImpTot
    FROM SegTiposC AS st
    INNER JOIN SegCabC AS sc on sc.SCC_ID = st.spcscc_ID
    INNER JOIN proveed AS pr ON pr.pro_Cod = sc.sccpro_Cod
    INNER JOIN SegDetC AS sd on sd.sdcscc_id = st.spcscc_ID
    WHERE st.spctco_Cod = 'OCM' 
    AND pr.pro_Fax = '$matricula'
    AND spcscc_ID = $detalle";
    $res = sqlsrv_query( $conexion, $sql);
    if( $res === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
?>
<!--------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles</title>
    <?php require_once "dependencias.php"; ?>
</head>
<body>
<div id="contenedor">
    <div class="container">
            <div class="jumbotron">
                <div><h3><p class="text-center font-weight-bold"">Detalles de pagos</p></h3></div>            
                <div class="text-right">                    
                    <button onclick="location.href='pagos.php'" type="button" class="btn btn-dark">Volver Pagina Anterior</button>
                </div>
                <hr class="my-4">
                <div >
<!--- TABLA Detalle--------------------------------->
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover table-condensed" id="tablaPagosDT">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> CODIGO </th>
                    <th> CUIT </th>
                    <th> Descripcion </th>                   
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
                        <td> <?php echo $row['sdccon_Cod'] ?> </td> 
                        <td> <?php echo $row['sccpro_CUIT'] ?> </td>
                        <td> <?php echo $row['sdc_Desc'] ?> </td>
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
                <span class="footer">© 2021 Todos los derechos reservados SANATORIO MODELO S.A.</span>
            </div>               
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tablaPagosDT').DataTable();
    });
</script>
<script src="public/js/pagos.js"></script> 
</body>
</html>