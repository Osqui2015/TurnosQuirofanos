<?php
session_start();
//echo $_SESSION['tipo'];
if(!empty($_SESSION['active'])){
	
}else{
    header('location: ../../index.php');
}
$matricula = $_SESSION['matricula']; /*VALOR MATRICULA*/
$userr = $_SESSION['usuario']; /*VALOR USUARIO*/
require_once "../../conUsuario.php";


$con = mysqli_query($conUsuario, "SELECT m.fecha_creacion AS fecha, m.id_mensaje AS id,
              m.titulo, m.mensaje, 
              IF((us.userid=1), 'Administrador del Sistema', us.Nombre) AS Usuario
              FROM mensajes AS m 
              INNER JOIN mensajes_usuarios AS me ON me.id_mensaje = m.id_mensaje 
              LEFT JOIN usuarios AS us ON us.userid = m.id_usuario_creacion
              WHERE me.userid = $matricula ORDER BY fecha DESC");
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Administración Gerencia</title>
  </head>
  <body style="background-image: url('../../imagen/fond1.jpg'); width: 100%; height: 100vh; ">
  
    <?php  include_once "menuGerente.php" ?>
   <br><br><br><br>
   
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-3">
          <div class="card">
              <div class="col text-center">
                <img src="../../imagen/logohoriz.jpg" class="card-top"  >
              </div>
              <div class="card-body">
                <h5 class="card-title"> <u> DR. <!-- <?php echo $_SESSION['nombre']  ?> --> </u> </h5>
                <p class="card-text"></p>
              </div>
              <ul class="list-group list-group-flush center">
                <li class="list-group-item"><img src="../../imagen/iconoGomedesys.png" class="card-top" width="25" height="25" > <a href="https://gomedisys.welii.com/" class="card-link" target="_blank">
                  <b>Gomedisys</b></a></li>
                <li class="list-group-item"><img src="../../imagen/modelo.jpg" class="card-top" width="25" height="25" > <a href="https://www.sanatoriomodelosa.com.ar/" class="card-link" target="_blank">
                  <b>Sanatorio Modelo</b></a></li>
                <li class="list-group-item"><img src="../../imagen/biology.png" class="card-top" width="25" height="25" > <a href="http://181.12.6.58:8080/web/" class="card-link" target="_blank">
                  <b>Visualizador de Imágenes</b></a></li>
                <li class="list-group-item"><img src="../../imagen/microscopio.png" class="card-top" width="25" height="25" > <a href="https://resultados.auadlab.com.ar/interpracsysweb/" class="card-link" target="_blank">
                  <b>Laboratorio</b></a></li>
                <li class="list-group-item"><img src="../../imagen/libro.png" class="card-top" width="25" height="25" > <a href="https://drive.google.com/file/d/1rOT63aWpzkOHjJ99h7faZ-oKLCtMeK2A/view?usp=sharing" class="card-link" target="_blank">
                  <b>Manual de Uso</b></a></li>
              </ul>
              <div class="card-body">
                <a href="#" class="card-link"></a>
                <a href="#" class="card-link"></a>
              </div>
          </div>
      </div>
      <div class="col-7">
            <div class="card" >
              <div class="card-header">
                <b> Mensajes</b>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="mensaje" class="table display table-borderless" style="width:100%" >
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
      </div>
    </div>
  </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  
  </body>
</html>