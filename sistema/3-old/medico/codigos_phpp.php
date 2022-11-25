<?php
require_once "../../conSanatorio.php"; //libreria de conexion a la base

$banda_id = filter_input(INPUT_POST, 'banda_id'); //obtenemos el parametro que viene de ajax

if($banda_id != ''){ //verificamos nuevamente que sea una opcion valida


  /*Obtenemos los discos de la banda seleccionada*/
  
  $Hora = mysqli_query($conSanatorio," SELECT * FROM quirofanoshorarios WHERE Quirofano= $mquir"); 
  $query = mysqli_query($con, $Hora);
  $filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
}

/**
 * Como notaras vamos a generar código `html`, esto es lo que sera retornado a `ajax` para llenar 
 * el combo dependiente
 */
?>

<option>- Seleccione -</option>
<?php foreach($filas as $op): //creamos las opciones a partir de los datos obtenidos ?>
<option ><?= $op['HoraInicio'] ?></option>
<?php endforeach; ?>

/////////////////////
$vmI = explode(":", $valoresI [0]);// 07:30
			$vHoIni = $vmI[0]; //07
			$vminIni = $vmI[1]; //30

			$vmF = explode(":", $valoresF [0]);// 07:00
			$vHoFin = $vmI[0]; // 23
			$vminFin = $vmI[1]; // 30
			
			$t = 0;
			for ($i = 7; $i < 24 ; $i++){
				for ($m = 0; $i < 60 ; $m = $m + 5){
					/* if ( ((($i*60)+$m) >= (($$vHoIni*60)+$$vminIni)) && ((($i*60)+$m) >= (($$vHoFin*60)+$vminFin)) ){
						$t = 1;
					}else{
						$nuevaHora = date("H:i",$i+$m);
						$op .= "<option value=".$nuevaHora.">".$nuevaHora."</option>";
					}*/
					$op .= "<option >".$i.":".$m."</option>";
				}
				/*$vmI = explode(":", $valoresI [$t]);// 07:30
				$vHoIni = $vmI[0]; //07
				$vminIni = $vmI[1]; //30

				$vmF = explode(":", $valoresF [$t]);// 07:00
				$vHoFin = $vmI[0]; // 23
				$vminFin = $vmI[1]; // 30*/

			}
//////////////////  


<tbody>
							<tr>
								<th>ㅤEstadoㅤㅤㅤㅤㅤ Hastaㅤㅤㅤㅤ Desdeㅤㅤㅤㅤㅤㅤㅤ Profesionalㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ Practica </th>                            
							</tr>
						<tbody>



						input fecha
						