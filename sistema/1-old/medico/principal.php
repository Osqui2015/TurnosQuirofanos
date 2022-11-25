<div class="row">
  <div class="col-md-4">
    <div class="card" style="width: 25rem;">
      <div class="col text-center">
        <img src="../../imagen/logohoriz.jpg" class="card-top"  >
      </div>
      <div class="card-body">
        <h5 class="card-title"> <u> DR. <?php echo $_SESSION['nombre']  ?> </u> </h5>
        <p class="card-text"></p>
      </div>
      <ul class="list-group list-group-flush center">
        <li class="list-group-item"><img src="../../imagen/iconoGomedesys.png" class="card-top" width="25" height="25" > <a href="https://gomedisys.welii.com/" class="card-link" target="_blank"><b> ㅤㅤGomedisys</b></a></li>
        <li class="list-group-item"><img src="../../imagen/modelo.jpg" class="card-top" width="25" height="25" > <a href="https://www.sanatoriomodelosa.com.ar/" class="card-link" target="_blank"><b> ㅤㅤSanatorio Modelo</b></a></li>
        <li class="list-group-item"><img src="../../imagen/biology.png" class="card-top" width="25" height="25" > <a href="http://181.12.6.58:8080/web/" class="card-link" target="_blank"><b> ㅤㅤVisualizador de Imágenes</b></a></li>
        <li class="list-group-item"><img src="../../imagen/microscopio.png" class="card-top" width="25" height="25" > <a href="https://resultados.auadlab.com.ar/interpracsysweb/" class="card-link" target="_blank"><b> ㅤㅤLaboratorio</b></a></li>
        <li class="list-group-item"><img src="../../imagen/libro.png" class="card-top" width="25" height="25" > <a href="https://drive.google.com/file/d/1rOT63aWpzkOHjJ99h7faZ-oKLCtMeK2A/view?usp=sharing" class="card-link" target="_blank"><b> ㅤㅤ Manual de Uso</b></a></li>
      </ul>
      <div class="card-body">
        <a href="#" class="card-link"></a>
        <a href="#" class="card-link"></a>
      </div>
    </div>
  </div>
<!-- mensajes --->
  <div class="col-md-7 ml-auto">
    <div class="card">
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
    <br><br>            
  </div> 
</div>


<!-- <div class="card">
  <div class="card-header">
    Disponibilidad de Quirófano ㅤㅤ <select name="" id=""></select> ㅤㅤ <input type="date" name="" id="">
  </div>
  <div class="card-body">
    <div class="progress">
      <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 30%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>      
      <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
  </div>
</div> -->




<div class="modal fade" id="ModalMensaje" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
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
        <textarea class="form-control" id="Mensaje" rows="3" readonly></textarea>
      </div>
      <!-- -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>