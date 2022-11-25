<?php
	require_once "../../conSanatorio.php";

/* ----------- COMPLETA VALORES DEL PACIENTE------------------ */
	if(isset($_POST['buscar']))
    { 
    	$doc = $_POST['doc'];
		$tip = $_POST['tip'];
    	$valores = array();
    	$valores['existe'] = "0";

    	//CONSULTAR
		  $resultados = mysqli_query($conSanatorio,"SELECT P.NumeroDocumentoIdentidad AS Numero_Documento, 
		  P.TipoDocumentoIdentidad AS Tipo_Documento, 
		  T.Descripcion AS Tipo_Documento_Nombre, 
		  CONCAT(LTRIM(RTRIM(Apellido)),', ',LTRIM(RTRIM(Nombre))) AS Nombre_Paciente, 
		  LTRIM(RTRIM(P.Telefono)) AS Tel_Paciente, 
		  O.CodigoObraSocial AS Codigo_Obra_Social, 
		  RTRIM(O.Descripcion) AS Obra_Social, 
		  O.Deshabilitada AS Obra_Social_Estado,
		  p.mail AS email
		  FROM Tiposdocumentoidentidad AS T, Pacientes AS P LEFT JOIN ObrasSociales AS O ON(P.CodigoObraSocial = O.CodigoObraSocial)
		  WHERE P.TipoDocumentoIdentidad = T.TipoDocumentoIdentidad
		  AND P.NumeroDocumentoIdentidad = $doc AND P.TipoDocumentoIdentidad = $tip");

		  while($consulta = mysqli_fetch_array($resultados))
		  {
		  	$valores['existe'] = "1"; 
		  	$valores['Nombre_Paciente'] = $consulta['Nombre_Paciente'];
		  	$valores['Tel_Paciente'] = $consulta['Tel_Paciente'];;	
			$valores['email'] = $consulta['email'];
			$valores['codObra'] = $consulta['Codigo_Obra_Social'];
			$valores['estadoObra'] = $consulta['Obra_Social_Estado'];	    
		  }
		  $valores = json_encode($valores);
			echo $valores;
    }
/* -----------MUESTRA VALORES EN LA TABLA POR LA FECHA SELECCIONADA------------------ */
	if(isset($_POST['fbuscar'])){ 
    	$quirodanoselec = $_POST['mquir'];
		$fechaSelec = $_POST['mfec'];
		
		$turnTabla = mysqli_query($conSanatorio,"SELECT tq.Estado,
						tq.Quirofano AS NumQuir, 
						DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
						DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin,  
						LTRIM(RTRIM(pr.Nombre))AS NomMedico, 
						SUBSTRING(pa.Descripcion,1,50) AS DescriPractica
						FROM turnosquirofano AS tq 
						INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
						INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
						INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
						INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
						WHERE Estado IN ('PENDIENTE')
						AND tq.Fecha = '$fechaSelec'
						AND tq.Quirofano = $quirodanoselec
						GROUP BY tq.numero
						ORDER BY HoraInicio");
		

		  	$salida = '<div class="table-responsive">
			  			<table style="width: 100%" class="table table-striped">
							<thead>
								<tr>
									<th width="14%" scope="col">Estado</th>
									<th width="13%" scope="col">Desde</th>
									<th width="15%" scope="col">Hasta</th>
									<th width="30%" scope="col">Profesional</th>
									<th width="40%" scope="col">Practica</th>
								</tr>
							</thead>
						</table>  
							
						<table class="table table-striped">
							<tbody>';
			while($fila = $turnTabla->fetch_assoc()){
						$salida.=
								'<tr>
									<td>'.$fila['Estado'].'<td>
									<td>'.$fila['HoraInicio'].'<td>
									<td>'.$fila['HoraFin'].'<td>
									<td>'.$fila['NomMedico'].'<td>
									<td>'.utf8_encode($fila['DescriPractica']).'<td>
								</tr>';				
					} 
				$salida.='</tbody>
						</table> 
					</div>';

			
			echo $salida;
			
    }

/* ----------- Hora inicio ------------------ */
	if(isset($_POST['mHorasN'])){ 

		$mquir = $_POST['mquir']; 
		$fechaSelec = $_POST['mfec'];

		echo 'fecha seleccionada'.$fechaSelec."<br>";
		$tiempoPractica = $_POST['tiempoPractica'];
		$valoresI = array();
		$valoresF = array();			 
		$vi=0;
		$vf=0;			
		//CONSULTAR
		$Hora = mysqli_query($conSanatorio,"SELECT * FROM quirofanoshorarios WHERE Quirofano = $mquir");
		while($consulta = mysqli_fetch_array($Hora)){					 
			$mI = explode(":", $consulta['HoraInicio']);// 07:30
			$HoIni = $mI[0]; //07
			$minIni = $mI[1]; //30
			$mF = explode(":", $consulta['HoraFin']);// 07:00
			$HoFin = $mI[0]; // 23
			$minFin = $mI[1]; // 30				
			$Intervalo = $consulta['Intervalo']; // 5
			$entreTurno = $consulta['TiempoEntreTurno']; // 30
		}
		
		$ocHora = mysqli_query($conSanatorio,"SELECT tq.Estado,
												tq.Quirofano AS NumQuir, 
												HoraInicio, 
												HoraFin  
												FROM turnosquirofano AS tq 
												INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
												INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
												WHERE Estado IN ('PENDIENTE', 'REALIZADO')
												AND tq.Fecha = '$fechaSelec'
												AND tq.Quirofano = $mquir
												GROUP BY tq.numero
												ORDER BY HoraInicio");

		$op = '<select> <select class="custom-select">
			<option> </option>';
		$row_cnt = mysqli_num_rows($ocHora);
		$cont = 0;
		$l = 0;

		if ($row_cnt == 0) {			
			for ($h = $HoIni; $h < 24 ; $h++){
				for ($m = 0; $m < 60 ; $m = $m + $Intervalo){
					if ($m < 10){
						$op .= "<option value=".$h.":".$l.$m.">".$h.':'.$l.$m."</option>";
					}else{
						$op .= "<option value=".$h.":".$m.">".$h.':'.$m."</option>";
					}									
				}
			}
			$op.="</select> ";
			echo $op;
		}else{
				while ($verConfig  = @mysqli_fetch_array($ocHora)) {
					$valoresI[$cont] = $verConfig["HoraInicio"];  
					$valoresF[$cont] = $verConfig["HoraFin"];  
					$cont++;
					}
					echo 'cont'.$cont."<br>";
				

				$horaInPra = date("Y-m-d H:i", strtotime($valoresI [0]));
				$horaFiPra = date("Y-m-d H:i", strtotime($valoresF [0]));


				$fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPra ) ) ;	
				$horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );

				echo 'ini'.$horaInPra.'<br>';
				echo 'fin',$horaFiPra.'<br>'.'<br>';
				$horaFinOcupada =  strtotime(substr($horaFiPra, 11));
				$horaOcupada = strtotime(substr($horaInPra, 11));
				echo 'ini'.$horaOcupada.'<br>';
				echo 'fin',$horaFinOcupada.'<br>';
					$x = 0;
					$xx = 0;
				$z = 0;
				$vec = 0; 
				$mt = 0;
					$cnn = ($cont - 1);
					echo 'cnn'.$cnn."<br>";

				for ($h = $HoIni; $h < 24 ; $h++){
					for ($m = 0; $m < 60 ; $m = $m + $Intervalo){
						
						$hoy = date("Y-m-d H:i", strtotime($fechaSelec.$h.':'.$m));
						echo 'hora'.$hoy."<br>";


						$horaHoy = strtotime(substr($hoy, 11));

						if ((($hoy >= $horaInPra) && ($hoy <= $horaFiPra))){
								/*$z=1;
								$mt=0;
								if ($vec == $x){
									$x = $cnn;
									echo $x.'valor x'."<br>";
									continue;
								}else {
									echo $vec.'valor vec'."<br>";
								}*/
								
								$z=1;
						}else{
							
								$op .= "<option value=".substr($hoy, 11).">".substr($hoy, 11)."</option>";
								echo '-'."<br>"; // mostrar horas disponibles
							
						}
					}

					if ( $z == 1 && $vec < ($row_cnt-1) ){

						$from_time = $horaFinOcupada;

						$vec = $vec + 1;

					
						
						$horaInPra = date("Y-m-d H:i", strtotime($valoresI [$vec]));
						$horaFiPra = date("Y-m-d H:i", strtotime($valoresF [$vec]));

						$fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPra ) ) ;	
						$horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );

						$z = 0;

						$horaFinOcupada =  strtotime(substr($horaFiPra, 11));
						$horaOcupada = strtotime(substr($horaInPra, 11));

						$to_time = $horaOcupada ;
						
						
						
						$minutes = round(abs($to_time - $from_time) / 60,2);

						
						$x = 0;
						$xx = 0;

						if ($minutes < $tiempoPractica ){
							$mt = 1;
							echo "<br>".'menor';
						}else {
							$mt = 0;
							echo "<br>".'mayor';
						}

					}
				}
				$op.="</select> ";
				echo $op;
		}
	}
/* -------------Hora Fin---------------- */
	if(isset($_POST['horaFin'])){ 
		$tiempoPractica = (int)$_POST['tiempoPractica'];
		$tiempoInicio = $_POST['tiempoInicio'];
		$tiempo = $tiempoPractica * 60;	
		$segundos_horaInicial=strtotime($tiempoInicio);

		
		$valore = array();
    	$valore['existe'] = "1";
		$valore['hf'] = date("H:i",$segundos_horaInicial+$tiempo);
		$valore = json_encode($valore);
			echo $valore;	
	}
/* ----------------CHEQUEAR DATOS PARA CONTINUAR FORM------------- */
	if(isset($_POST['chequear'])){ 
			// $carlos = new DateTime('1982-08-15 15:23:48'); ejemplo
			$fech = $_POST['mfec'];
			$inicio = $fech.' '.$_POST['tiempoInicio'].':00';
			$fin = $fech.' '.$_POST['tiempoFin'].':00';
			$mquir = $_POST['mquir'];

			$valores = array();
			//CONSULTAR

			//echo 'antes de slq';
			$resultados = mysqli_query($conSanatorio,"SELECT * FROM (
															SELECT matriculaprofesional, quirofano, IF ((horarealingreso IS NULL), horainicio, horarealingreso) AS horainicio, IF ((horarealingreso IS NULL), horafin, horarealegreso) AS horafin, numero 
																FROM
																(SELECT tq.matriculaprofesional, tq.fecha, tq.quirofano, tq.horainicio, tq.horafin, tt.horarealingreso, tt.horarealegreso, tq.numero
																FROM TurnosQuirofano AS tq
																LEFT JOIN turnostiempocirugia AS tt ON tt.Numero = tq.Numero
																WHERE tq.Estado <> 'SUSPENDIDO' AND tq.Estado <> 'NO REALIZADO' AND tq.Estado <> 'MODIFICADO' AND 
																tq.Quirofano = '$mquir'
																AND tq.Fecha = '$fech' ) AS C1
														) AS C2
														WHERE (((HoraInicio <= '$inicio') AND (HoraFin > '$inicio'))OR((HoraInicio <= '$fin')
														AND (HoraFin > '$fin'))OR((HoraFin > '$inicio') AND (HoraInicio <= '$fin')))");

			if(!$resultados){
				echo mysqli_error($conSanatorio);
			}
			$row_cnt = mysqli_num_rows($resultados);
			//echo 'desp de slq'.$row_cnt;
			if ($row_cnt == 0){
				$valores['existe'] = "1";
				
			}else{
				$valores['existe'] = "0";
			}
			$valores = json_encode($valores);
				echo $valores;
	}
/* ---------------GUARDAR-------------- */
	if(isset($_POST['guardar'])){ 
		$resnum = mysqli_query($conSanatorio, "SELECT MAX(Numero+1) AS Numero FROM TurnosQuirofano");

		while($consulta = mysqli_fetch_array($resnum)){
			$numeroTurno = $consulta['Numero'];
		} //numero de turno

		$matricula = $_POST['valorMatricula']; // MATRICULA
		$TipoDocumentoIdentidad = $_POST['tipoDocumento']; // TIPO DE DNI
		$DNIPaciente = $_POST['valorDocumento']; // NUMERO DE DOCUMENTO
		$Nombre = $_POST['nomyapel'];// NOMBRE PACIENTE 
		$valorUsuario = $_POST['valorUsuario']; // USUARIO



		//------ ESTADO------------
			$cons = mysqli_query($conSanatorio, "SELECT turnos FROM Profesionales WHERE Matricula='$matricula'");
			while($turnocons = mysqli_fetch_array($cons)){
				$turnoconf = $turnocons['turnos'];
			}
			if ($turnoconf == 1){
				$estado = 'A CONFIRMAR';
			}else{
				$estado = 'PENDIENTE';
			}
		// ------------------------
		
		$fech = $_POST['fechas']; // FECHA
		$inicio = $fech.' '.$_POST['horaInicio'].':00'; // HORA DE INICIOS


		
		
		$mifecha = $fech.' '.$_POST['horaFinn'].':00'; // HORA DE Fin
		
		$NuevaFecha = strtotime ($mifecha);
		
		$newdate  = strtotime ( '+5 minute' , $NuevaFecha ); 
		$fin =date('Y-m-d H:i:s',$newdate);
		
		$Codobrasocial = $_POST['Codobrasocial'];//CodigoOBRASOCIAL

		$menuDocumento = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(CodigoObraSocial)) AS Codigo,
									Descripcion,Deshabilitada FROM obrassociales 
									WHERE web = '1' AND CodigoObraSocial = '$Codobrasocial'");
		while($row=mysqli_fetch_array($menuDocumento)) {
			$nom = $row['Descripcion'];
		}

		$NomObraSocial = $nom;
		$monitoreo = $_POST['monitoreo'];//MONITORIO
		$rx = $_POST['rx']; //RX
		$sangre = $_POST['sangre'];//SANGRE
		$NroRegistro = '0'; //NUMERO REGISTRO
		$NroIngreso = '0'; // numero ingreso
		$numeroQuirofano = $_POST['numeroQuirofano'];

		
		// Motivo Suspensión
		$tel = $_POST['tel']; // TELEFONO
		$anestesitaRadio = $_POST['anestesitaRadio']; // anestesita
		//TIPO DE CIRUGIA
		//FECHA ALTA
		//FECHA SUSPENSIÓN
		//LOCAL O WEB
		$DateAndTime = date('Y-m-d H:i:s', time()); 
		$fechaGrabacion = $DateAndTime; //fECHA DE GRABACIÓN
		$arcoC = $_POST['arcoC']; //ARCO
		$ForceSana  = $_POST['ForceSana']; //ForceTriad Sanatorio
		$uti = $_POST['uti'];  //Uti
		$laparo = $_POST['laparo']; //LAPAROSCÓPICA		
		$tarea = $_POST['tarea']; //DescripcionCirugia

		
		//CodigoObraSocial
		$ParaInternar = $_POST['tipCirugia']; //ParaInternar
		//Telefono2
		//Observaciones
		
		// $InsumoNH = $_POST['InsumoNH']; InsumosNoHabituales
		
		$email = $_POST['email'];// EMAIL
		$ForcePro = $_POST['ForcePro'] ; // ForceTriad Propio
		
		// usuario 
		$intruPro = $_POST['intruPro']; // Intrumentista Propio

		/// PRACTICAS
		$codigoPracticaU = $_POST['codigoPracticaU'];
		
		$codigoPracticaD = $_POST['codigoPracticaD'];
		$codigoPracticaT = $_POST['codigoPracticaT'];

		
		$valores = array();
		$valores['existe'] = "1";
		//CONSULTAR
		
			

						$consulta = "INSERT INTO TurnosQuirofano (  Numero,
																	MatriculaProfesional,
																	TipoDocumentoIdentidad,
																	DNIPaciente,
																	Nombre,
																	Estado,
																	Fecha,
																	HoraInicio,
																	HoraFin,
																	ObraSocial,
																	Monitoreo,
																	RX,
																	Sangre,
																	NroRegistro,
																	NroIngreso,
																	Quirofano,
																	Telefono,
																	Anestesista,
																	FechaGrabacion,
																	Arco,
																	ForceTriad,
																	Uti,
																	Laparoscopica,
																	DescripcionCirugia,
																	CodigoObrasocial,
																	ParaInternar,
																	Email,																	
																	ForceTriad_Propio,
																	usuario,
																	Instrumentista_Propio)
						VALUES($numeroTurno, 
								$matricula,
								$TipoDocumentoIdentidad,
								$DNIPaciente,
								'$Nombre',
								'$estado',
								'$fech',
								'$inicio',
								'$fin',
								'$NomObraSocial',
								'$monitoreo',
								'$rx',
								'$sangre',
								$NroRegistro, 
								$NroIngreso,
								$numeroQuirofano,
								'$tel',
								'$anestesitaRadio',
								'$fechaGrabacion',
								'$arcoC',
								'$ForceSana',
								'$uti',
								'$laparo',
								'$tarea',
								'$Codobrasocial',
								$ParaInternar,
								'$email',								
								'$ForcePro',
								'$valorUsuario',
								'$intruPro' )";

								// echo $consulta;

		$resultadoUno = mysqli_query($conSanatorio,$consulta);
		if (!$resultadoUno) {
			echo "Error en la inserción: ".$conSanatorio->error;
		}

		if ($resultadoUno) {
			$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
			$resultadoDos = mysqli_query($conSanatorio,$consulta);
			if ($resultadoDos){								
				if (!empty($codigoPracticaD)){
					$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaD')";
					$practicaDos = mysqli_query($conSanatorio,$consulta);
				}
				if (!empty($codigoPracticaT)){
					$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaT')";
					$practicaTres = mysqli_query($conSanatorio,$consulta);
				}

				if (!empty($matriculaAyuU)){
					$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuU',1)";
					$ayudanteUno = mysqli_query($conSanatorio,$consulta);
				}
				if (!empty($matriculaAyuD)){
					$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuD',1)";
					$ayudanteUno = mysqli_query($conSanatorio,$consulta);
				}
				if (!empty($matriculaAyuT)){
					$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuT',1)";
					$ayudanteUno = mysqli_query($conSanatorio,$consulta);
				}

				if (!empty($matriculaAneste)){
					$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAneste',2)";
					$ayudanteUno = mysqli_query($conSanatorio,$consulta);
				}
			}

			else {
				echo 'ERROR EN INSERTAR PRACTICA';
				$valores['existe'] = "0";
			}
		} else {
			echo 'no ok RESULTADO UNO';
			$valores['existe'] = "0";
		}


		// AYUDANTE

		// $consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$campos[1]',1)";
		// $resultadoTres = mysqli_query($conSanatorio,$consulta);



		
		



		$valores = json_encode($valores);
			echo $valores;
	}
/* -------------cargar mensaje---------------- */
	if(isset($_POST['buscarM']))
    { 
    	$id = $_POST['id'];
		$matricula = $_POST['matricula'];
    	$valores = array();
    	$valores['existe'] = "0";

		

		require_once "../../conUsuario.php";
    	//CONSULTAR
		  $msj = mysqli_query($conUsuario,"SELECT m.fecha_creacion AS fecha,
		  m.id_mensaje AS id,
		  m.titulo AS Titulo, 
		  m.mensaje AS Mensaje, 
		  IF((us.userid=1), 'Administrador del Sistema', us.Nombre) AS Usuario
		  FROM mensajes AS m 
		  INNER JOIN mensajes_usuarios AS me ON me.id_mensaje = m.id_mensaje 
		  LEFT JOIN usuarios AS us ON us.userid = m.id_usuario_creacion
		  WHERE me.userid = $matricula AND m.id_mensaje = $id");


		$rowcount=mysqli_num_rows($msj);
		echo "The total number of rows are: ".$rowcount; 
		  /* while($msjj = mysqli_fetch_array($msj))
		  {
		  	$valores['existe'] = "1"; 
		  	$valores['Fecha'] = $msjj['fecha'];
		  	$valores['Titulo'] = $msjj['Titulo'];;	
			$valores['Mensaje'] = $msjj['Mensaje'];
			$valores['Usuario'] = $msjj['Usuario'];
		  } */

		  while($msjj = $msj->fetch_assoc()){
			$valores['existe'] = "1"; 
			$valores['Fecha'] = $msjj['fecha'];
			$valores['Titulo'] = $msjj['Titulo'];;	
		  	$valores['Mensaje'] = $msjj['Mensaje'];
		  	$valores['Usuario'] = $msjj['Usuario'];
		  }
		  
		  $valores = json_encode($valores);

			echo $valores;
    }



/* -------------SUSPENCION---------------- */
	if(isset($_POST['suspender'])){ 
		$numero = $_POST['numero'];
		$motivo = $_POST['motivo'];
		$valores = array();
		$valores['existe'] = "0";

		$cons = mysqli_query($conSanatorio, "SELECT * FROM motivosuspension WHERE motivo = $motivo");
		while($consulta = mysqli_fetch_array($cons)){
			$desc = $consulta['Descripcion'];
		}
		$consu = mysqli_query($conSanatorio, "SELECT * FROM turnosquirofano WHERE numero = $numero");
		while($consultas = mysqli_fetch_array($consu)){
			$fechaInicio = $consultas['HoraInicio'];
		}
		//fecha actual
		$fechaActual = date("Y-m-d");
		// diferencia entre fecha actual y fecha inicio
		$diferencia = strtotime($fechaInicio) - strtotime($fechaActual);
		//días
		$dias = intval($diferencia/86400);		
		// días menor a 2
		if ($dias < 2){
			// insertar NO REALIZADO
				$modi = mysqli_query($conSanatorio,"UPDATE turnosquirofano 
													SET MotivoSuspension = '$desc',
													FechaSuspension = CURDATE(),
													Estado = 'NO REALIZADO',
													Motivo = '$motivo'
													WHERE numero = $numero");
		}else{
			// insertar Suspendido
			$modi = mysqli_query($conSanatorio,"UPDATE turnosquirofano 
								SET MotivoSuspension = '$desc',
								FechaSuspension = CURDATE(),
								Estado = 'SUSPENDIDO',
								Motivo = '$motivo'
								WHERE numero = $numero");	
		}
		if ($modi){
			$valores['existe'] = "1"; 
		}
			$valores = json_encode($valores);
				echo $valores;
	}
/* --------------Hora Mas Fin--------------- */
	if(isset($_POST['horaMasFin'])){ 
		$tiempoPractica = (int)$_POST['tiempoPractica'];
		$tiempoInicio = $_POST['tiempoInicio'];
		$tiempoMas = $_POST['tiempoMas'];
		$tiempo = $tiempoPractica + $tiempoMas;
		$segundos_horaInicial=strtotime($tiempoInicio);
		$mifecha= date('H:i',$segundos_horaInicial);
		$NuevaFecha = strtotime ( '+'.$tiempo.' minute' , strtotime ($mifecha) ) ;
		$NuevaFecha = date ( 'H:i' , $NuevaFecha);
		$valore = array();
		$valore['existe'] = "1";
		$valore['hf'] = $NuevaFecha;
		$valore = json_encode($valore);
			echo $valore;
	}
/* ---------------GUARDAR MODIFICACIÓN-------------- */
	if(isset($_POST['guardarModi'])){ 

		$NumeroMod = $_POST['NumeroMod'];


		mysqli_query($conSanatorio,"UPDATE turnosquirofano SET Estado = 'MODIFICADO' WHERE Numero = $NumeroMod");



		$resnum = mysqli_query($conSanatorio, "SELECT MAX(Numero+1) AS Numero FROM TurnosQuirofano");

		while($consulta = mysqli_fetch_array($resnum)){

		$numeroTurno = $consulta['Numero'];} //numero de turno		
		$matricula = $_POST['valorMatricula']; // MATRICULA
		$TipoDocumentoIdentidad = $_POST['tipoDocumento']; // TIPO DE DNI
		$DNIPaciente = $_POST['valorDocumento']; // NUMERO DE DOCUMENTO
		$Nombre = $_POST['nomyapel'];// NOMBRE PACIENTE 
		//------ ESTADO------------
			$cons = mysqli_query($conSanatorio, "SELECT turnos FROM Profesionales WHERE Matricula='$matricula'");
			while($turnocons = mysqli_fetch_array($cons)){
				$turnoconf = $turnocons['turnos'];
			}
			if ($turnoconf == 1){
				$estado = 'A CONFIRMAR';
			}else{
				$estado = 'PENDIENTE';
			} 
		// ------------------------ 
		$fech = $_POST['fechas']; // FECHA
		$inicio = $fech.' '.$_POST['horaInicio'].':00'; // HORA DE INICIOS
		$fin = $fech.' '.$_POST['horaFinn'].':00'; // HORA DE Fin
		$obrasocial = $_POST['obrasocial'];//OBRASOCIAL
		$monitoreo = $_POST['monitoreo'];//MONITORIO
		$rx = $_POST['rx']; //RX
		$sangre = $_POST['sangre'];//SANGRE
		$NroRegistro = '0'; //NUMERO REGISTRO
		$NroIngreso = '0'; // numero ingreso
		$numeroQuirofano = $_POST['numeroQuirofano'];
		// Motivo Suspensión
		$tel = $_POST['tel']; // TELEFONO
		$anestesitaRadio = $_POST['anestesitaRadio']; // anestesita
		//TIPO DE CIRUGIA
		//FECHA ALTA
		//FECHA SUSPENSIÓN
		//LOCAL O WEB
		$DateAndTime = date('Y-m-d H:i:s', time()); 
		$fechaGrabacion = $DateAndTime; //fECHA DE GRABACIÓN
		$arcoC = $_POST['arcoC']; //ARCO
		$ForceSana  = $_POST['ForceSana']; //ForceTriad Sanatorio
		$uti = $_POST['uti'];  //Uti
		$laparo = $_POST['laparo']; //LAPAROSCÓPICA		
		$tarea = $_POST['tarea']; //DescripcionCirugia
		$obrasocial = $_POST['obrasocial'];  //CodigoObraSocial
		$ParaInternar = $_POST['tipCirugia']; //ParaInternar
		//Telefono2
		//Observaciones
		//InsumosNoHabituales
		$email = $_POST['email'];  // EMAIL
		$ForcePro = $_POST['ForcePro'] ; // ForceTriad Propio
		// usuario 
		// Intrumentista Propio
		/// PRACTICAS
		$codigoPracticaU = $_POST['codigoPracticaU'];
		$codigoPracticaD = $_POST['codigoPracticaD'];
		$codigoPracticaT = $_POST['codigoPracticaT'];
		/// AYUDANTE

		/// ANESTEsISTA

		$valores = array();
		$valores['existe'] = "1";
		//CONSULTAR

		// echo 'antes de slq';	

						$consulta = "INSERT INTO TurnosQuirofano (  Numero,
																	MatriculaProfesional,
																	TipoDocumentoIdentidad,
																	DNIPaciente,
																	Nombre,
																	Estado,
																	Fecha,
																	HoraInicio,
																	HoraFin,
																	ObraSocial,
																	Monitoreo,
																	RX,
																	Sangre,
																	NroRegistro,
																	NroIngreso,
																	Quirofano,
																	Telefono,
																	Anestesista,
																	FechaGrabacion,
																	Arco,
																	ForceTriad,
																	Uti,
																	Laparoscopica,
																	DescripcionCirugia,
																	CodigoObraSocial,
																	ParaInternar,
																	Email,
																	ForceTriad_Propio)
						VALUES($numeroTurno, 
								$matricula,
								$TipoDocumentoIdentidad,
								$DNIPaciente,
								'$Nombre',
								'$estado',
								'$fech',
								'$inicio',
								'$fin',
								'$obrasocial',
								'$monitoreo',
								'$rx',
								'$sangre',
								$NroRegistro, 
								$NroIngreso,
								$numeroQuirofano,
								'$tel',
								'$anestesitaRadio',
								'$fechaGrabacion',
								'$arcoC',
								'$ForceSana',
								'$uti',
								'$laparo',
								'$tarea',
								'$obrasocial',
								$ParaInternar,
								'$email',
								'$ForcePro')";

								// echo $consulta;

		$resultadoUno = mysqli_query($conSanatorio,$consulta);
		if (!$resultadoUno) {
			echo "Error en la inserción: ".$conSanatorio->error;
		}

		if ($resultadoUno) {
			$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
			$resultadoDos = mysqli_query($conSanatorio,$consulta);
			if ($resultadoDos){								
				if (!empty($codigoPracticaD)){
					$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
					$practicaDos = mysqli_query($conSanatorio,$consulta);
				}
				if (!empty($codigoPracticaT)){
					$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
					$practicaTres = mysqli_query($conSanatorio,$consulta);
				}

				if (!empty($matriculaAyuU)){
					$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuU',1)";
					$ayudanteUno = mysqli_query($conSanatorio,$consulta);
				}
				if (!empty($matriculaAyuD)){
					$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuD',1)";
					$ayudanteUno = mysqli_query($conSanatorio,$consulta);
				}
				if (!empty($matriculaAyuT)){
					$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuT',1)";
					$ayudanteUno = mysqli_query($conSanatorio,$consulta);
				}

				if (!empty($matriculaAneste)){
					$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAneste',2)";
					$ayudanteUno = mysqli_query($conSanatorio,$consulta);
				}
			}

			else {
				echo 'ERROR EN INSERTAR PRACTICA';
				$valores['existe'] = "0";
			}
		} else {
			echo 'no ok RESULTADO UNO';
			$valores['existe'] = "0";
		}

		$valores = json_encode($valores);
			echo $valores;
	}


/* ----------------Laparoscopica------------- */
	if(isset($_POST['lap'])){ 	
		
		require_once "../../confg.php";
		$fech = $_POST['mfec'];
		$tiempoInicio = $_POST['tiempoInicio'];
		$fecha = $fech.' '.$tiempoInicio.':00';
		$fechaActual = strtotime($fecha);


		$valores = array();
		//CONSULTAR

		//echo 'antes de slq';
		$resultados = mysqli_query($conSanatorio,"SELECT * FROM turnosquirofano
													WHERE Laparoscopica = 'Si'
													AND Fecha = '$fech'
													AND Estado = 'Pendiente'");
		
		$cont = 0;
		$v=0;
		while ($verConfig  = @mysqli_fetch_array($resultados)) {
			$valoresI[$cont] = $verConfig["HoraInicio"];  
			$valoresF[$cont] = $verConfig["HoraFin"];  
			$cont++;
		}
		$horaInPra = strtotime($valoresI [0]);
		$fechaFin = strtotime($valoresF [0]);													

		if(!$resultados){
			echo mysqli_error($conSanatorio);
		}
		$row_cnt = mysqli_num_rows($resultados);

		

		for ($i=1; $i < $cont; $i++) { 
			if(($fechaActual >= $horaInPra) && ($fechaActual <= $fechaFin)){
				$v = "1";				
			}

			$horaInPra = strtotime($valoresI [$i]);
			$fechaFin = strtotime($valoresF [$i]);
			
		}
		
		

		if ($row_cnt >= $cantLapa or $v == "1") {
			$valores['existe'] = "0";
			
		}else{
			$valores['existe'] = "1";
		}
		$valores = json_encode($valores);
			echo $valores;
	}
/* -------------arco c---------------- */

	if(isset($_POST['arco'])){ 	
		
		require_once "../../confg.php";
		$fech = $_POST['mfec'];
		$tiempoInicio = $_POST['tiempoInicio'];
		$fecha = $fech.' '.$tiempoInicio.':00';
		$fechaActual = strtotime($fecha);
		$valores = array();
		//CONSULTAR

		//echo 'antes de slq';
		$resultados = mysqli_query($conSanatorio,"SELECT * FROM turnosquirofano
													WHERE Arco = 'Si'
													AND Fecha = '$fech'
													AND Estado = 'Pendiente'");
		
		$cont = 0;
		$v=0;
		while ($verConfig  = @mysqli_fetch_array($resultados)) {
			$valoresI[$cont] = $verConfig["HoraInicio"];  
			$valoresF[$cont] = $verConfig["HoraFin"];  
			$cont++;
		}
		$horaInPra = strtotime($valoresI [0]);
		$fechaFin = strtotime($valoresF [0]);													

		if(!$resultados){
			echo mysqli_error($conSanatorio);
		}
		$row_cnt = mysqli_num_rows($resultados);

		

		for ($i=1; $i < $cont; $i++) { 
			if(($fechaActual >= $horaInPra) && ($fechaActual <= $fechaFin)){
				$v = "1";				
			}

			$horaInPra = strtotime($valoresI [$i]);
			$fechaFin = strtotime($valoresF [$i]);
			
		}
		
		

		if ($row_cnt >= $cantArco or $v == "1") {
			$valores['existe'] = "0";
			
		}else{
			$valores['existe'] = "1";
		}
		$valores = json_encode($valores);
			echo $valores;
	}
		

/* ----------------------------- */
/* ------------GUARDAR TURNO----------------- */
	if(isset($_POST['guardarTurno'])){ 	

		// numero de turno
			$resnum = mysqli_query($conSanatorio, "SELECT MAX(Numero+1) AS Numero FROM TurnosQuirofano");

			while($consulta = mysqli_fetch_array($resnum)){
				$numeroTurno = $consulta['Numero'];
			} 
		//

		$valorMatricula = $_POST['valorMatricula'];
		$tipoDocumento = $_POST['tipoDocumento'];

		$valorDocumento  = $_POST['valorDocumento'];		
		
		

		$nomyapel = $_POST['nomyapel'];

		//------ ESTADO------------
		$matricula = $_POST['valorMatricula']; // MATRICULA
		$cons = mysqli_query($conSanatorio, "SELECT turnos FROM Profesionales WHERE Matricula='$matricula'");
		while($turnocons = mysqli_fetch_array($cons)){
			$turnoconf = $turnocons['turnos'];
		}
		if ($turnoconf == 1){
			$estado = 'A CONFIRMAR';
		}else{
			$estado = 'PENDIENTE';
		}
		// ------------------------

		$fechas = $_POST['fechas'];
		$inicio = $fechas.' '.$_POST['horaInicio'].':00'; // HORA DE INICIOS
			/*$mifecha = $fech.' '.$_POST['horaFin'].':00'; 
			$NuevaFecha = strtotime ($mifecha);
			$newdate  = strtotime ( '+5 minute' , $NuevaFecha ); 
		$fin = date('Y-m-d H:i:s',$newdate); */

		$fin = $fechas.' '.$_POST['horaFinn'].':00';


		
		$Codobrasocial = $_POST['obrasocial'];//CodigoOBRASOCIAL

			$menuDocumento = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(CodigoObraSocial)) AS Codigo,
										Descripcion,Deshabilitada FROM obrassociales 
										WHERE web = '1' AND CodigoObraSocial = '$Codobrasocial'");
			while($row=mysqli_fetch_array($menuDocumento)) {
				$nom = $row['Descripcion'];
			}

			$NomObraSocial = $nom;
		$obrasocial = $NomObraSocial;

		$monitoreo = $_POST['monitoreo'];
		$rx = $_POST['rx'];
		$sangre = $_POST['sangre'];
		$numeroQuirofano = $_POST['numeroQuirofano'];
		$tel = $_POST['tel'];
		$anestesitaRadio = $_POST['anestesitaRadio'];
		

		date_default_timezone_set("America/Argentina/Buenos_Aires");
		$DateAndTime = date('Y-m-d H:i:s', time()); 
		$fechaGrabacion = $DateAndTime; //fECHA DE GRABACIÓN		


		$arcoC = $_POST['arcoC'];
		$ForceSana = $_POST['ForceSana'];
		$uti = $_POST['uti'];
		$laparo = $_POST['laparo'];
		$tarea = $_POST['tarea'];
		$Codobrasocial = $_POST['Codobrasocial'];
		$ParaInternar = $_POST['tipCirugia']; //ParaInternar
		$ForcePro = $_POST['ForcePro'];
		$valorUsuario = $_POST['valorUsuario'];
		
		$codigoPracticaU = $_POST['codigoPracticaU'];
		$codigoPracticaD = $_POST['codigoPracticaD'];
		$codigoPracticaT = $_POST['codigoPracticaT'];

		$consulta = "INSERT INTO TurnosQuirofano (  Numero,
			MatriculaProfesional,
			TipoDocumentoIdentidad,
			DNIPaciente,
			Nombre,
			Estado,
			Fecha,
			HoraInicio,
			HoraFin,
			ObraSocial,
			Monitoreo,
			RX,
			Sangre,
			NroIngreso,
			Quirofano,
			Telefono,
			Anestesista,
			FechaGrabacion,
			Arco,
			ForceTriad,
			Uti,
			Laparoscopica,
			DescripcionCirugia,
			CodigoObrasocial,
			ParaInternar,																
			ForceTriad_Propio,
			usuario)
			VALUES($numeroTurno, 
			$matricula,
			$tipoDocumento,
			$valorDocumento,
			'$nomyapel',
			'$estado',
			'$fechas',
			'$inicio',
			'$fin',
			'$obrasocial',
			'$monitoreo',
			'$rx',
			'$sangre',
			0,
			$numeroQuirofano,
			'$tel',
			'$anestesitaRadio',
			'$fechaGrabacion',
			'$arcoC',
			'$ForceSana',
			'$uti',
			'$laparo',
			'$tarea',
			'$Codobrasocial',
			$ParaInternar,											
			'$ForcePro',
			'$valorUsuario')";

		$resultadoUno = mysqli_query($conSanatorio,$consulta);
		if (!$resultadoUno) {
			echo "Error en la inserción: ".$conSanatorio->error;
		}
		if ($resultadoUno) {
			$valores['existe'] = "1";
			$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
			$resultadoDos = mysqli_query($conSanatorio,$consulta);
			if ($resultadoDos){								
				if (!empty($codigoPracticaD)){
					$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
					$practicaDos = mysqli_query($conSanatorio,$consulta);
				}
				if (!empty($codigoPracticaT)){
					$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
					$practicaTres = mysqli_query($conSanatorio,$consulta);
				}			
			}

			else {
				echo 'ERROR EN INSERTAR PRACTICA';
				$valores['existe'] = "0";
			}
	    } else {
			echo 'no ok RESULTADO UNO';
			$valores['existe'] = "0";
	    }
		$valores = json_encode($valores);
			echo $valores;
	}

/* ----------- Hora inicio Modificar ------------------ */
	if(isset($_POST['mHoras'])){ 
		$mquir = $_POST['mquir'];
		$fechaSelec = $_POST['mfec'];
		$num = $_POST['numero'];

		echo 'fecha seleccionada modi'.$fechaSelec."<br>";
		
		$valoresI = array();
		$valoresF = array();			 
		$vi=0;
		$vf=0;			
		//CONSULTAR
		$Hora = mysqli_query($conSanatorio,"SELECT * FROM quirofanoshorarios WHERE Quirofano = $mquir");
		while($consulta = mysqli_fetch_array($Hora)){					 
			$mI = explode(":", $consulta['HoraInicio']);// 07:30
			$HoIni = $mI[0]; //07
			$minIni = $mI[1]; //30
			$mF = explode(":", $consulta['HoraFin']);// 07:00
			$HoFin = $mI[0]; // 23
			$minFin = $mI[1]; // 30				
			$Intervalo = $consulta['Intervalo']; // 5
			$entreTurno = $consulta['TiempoEntreTurno']; // 30
		}
		
		$ocHora = mysqli_query($conSanatorio,"SELECT tq.numero,tq.Estado,
											tq.Quirofano AS NumQuir, 
											HoraInicio, 
											HoraFin  
											FROM turnosquirofano AS tq 
											INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
											INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
											WHERE Estado IN ('PENDIENTE', 'REALIZADO')
											AND tq.Fecha = '$fechaSelec'
											AND tq.Quirofano = $mquir
											AND tq.numero <> $num
											ORDER BY HoraInicio;");

		$op = '<select> <select class="custom-select">
			<option> </option>';
		$row_cnt = mysqli_num_rows($ocHora);
		$cont = 0;
		$l = 0;

		if ($row_cnt == 0) {			
			for ($h = $HoIni; $h < 24 ; $h++){
				for ($m = 0; $m < 60 ; $m = $m + $Intervalo){
					if ($m < 10){
						$op .= "<option value=".$h.":".$l.$m.">".$h.':'.$l.$m."</option>";
					}else{
						$op .= "<option value=".$h.":".$m.">".$h.':'.$m."</option>";
					}									
				}
			}
			$op.="</select> ";
			echo $op;
		}else{
				while ($verConfig  = @mysqli_fetch_array($ocHora)) {
					$valoresI[$cont] = $verConfig["HoraInicio"];  
					$valoresF[$cont] = $verConfig["HoraFin"];  
					$cont++;
					}
					echo 'cont'.$cont."<br>";
				

				$horaInPra = date("Y-m-d H:i", strtotime($valoresI [0]));
				$horaFiPra = date("Y-m-d H:i", strtotime($valoresF [0]));
				echo 'ini'.$horaInPra.'<br>';
				echo 'fin',$horaFiPra.'<br>'.'<br>';

				$fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPra ) ) ;	
				$horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );

				
				$horaFinOcupada =  strtotime(substr($horaFiPra, 11));
				$horaOcupada = strtotime(substr($horaInPra, 11));
				echo 'ini'.$horaOcupada.'<br>';
				echo 'fin',$horaFinOcupada.'<br>';
				$z = 0;
				$cnn = ($cont - 1);
				echo 'cnn'.$cnn."<br>";

				for ($h = $HoIni; $h < 24 ; $h++){
					for ($m = 0; $m < 60 ; $m = $m + $Intervalo){
						
						$hoy = date("Y-m-d H:i", strtotime($fechaSelec.$h.':'.$m));
						echo 'hora'.$hoy."<br>";
						
						$horaHoy = strtotime(substr($hoy, 11));

						if ((($hoy >= $horaInPra) && ($hoy <= $horaFiPra))){							
								
						}else{
							
								$op .= "<option value=".substr($hoy, 11).">".substr($hoy, 11)."</option>";
								echo '-'."<br>"; // mostrar horas disponibles						
						}
						if ($horaFiPra == $hoy){
							$z++;
							if ($z > $cnn){

							}else{
								$horaInPra = date("Y-m-d H:i", strtotime($valoresI [$z]));
								$horaFiPra = date("Y-m-d H:i", strtotime($valoresF [$z]));
								$horaFinOcupada =  strtotime(substr($horaFiPra, 11));
								$horaOcupada = strtotime(substr($horaInPra, 11));
							}
							
						}
					}

					
				}
				$op.="</select> ";
				echo $op;
		}
	}
/* ----------- Hora Fin Modificar ------------------ */
	if(isset($_POST['horaFinM'])){ 
		
		$codPra = $_POST['codPra'];
		$timInicio = $_POST['tiempoInicio'];
		

			$tiemp = mysqli_query($conSanatorio,"SELECT * FROM practicasquirofano WHERE codigo = '$codPra';");
			while($consulta = mysqli_fetch_array($tiemp)){					 
				$tiempoPractica = $consulta['TiempoEstimado'];
				
			}
		$segundos_horaInicial=strtotime($timInicio);
		
		$segundos_minutoAnadir=$tiempoPractica*60;
		
		$nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
	
		

		$valore['existe'] = "1";
		$valore['hf'] = $nuevaHora;
		$valore = json_encode($valore);
			echo $valore;	
	}
/* ----------- Guardar Modificar ------------------ */
	if(isset($_POST['guardarTurnoModificar'])){ 

		$NumeroMod = $_POST['num'];


		mysqli_query($conSanatorio,"UPDATE turnosquirofano SET Estado = 'MODIFICADO' WHERE Numero = $NumeroMod");


		$resnum = mysqli_query($conSanatorio, "SELECT MAX(Numero+1) AS Numero FROM TurnosQuirofano");

			while($consulta = mysqli_fetch_array($resnum)){
				$numeroTurno = $consulta['Numero'];
			} //numero de turno

			$matricula = $_POST['valorMatricula']; // MATRICULA
			$TipoDocumentoIdentidad = $_POST['tipoDocumento']; // TIPO DE DNI
			$DNIPaciente = $_POST['valorDocumento']; // NUMERO DE DOCUMENTO
			$Nombre = $_POST['nomyapel'];// NOMBRE PACIENTE 
			$valorUsuario = $_POST['valorUsuario']; // USUARIO



			//------ ESTADO------------
				$cons = mysqli_query($conSanatorio, "SELECT turnos FROM Profesionales WHERE Matricula='$matricula'");
				while($turnocons = mysqli_fetch_array($cons)){
					$turnoconf = $turnocons['turnos'];
				}
				if ($turnoconf == 1){
					$estado = 'A CONFIRMAR';
				}else{
					$estado = 'PENDIENTE';
				}
			// ------------------------
			
			$fech = $_POST['fechas']; // FECHA
			$inicio = $fech.' '.$_POST['horaInicio'].':00'; // HORA DE INICIOS


			
			
			$mifecha = $fech.' '.$_POST['horaFinn'].':00'; // HORA DE Fin
			
			$NuevaFecha = strtotime ($mifecha);
			
			$newdate  = strtotime ( '+5 minute' , $NuevaFecha ); 
			$fin =date('Y-m-d H:i:s',$newdate);
			
			$Codobrasocial = $_POST['Codobrasocial'];//CodigoOBRASOCIAL

			$menuDocumento = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(CodigoObraSocial)) AS Codigo,
										Descripcion,Deshabilitada FROM obrassociales 
										WHERE web = '1' AND CodigoObraSocial = '$Codobrasocial'");
			while($row=mysqli_fetch_array($menuDocumento)) {
				$nom = $row['Descripcion'];
			}

			$NomObraSocial = $nom;

			$monitoreo = $_POST['monitoreo'];//MONITORIO
			$rx = $_POST['rx']; //RX
			$sangre = $_POST['sangre'];//SANGRE
			$NroRegistro = '0'; //NUMERO REGISTRO
			$NroIngreso = '0'; // numero ingreso
			$numeroQuirofano = $_POST['numeroQuirofano'];

			
			// Motivo Suspensión
			$tel = $_POST['tel']; // TELEFONO
			$anestesitaRadio = $_POST['anestesitaRadio']; // anestesita
			//TIPO DE CIRUGIA
			//FECHA ALTA
			//FECHA SUSPENSIÓN
			//LOCAL O WEB
			$DateAndTime = date('Y-m-d H:i:s', time()); 
			$fechaGrabacion = $DateAndTime; //fECHA DE GRABACIÓN
			$arcoC = $_POST['arcoC']; //ARCO
			$ForceSana  = $_POST['ForceSana']; //ForceTriad Sanatorio
			$uti = $_POST['uti'];  //Uti
			$laparo = $_POST['laparo']; //LAPAROSCÓPICA		
			$tarea = $_POST['tarea']; //DescripcionCirugia

			
			//CodigoObraSocial
			$ParaInternar = $_POST['tipCirugia']; //ParaInternar
			//Telefono2
			//Observaciones
			
			// $InsumoNH = $_POST['InsumoNH']; InsumosNoHabituales
			
			// $email = $_POST['email'];// EMAIL
			$ForcePro = $_POST['ForcePro'] ; // ForceTriad Propio
			
			// usuario 
			// $intruPro = $_POST['intruPro']; // Intrumentista Propio

			/// PRACTICAS
			$codigoPracticaU = $_POST['codigoPracticaU'];
			
			$codigoPracticaD = $_POST['codigoPracticaD'];
			$codigoPracticaT = $_POST['codigoPracticaT'];

			
			$valores = array();
			$valores['existe'] = "1";
			//CONSULTAR
			
				

							$consulta = "INSERT INTO TurnosQuirofano (  Numero,
																		MatriculaProfesional,
																		TipoDocumentoIdentidad,
																		DNIPaciente,
																		Nombre,
																		Estado,
																		Fecha,
																		HoraInicio,
																		HoraFin,
																		ObraSocial,
																		Monitoreo,
																		RX,
																		Sangre,
																		NroRegistro,
																		NroIngreso,
																		Quirofano,
																		Telefono,
																		Anestesista,
																		FechaGrabacion,
																		Arco,
																		ForceTriad,
																		Uti,
																		Laparoscopica,
																		DescripcionCirugia,
																		CodigoObrasocial,
																		ParaInternar,
																																			
																		ForceTriad_Propio,
																		usuario)
							VALUES($numeroTurno, 
									$matricula,
									$TipoDocumentoIdentidad,
									$DNIPaciente,
									'$Nombre',
									'$estado',
									'$fech',
									'$inicio',
									'$fin',
									'$NomObraSocial',
									'$monitoreo',
									'$rx',
									'$sangre',
									$NroRegistro, 
									$NroIngreso,
									$numeroQuirofano,
									'$tel',
									'$anestesitaRadio',
									'$fechaGrabacion',
									'$arcoC',
									'$ForceSana',
									'$uti',
									'$laparo',
									'$tarea',
									'$Codobrasocial',
									$ParaInternar,
																	
									'$ForcePro',
									'$valorUsuario')";

									// echo $consulta;

			$resultadoUno = mysqli_query($conSanatorio,$consulta);
			if (!$resultadoUno) {
				echo "Error en la inserción: ".$conSanatorio->error;
			}

			if ($resultadoUno) {
				$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
				$resultadoDos = mysqli_query($conSanatorio,$consulta);
				if ($resultadoDos){								
					if (!empty($codigoPracticaD)){
						$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
						$practicaDos = mysqli_query($conSanatorio,$consulta);
					}
					if (!empty($codigoPracticaT)){
						$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$codigoPracticaU')";
						$practicaTres = mysqli_query($conSanatorio,$consulta);
					}

					if (!empty($matriculaAyuU)){
						$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuU',1)";
						$ayudanteUno = mysqli_query($conSanatorio,$consulta);
					}
					if (!empty($matriculaAyuD)){
						$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuD',1)";
						$ayudanteUno = mysqli_query($conSanatorio,$consulta);
					}
					if (!empty($matriculaAyuT)){
						$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAyuT',1)";
						$ayudanteUno = mysqli_query($conSanatorio,$consulta);
					}

					if (!empty($matriculaAneste)){
						$consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$matriculaAneste',2)";
						$ayudanteUno = mysqli_query($conSanatorio,$consulta);
					}
				}

				else {
					echo 'ERROR EN INSERTAR PRACTICA';
					$valores['existe'] = "0";
				}
			} else {
				echo 'no ok RESULTADO UNO';
				$valores['existe'] = "0";
			}


			// AYUDANTE

			// $consulta = "INSERT INTO turnosquirofanoayudante (numero,matprofesional,tipoayudante) values ('$numeroTurno','$campos[1]',1)";
			// $resultadoTres = mysqli_query($conSanatorio,$consulta);



			
			



			$valores = json_encode($valores);
				echo $valores;
	}