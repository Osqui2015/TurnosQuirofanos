<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
require_once "../../conUsuario.php";

$con = mysqli_query($conUsuario, "SELECT m.fecha_creacion AS fecha, m.id_mensaje AS id,
              m.titulo, m.mensaje, 
              IF((us.userid=1), 'Administrador del Sistema', us.Nombre) AS Usuario
              FROM mensajes AS m 
              INNER JOIN mensajes_usuarios AS me ON me.id_mensaje = m.id_mensaje 
              LEFT JOIN usuarios AS us ON us.userid = m.id_usuario_creacion
              WHERE me.userid = $matricula ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head style="background-color:#E9ECEE;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis Mensaje</title>
   
    <?php  include_once "dependencias.php" ?>

<!---- ---->
	


<!---- ---->
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body>


    <!–– Principal -->

      
            <!–– menu -->
             <?php  include_once "menuMedicos.php" ?>
            <!–– fin menu -->
            <div class="jumbotron">
                <!–– Principal -->
                <div class="card-body">
                    
                <div class="card">
                    <div class="card-header">
                        <b> Mensajes</b>
                    </div>
                    <div class="card-body">
                        <table id="mensaje" class="table display" style="width:100%" >
                          <thead class="thead-dark" style="background-color:#004993;">
                              <tr>
                              <th scope="col">Fecha</th>
                              <th scope="col">Titulo</th>
                              <th scope="col">Enviado Por</th>
                              <th scope="col"></th>
                              
                              </tr>
                          </thead>
                          <tbody>
                              <?php              
                              if(!$con) {?>
                                  <tr>
                                      <td colspan="6">No hay datos para mostrar</td>
                                  </tr>
                              <?php }else {
                                  while($row=mysqli_fetch_array($con)) {
                              ?>
                              <tr>
                              <th scope="row" style="width:30%"> <?php echo substr($row['fecha'], 0, -9);?></th>
                              <td style="width:50%"> <?php echo utf8_encode($row['titulo']) ?> </td> 
                              <td style="width:100%"> <?php echo $row['Usuario'] ?> </td>
                              <td> <span type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalMensaje" onclick="Mensaje(<?php echo $row['id']?>, <?php echo $matricula?>)">Ver</span> </td>
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
                <!–– Fin Principal -->
            </div>
    
        <!-- <span class="footer">© <?php echo date('Y'); ?> Todos los derechos reservados </span> -->
  


   


</body>
<script>
    $(document).ready(function() {        
        $('#mensaje').DataTable({ 
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },        
        "dom": 'lrtip',
        fixedHeader: {
                header: true,
                footer: true,
                },
        ordering: false,
        "info": false,
        pageLength : 5,
        lengthMenu: [[5, 10, 15, -1], [5, 10, 15, 'Todos']]
        })

    });
</script>
</html>


<div class="modal fade" id="ModalMensaje" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mensaje</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- -->      
      <div class="form-group">
        <label for="exampleFormControlSelect1">Fecha y Hora</label>
        <input type="tex" class="form-control" id="Fecha" maxlength="11" readonly>
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1">Enviado Por</label>
        <input type="tex" class="form-control" id="Remitente" readonly>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Mensaje</label>
        <textarea class="form-control" id="Mensaje" rows="10" readonly></textarea>
      </div>
      <!-- -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>