<?php
    require_once "../../conSanatorio.php";
    require_once "../../conUsuario.php";


/* -----------MUESTRA VALORES EN LA TABLA POR LA FECHA SELECCIONADA------------------ */
if(isset($_POST['fbuscar'])){ 
    $quirodanoselec = $_POST['mquir'];
    $fechaSelec = $_POST['mfec'];                
    
    // verificar si quirodanoselec esta vació
    if(empty($quirodanoselec)){ //"No selecciono ningun quirofano"            
        $turnTabla = mysqli_query($conSanatorio,"SELECT tq.Numero,tq.Estado,
                                                    tq.Quirofano AS NumQuir, 
                                                    DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
                                                    DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin,  
                                                    LTRIM(RTRIM(pr.Nombre))AS NomMedico, 
                                                    SUBSTRING(pa.Descripcion,1,50) AS DescriPractica,
                                                    q.Descripcion
                                                    FROM turnosquirofano AS tq 
                                                    INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                                    INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
                                                    INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                                    INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
                                                    WHERE tq.Estado = 'PENDIENTE'
                                                    AND tq.Fecha = '$fechaSelec'
                                                    GROUP BY tq.Numero
                                                    ORDER BY  q.orden, HoraInicio;");
        $salida = '<div class="table-responsive">
        <table style="width: 100%" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" style="width: 15%">Quirofano</th>
                    <th scope="col" style="width: 10%">Estado</th>
                    <th scope="col" style="width: 8%">Desde</th>
                    <th scope="col" style="width: 8%">Hasta</th>
                    <th scope="col">Profesional</th>
                    <th scope="col">Practica</th>
                </tr>
            </thead>
        </table> 
            
        <table class="table table-striped">
            <tbody>';
        while($fila = $turnTabla->fetch_assoc()){
                    $salida.=
                            '<tr>
                                <td>'.$fila['Descripcion'].'<td>
                                <td>'.$fila['Estado'].'<td>
                                <td>'.$fila['HoraInicio'].'<td>
                                <td>'.$fila['HoraFin'].'<td>
                                <td>'.utf8_encode($fila['NomMedico']).'<td>
                                <td>'.utf8_encode($fila['DescriPractica']).'<td>
                            </tr>';				
                } 
            $salida.='</tbody>
                    </table> 
                </div>';
        echo $salida;
    }else{            
        $turnTabla = mysqli_query($conSanatorio,"SELECT tq.Numero,tq.Estado,
                                                    tq.Quirofano AS NumQuir, 
                                                    DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
                                                    DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin,  
                                                    LTRIM(RTRIM(pr.Nombre))AS NomMedico, 
                                                    SUBSTRING(pa.Descripcion,1,50) AS DescriPractica,
                                                    q.Descripcion
                                                    FROM turnosquirofano AS tq 
                                                    INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                                    INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
                                                    INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                                    INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
                                                    WHERE tq.Estado = 'PENDIENTE'
                                                    AND tq.Fecha = '$fechaSelec'
                                                    AND tq.Quirofano = '$quirodanoselec'
                                                    GROUP BY tq.Numero
                                                    ORDER BY q.orden, HoraInicio;");
        $salida = '<div class="table-responsive">
        <table style="width: 100%" class="table table-striped">
            <thead>
                <tr>                        
                    <th scope="col" style="width: 13%">Estado</th>
                    <th scope="col" style="width: 8%">Desde</th>
                    <th scope="col">Hasta</th>
                    <th scope="col">Profesional</th>
                    <th scope="col">Practica</th>
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
                                <td>'.utf8_encode($fila['NomMedico']).'<td>
                                <td>'.utf8_encode($fila['DescriPractica']).'<td>
                            </tr>';				
                } 
            $salida.='</tbody>
                    </table> 
                </div>';
        echo $salida;
    }       
}
/* -----------Hora Inicio Turno------------------ */
if(isset($_POST['HorasTurnos'])){     
    $mquir = $_POST['mquir'];
	$fechaSelec = $_POST['mfec'];
	$codPrac1 = $_POST['codPrac1'];

	$pr = mysqli_query ($conSanatorio,"SELECT * FROM practicasquirofano WHERE Codigo = '$codPrac1';");
	while($consultapr = mysqli_fetch_array($pr)){					 
		$tiempoPracticar = $consultapr['TiempoEstimado'];// 
	}

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
	
	$tiempoPractica = $tiempoPracticar + $entreTurno;
    echo $tiempoPractica;

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
                                        GROUP BY tq.Numero
										ORDER BY HoraInicio;");

	$op = '<select> <select class="custom-select">
		<option> </option>';
	$row_cnt = mysqli_num_rows($ocHora);
	$cont = 0;
	$l = 0;
    echo $row_cnt."<br>";

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

			$horaInPra = date("Y-m-d H:i", strtotime($valoresI [0]));
			$horaFiPra = date("Y-m-d H:i", strtotime($valoresF [0]));
	
			/// sumo intervalo
			$fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPra ) ) ;	
			$horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );
			// resto hora a una fecha inicio
			$fechaAuxiliarR	= strtotime ( '-'.$tiempoPractica.' minutes' , strtotime ( $horaInPra ) ) ;						
			$horaInPra	= date ( 'Y-m-d H:i' , $fechaAuxiliarR );

			$horaFinOcupada =  strtotime(substr($horaFiPra, 11));
			$horaOcupada = strtotime(substr($horaInPra, 11));
	
			$z = 0;
			$cnn = ($cont - 1);
	
			for ($h = $HoIni; $h < 24 ; $h++){
				for ($m = 0; $m < 60 ; $m = $m + $Intervalo){
					
					$hoy = date("Y-m-d H:i", strtotime($fechaSelec.$h.':'.$m));
						
					$horaHoy = strtotime(substr($hoy, 11));

					if ((($hoy >= $horaInPra) && ($hoy <= $horaFiPra))){							
							
					}else{
						
							$op .= "<option value=".substr($hoy, 11).">".substr($hoy, 11)."</option>";
	
					}
					if ($horaFiPra == $hoy){
						$z++;
						if ($z > $cnn){
	
						}else{
	
							$horaInPra = date("Y-m-d H:i", strtotime($valoresI [$z]));
							$horaFiPrac = date("Y-m-d H:i", strtotime($valoresF [$z]));                            

							//sumo Intervalo
							$fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPrac ) ) ;	
							$horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );
							// resto hora a una fecha inicio
							$fechaAuxiliarR	= strtotime ( '-'.$tiempoPractica.' minutes' , strtotime ( $horaInPra ) ) ;						
							$horaInPra	= date ( 'Y-m-d H:i' , $fechaAuxiliarR );
						}
						
					}
				}
			}
			$op.="</select> ";
			echo $op;
	}
}
if (isset($_POST['HorasTurnosCesaria'])){
    echo 'cesaria';
    $mquir = $_POST['mquir'];
	$fechaSelec = $_POST['mfec'];
	$codPrac1 = $_POST['codPrac1'];
    
    $pr = mysqli_query ($conSanatorio,"SELECT * FROM practicasquirofano WHERE Codigo = '$codPrac1';");
	while($consultapr = mysqli_fetch_array($pr)){					 
		$tiempoPracticar = $consultapr['TiempoEstimado'];// 
	}

	$valoresI = array();
	$valoresF = array();
    $marca = array();
	$vi=0;
	$vf=0;			
	//CONSULTAR
	$Hora = mysqli_query($conSanatorio,"SELECT * FROM quirofanoshorarios WHERE Quirofano = $mquir");
	while($consulta = mysqli_fetch_array($Hora)){					 
		$mI = $consulta['HoraInicio'];// 07:30		
		$mF = $consulta['HoraFin'];// 07:00					
		$Intervalo = $consulta['Intervalo']; // 5
		$entreTurno = $consulta['TiempoEntreTurno']; // 30
	}

	$mifecha = strtotime(date ( 'H:i' , strtotime('05:50')));
    echo 'Fecha'.$mifecha."<br>";

	$tiempoPractica = $tiempoPracticar + $entreTurno;
    echo 'tiempo practica'.$tiempoPractica."<br>";


    $op = '<select> <select class="custom-select">
		<option> </option>';
        $ocHora = mysqli_query($conSanatorio,"SELECT tq.numero,tq.Estado,
                                                tq.Quirofano AS NumQuir,
                                                fecha, 
                                                Marca,
                                                SUBSTRING(HoraInicio,12,5) AS HoraInicio,
                                                SUBSTRING(HoraFin,12,5) AS HoraFin  
                                                FROM turnosquirofano AS tq 
                                                INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                                INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                                WHERE Estado IN ('PENDIENTE', 'REALIZADO')
                                                AND tq.Fecha = '$fechaSelec'
                                                AND tq.Quirofano = 6
                                                GROUP BY tq.Numero
                                                ORDER BY HoraInicio;");
	$row_cnt = mysqli_num_rows($ocHora);
	$cont = 0;
	$l = 0;
    echo 'cantidad de registro'.$row_cnt."<br>";
    if ($row_cnt == 0) {
        for ($i = 0; $i < 15; $i++) {

            $NuevaFecha = strtotime ( '+70 minute' , $mifecha); 

            $mifecha = date ( 'H:i' , $NuevaFecha);
    
            $op .= "<option value=".$mifecha.">".$mifecha."</option>";
            
            $mifecha = strtotime($mifecha);
        }
	}else{
            $ocHoras = mysqli_query($conSanatorio,"SELECT tq.numero,tq.Estado,
                                                    tq.Quirofano AS NumQuir,
                                                    fecha, 
                                                    Marca,
                                                    SUBSTRING(HoraInicio,12,5) AS HoraInicio,
                                                    SUBSTRING(HoraFin,12,5) AS HoraFin  
                                                    FROM turnosquirofano AS tq 
                                                    INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                                    INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                                    WHERE Estado IN ('PENDIENTE', 'REALIZADO')
                                                    AND tq.Fecha = '$fechaSelec'
                                                    AND tq.Quirofano = 6
                                                    GROUP BY tq.Numero
                                                    ORDER BY HoraInicio;");
        while ($verConfig  = @mysqli_fetch_array($ocHoras)) {
            $vI[$cont] = strtotime($verConfig["HoraInicio"]);
            $valoresF[$cont] = strtotime($verConfig["HoraFin"]);
            $marca[$cont] = $verConfig["Marca"];
            $cont++;}
            
            echo 'marcaPrueba'.$marca[0]."<br>";
            echo 'InicioPrueba'.$marca[0]."<br>";
            
            $vacio = 0;
            $vacio2 = 0;
            for ($i = 0; $i < $cont; $i++){
                    if ($marca[$i] == 1){
                        $vacio = 1;
                    }else{
                        $vacio2 = 1;
                    }
                    echo 'marca'.$marca[$i]."<br>";                    
            }
            $cont =  $cont - 1;
            echo 'vacio1   '.$vacio."<br>";
            echo 'vacio2   '.$vacio2."<br>";
                $r=0;
            if (($vacio == 1) && ($vacio2 == 0)) {
                $mfecha = strtotime(date ( 'H:i' , strtotime('05:50')));
                $NuevaFecha = strtotime ( '+70 minute' , $mfecha);
                for ($i = 0; $i < 15; $i++) {

                    
                    echo 'fecha adentro'.date ( 'H:i' , $NuevaFecha)."<br>";
                    echo 'fecha baseD'.date ( 'H:i' , $vI [$r] )."<br>";
                    if ( $NuevaFecha == $vI [$r] ) {
                        if ($r < $cont){
                            $r=$r+1;
                        }
                        echo 'igual'.$r."<br>";
                         
                    } else {
                        
                        $mfecha = date ( 'H:i' , $NuevaFecha);
            
                        $op .= "<option value=".$mfecha.">".$mfecha."</option>";
                        
                    }
                    $mfecha = $NuevaFecha;
                    $NuevaFecha = strtotime ( '+70 minute' , $mfecha);                     
                    
                }
            } else {
    # code...
                    $pr = mysqli_query ($conSanatorio,"SELECT * FROM practicasquirofano WHERE Codigo = '$codPrac1';");
        while($consultapr = mysqli_fetch_array($pr)){					 
            $tiempoPracticar = $consultapr['TiempoEstimado'];// 
        }

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
        
        $tiempoPractica = $tiempoPracticar + $entreTurno;
        echo $tiempoPractica;

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
                                            GROUP BY tq.Numero
                                            ORDER BY HoraInicio;");

        $op = '<select> <select class="custom-select">
            <option> </option>';
        $row_cnt = mysqli_num_rows($ocHora);
        $cont = 0;
        $l = 0;
        echo $row_cnt."<br>";

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
                echo 'else'."<br>";
                while ($verConfig  = @mysqli_fetch_array($ocHora)) {
                    $valoresI[$cont] = $verConfig["HoraInicio"];  
                    $valoresF[$cont] = $verConfig["HoraFin"];  
                    $cont++;
                    }               

                $horaInPra = date("Y-m-d H:i", strtotime($valoresI [0]));
                $horaFiPra = date("Y-m-d H:i", strtotime($valoresF [0]));
        
                /// sumo intervalo
                $fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPra ) ) ;	
                $horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );
                // resto hora a una fecha inicio
                $fechaAuxiliarR	= strtotime ( '-'.$tiempoPractica.' minutes' , strtotime ( $horaInPra ) ) ;						
                $horaInPra	= date ( 'Y-m-d H:i' , $fechaAuxiliarR );

                $horaFinOcupada =  strtotime(substr($horaFiPra, 11));
                $horaOcupada = strtotime(substr($horaInPra, 11));
        
                $z = 0;
                $cnn = ($cont - 1);
        
                for ($h = $HoIni; $h < 24 ; $h++){
                    for ($m = 0; $m < 60 ; $m = $m + $Intervalo){
                        
                        $hoy = date("Y-m-d H:i", strtotime($fechaSelec.$h.':'.$m));
                            
                        $horaHoy = strtotime(substr($hoy, 11));

                        if ((($hoy >= $horaInPra) && ($hoy <= $horaFiPra))){							
                                
                        }else{
                            
                                $op .= "<option value=".substr($hoy, 11).">".substr($hoy, 11)."</option>";
        
                        }
                        if ($horaFiPra == $hoy){
                            $z++;
                            if ($z > $cnn){
        
                            }else{
        
                                $horaInPra = date("Y-m-d H:i", strtotime($valoresI [$z]));
                                $horaFiPrac = date("Y-m-d H:i", strtotime($valoresF [$z]));                            

                                //sumo Intervalo
                                $fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPrac ) ) ;	
                                $horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );
                                // resto hora a una fecha inicio
                                $fechaAuxiliarR	= strtotime ( '-'.$tiempoPractica.' minutes' , strtotime ( $horaInPra ) ) ;						
                                $horaInPra	= date ( 'Y-m-d H:i' , $fechaAuxiliarR );
                            }
                            
                        }
                    }
                }			
            }
    # code...
            }           
        }
        

        $op.="</select> ";
            echo $op;
}
/*------------ tiempo practica --------------*/
if (isset($_POST['tiempoPr'])){
    $pract = $_POST['pract']; 
    $pr = mysqli_query ($conSanatorio,"SELECT * FROM practicasquirofano WHERE Codigo = '$pract';");
    
	while($consultapr = mysqli_fetch_array($pr)){					 
		$tiempoPracticar = $consultapr['TiempoEstimado'];// 
	}
    $op = "<div class='alert alert-light' role='alert'>
                Tiempo establecido de la practica seleccionada es de ".$tiempoPracticar." minutos.
                Por favor seleccione a continuación la hora de inicio
            </div>";
    echo $op;
}
/* -------------Hora Fin---------------- */
if(isset($_POST['HoraFinTurno'])){ 
    $tiempoInicio = $_POST['tiempoInicio'];
    $codPrac1 = $_POST['codPrac1'];
    $tiempomas = $_POST['tiempomas'];

    $pr = mysqli_query ($conSanatorio,"SELECT * FROM practicasquirofano WHERE Codigo = '$codPrac1';");
	while($consultapr = mysqli_fetch_array($pr)){					 
		$tiempoPracticar = $consultapr['TiempoEstimado'];// 
	}
    $tiempoPracticar = $tiempoPracticar + $tiempomas + 10;
    // pasar tiempoPractica a formato hora
    $NuevaFecha = strtotime ( '+'.$tiempoPracticar.' minute' , strtotime ($tiempoInicio) ) ; 
    $NuevaFecha = date ( 'H:i' , $NuevaFecha); 
    $valore = array();
    $valore['existe'] = "1";
    $valore['hf'] = $NuevaFecha;
    $valore = json_encode($valore);
        echo $valore;	
}
if(isset($_POST['HoraFinTurnoCesaria'])){ 
    $tiempoInicio = $_POST['tiempoInicio'];    
    $tiempoPracticar = 60;
    // pasar tiempoPractica a formato hora
    $NuevaFecha = strtotime ( '+'.$tiempoPracticar.' minute' , strtotime ($tiempoInicio) ) ; 
    $NuevaFecha = date ( 'H:i' , $NuevaFecha); 
    $valore = array();
    $valore['existe'] = "1";
    $valore['hf'] = $NuevaFecha;
    $valore = json_encode($valore);
        echo $valore;	
}
/* ----------- Sumar TiempoPracticar ----------- */
if(isset($_POST['SumarTurnos'])){
    $tiempoFin = $_POST['tiempoFin'];
    $tiempomas = $_POST['tiempomas'];

    $NuevaFecha = strtotime ( '+'.$tiempomas.' minute' , strtotime ($tiempoFin) ) ; 
    $NuevaFecha = date ( 'H:i' , $NuevaFecha); 
    $valore = array();
    $valore['existe'] = "1";
    $valore['hf'] = $NuevaFecha;
    $valore = json_encode($valore);
        echo $valore;	
}
/*----------------Chequear turno----------------*/
if(isset($_POST['chequearTurno'])){
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
/*---------- CHEQUEAR DOC --------*/
if(isset($_POST['chequearTurnoDoc'])){
    $fech = $_POST['mfec'];
    $inicio = $fech.' '.$_POST['tiempoInicio'].':00';
    $fin = $fech.' '.$_POST['tiempoFin'].':00';
    $mquir = $_POST['mquir'];
    $valorMatricula = $_POST['valorMatricula'];

    $valores = array();
    //CONSULTAR

   $resultados = mysqli_query($conSanatorio,"SELECT * FROM TurnosQuirofano 
                                                WHERE (
                                                    ((HoraInicio <= '$inicio') AND (HoraFin >= '$inicio')) OR ((HoraInicio <= '$fin') AND (HoraFin >= '$fin')) OR ((HoraFin >= '$inicio') AND (HoraInicio <= '$fin'))
                                                    )                                                
                                                AND Estado = 'PENDIENTE'
                                                AND MatriculaProfesional = $valorMatricula;");

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
/* --------- Datos pacientes ------------------*/
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
      
            $Minicio = $fech.' '.$_POST['horaInicio'].':00'; // HORA DE INICIOS    
            $NuevaFechaI = strtotime ($Minicio);
        $inicio =date('Y-m-d H:i:s',$NuevaFechaI);
    
            $Mfin = $fech.' '.$_POST['horaFin'].':00'; // HORA DE Fin
            $NuevaFechaF = strtotime ($Mfin);
        $fin =date('Y-m-d H:i:s',$NuevaFechaF);
    
        
    
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
        $tipCirugia = $_POST['tipCirugia']; //TIPO DE CIRUGIA
        //FECHA ALTA
        //FECHA SUSPENSIÓN
        //LOCAL O WEB
        date_default_timezone_set("America/Argentina/Tucuman");
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
                                                                    Instrumentista_Propio,
                                                                    Marca)
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
                                '$intruPro',
                                    1 )";
    
    
    
        $resultadoUno = mysqli_query($conSanatorio,$consulta);
        if (!$resultadoUno) {
            echo "Error en la inserción Guardar: ".$conSanatorio->error;
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

/*------------ TODOS LOS TURNOS -------------------*/
if(isset($_POST['todosTurnos'])){
    $fecha = $_POST['fecha'];
    $menuQuirofano = $_POST['menuQuirofano'];

    if ($menuQuirofano == 00) {
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado AS Estado,
                                            tq.numero AS numero,
                                            CASE DAYOFWEEK(fecha)
                                                WHEN 1 THEN 'Domingo'
                                                WHEN 2 THEN 'Lunes'
                                                WHEN 3 THEN 'Martes'
                                                WHEN 4 THEN 'Miércoles'
                                                WHEN 5 THEN 'Jueves'
                                                WHEN 6 THEN 'Viernes'
                                                WHEN 7 THEN 'Sábado'
                                                END Dia,
                                            Fecha, 
                                            DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
                                            DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin, 
                                            LTRIM(RTRIM(tq.Nombre)) AS Paciente, 
                                            SUBSTRING(pa.Descripcion,1,90) AS DescriPractica,
                                            pr.Nombre AS DocNombre,
                                            q.Descripcion AS quirdes,
                                            q.orden AS orden,
                                            tq.Arco AS Arco,
                                            tq.Uti AS  Uti ,
                                            tq.laparoscopica AS  laparoscopica ,
                                            tq.forcetriad_propio AS  forcetriad_propio ,
                                            tq.forcetriad AS forcetriad 
                                            FROM turnosquirofano AS tq 
                                            INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                            INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
                                            INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                            INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
                                            WHERE Fecha = '$fecha'
                                            AND tq.Estado = 'PENDIENTE'        
                                            GROUP BY tq.numero
                                            ORDER BY Fecha,orden, HoraInicio");    
    }else{
        $query = mysqli_query($conSanatorio, "SELECT tq.Estado AS Estado,
                                            tq.numero AS numero,
                                            CASE DAYOFWEEK(fecha)
                                                WHEN 1 THEN 'Domingo'
                                                WHEN 2 THEN 'Lunes'
                                                WHEN 3 THEN 'Martes'
                                                WHEN 4 THEN 'Miércoles'
                                                WHEN 5 THEN 'Jueves'
                                                WHEN 6 THEN 'Viernes'
                                                WHEN 7 THEN 'Sábado'
                                                END Dia,
                                            Fecha, 
                                            DATE_FORMAT(HoraInicio,'%H:%i') AS HoraInicio, 
                                            DATE_FORMAT(HoraFin,'%H:%i') AS HoraFin, 
                                            LTRIM(RTRIM(tq.Nombre)) AS Paciente, 
                                            SUBSTRING(pa.Descripcion,1,90) AS DescriPractica,
                                            pr.Nombre AS DocNombre,
                                            q.Descripcion AS quirdes,
                                            q.orden AS orden,
                                            tq.Arco AS Arco,
                                            tq.Uti AS  Uti ,
                                            tq.laparoscopica AS  laparoscopica ,
                                            tq.forcetriad_propio AS  forcetriad_propio ,
                                            tq.forcetriad AS forcetriad 
                                            FROM turnosquirofano AS tq 
                                            INNER JOIN quirofanos AS q ON q.Numero = tq.Quirofano 
                                            INNER JOIN Profesionales AS pr ON pr.Matricula = tq.MatriculaProfesional
                                            INNER JOIN TurnosQuirofanosPracticas AS tu ON tu.Numero = tq.Numero
                                            INNER JOIN PracticasQuirofano AS pa ON pa.Codigo = tu.Codigopractica
                                            WHERE Fecha = '$fecha'
                                            AND q.numero = $menuQuirofano
                                            AND tq.Estado <> 'Modificado'
                                            AND tq.Estado <> 'Suspendido'
                                            GROUP BY tq.numero
                                            ORDER BY Fecha,orden, HoraInicio"
                                            );
    }

    


    $n = 0;
    $salida = '<div class="table-responsive">
        <table class="display compact table table-condensed table-striped table-bordered table-hover" id="example">
            <thead>
                <tr class="bg-light text-dark">
                    <th scope="col">Estado</th> 
                    <th scope="col">Num</th>
                    <th scope="col"> </th>
                    <th>Quirofano</th>                                       
                    <th>Fecha</th>
                    <th>Hora Inicio</th> 
                    <th>Hora Fin</th>                     
                    <th>Práctica</th>
                    <th>Doctor</th>
                    <th>Arco</th>
                    <th>Uti</th>
                    <th>laparoscopica</th>
                    <th>forcetriad propio</th>
                    <th>forcetriad</th>
                </tr>
            </thead>                             
            <tbody>';
        while($fila = $query->fetch_assoc()){
                        $date = substr($fila['Fecha'], 0, -9);
                        $n = $n + 1;
                        $newDate = date("d-m-Y", strtotime($date));                        
                    $salida.=
                            '<tr>
                            <td>'.$n.'</td>';
                            if ($fila['Estado'] == 'PENDIENTE'){
                    $salida.= '<td style="background:#2a25be ; color: #fff;" >P</td>';
                            }else if ($fila['Estado'] == 'MODIFICADO'){
                    $salida.= '<td style="background:#be9625 ; color: #fff;" >'.$fila['Estado'].'</td>';
                            }else if ($fila['Estado'] == 'SUSPENDIDO'){
                    $salida.= '<td style="background:#95163c ; color: #fff;" >'.$fila['Estado'].'</td>';
                            }else{
                    $salida.= '<td>'.$fila['Estado'].'</td>';
                            }                                
                     $salida.= '
                                <td>        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalCenter" onclick="Sus('.$fila['numero'].')" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspender" > <img  src="../../images/file-x.svg"> </button> 
                                            <button type="button" class="btn btn-warning btn-sm" onclick="Modificar('.$fila['numero'].')" data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar"> <img  src="../../images/pencil-square.svg"></img> </button> 
                                </td>
                                <td>'.$fila['quirdes'].'</td>
                                <td>'.$newDate.'</td>
                                <td>'.$fila['HoraInicio'].'</td>
                                <td>'.$fila['HoraFin'].'</td>
                                <td>'.utf8_encode($fila['DescriPractica']).'</td>
                                <td>'.utf8_encode($fila['DocNombre']).'</td>
                                <td>'.utf8_encode($fila['Arco']).'</td>
                                <td>'.utf8_encode($fila['Uti']).'</td>
                                <td>'.utf8_encode($fila['laparoscopica']).'</td>
                                <td>'.utf8_encode($fila['forcetriad_propio']).'</td>
                                <td>'.utf8_encode($fila['forcetriad']).'</td>
                            </tr>';				
                } 
            $salida.='</tbody>
                    </table> 
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#example").DataTable({ 
                            "language": {
                            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                            },
                            dom: "Bfrtip",
                            buttons: [
                                {
                                    extend: "excel",
                                    split: [ "pdf", "print"],
                                }
                            ]    
                        });
                    });
                </script>';
        echo $salida;
}

/*------------ Traer datos Modificar -------------------*/
/*if(isset($_POST['TraerDatos']))

    {      
    	$n = $_POST['nume'];		
    	
    	
        $valores = [];
        $valores['existe'] = "0";

        
        
    	//CONSULTAR
		  $resultados = mysqli_query($conSanatorio,"SELECT * FROM turnosquirofano WHERE numero = $n");
          $resultados2 = mysqli_query($conSanatorio,"SELECT * FROM turnosquirofanospracticas  WHERE numero = $n");


           /* if ($resultado = mysqli_query($conSanatorio,"SELECT * FROM turnosquirofano WHERE numero = $n")) {
                printf("La selección devolvió %d filas.\n", mysqli_num_rows($resultado));
            
                 liberar el conjunto de resultados 
                mysqli_free_result($resultado);
            }



		  while($consulta = mysqli_fetch_array($resultados))
		  {
            
		  	$valores['existe'] = "1"; 
            $valores['Numero'] = utf8_encode($consulta ["Numero"]);
            $valores['MatriculaProfesional'] = utf8_encode($consulta ["MatriculaProfesional"]);
            $valores['DNIPaciente'] = utf8_encode($consulta ["DNIPaciente"]);
            $valores['Nombre'] = utf8_encode($consulta ["Nombre"]);
            $valores['Estado'] = utf8_encode($consulta ["Estado"]);
                                $fecha = $consulta ["Fecha"];
                                $fechaEntera = strtotime($fecha);
                                $fecha = date("Y-m-d", $fechaEntera);
            $valores['Fecha'] = $fecha;
                                $fechaI = $consulta ["HoraInicio"];
                                $fechaIE = strtotime($fechaI);
                                $Inicio = date("H:i", $fechaIE);
            $valores['HoraInicio'] = $Inicio;
                                $fechaF = $consulta ["HoraFin"];
                                $fechaFE = strtotime($fechaF);
                                $Fin = date("H:i", $fechaFE);
            $valores['HoraFin'] = $Fin;
            $valores['ObraSocial'] = utf8_encode($consulta ["ObraSocial"]);
            $valores['Monitoreo'] = utf8_encode($consulta ["Monitoreo"]);
            $valores['RX'] = utf8_encode($consulta ["RX"]);
            $valores['Sangre'] = utf8_encode($consulta ["Sangre"]);
            $valores['Quirofano'] = utf8_encode($consulta ["Quirofano"]);
            $valores['TipoCirugia'] = utf8_encode($consulta ["TipoCirugia"]);
            $valores['Arco'] =utf8_encode( $consulta ["Arco"]);
            $valores['ForceTriad'] = utf8_encode($consulta ["ForceTriad"]);
            $valores['Uti'] = utf8_encode($consulta ["Uti"]);
            $valores['Laparoscopica'] = utf8_encode($consulta ["Laparoscopica"]);
            $valores['DescripcionCirugia'] = utf8_encode($consulta ["DescripcionCirugia"]);
            $valores['CodigoObraSocial'] = utf8_encode($consulta ["CodigoObraSocial"]);
            $valores['ParaInternar'] = utf8_encode($consulta ["ParaInternar"]);

        }

        while($consulta = mysqli_fetch_array($resultados2))
		  {
            $valores['Numero1Practica'] = utf8_encode($consulta ["Numero"]);
            $valores['Codigo1Practica'] = utf8_encode($consulta ["CodigoPractica"]);
          }

		  $valores = json_encode($valores,JSON_THROW_ON_ERROR);
		
          echo $valores;
          
    }
*/



/*----------------- MODIFICAR ----------------------------*/
/* ----------- Hora inicio Modificar ------------------ */
if(isset($_POST['HorasTurnosModificar'])){ 
	$mquir = $_POST['mquir'];
	$fechaSelec = $_POST['mfec'];
	$codPrac1 = $_POST['codPrac1'];
	$numero = $_POST['numero'];

	$pr = mysqli_query ($conSanatorio,"SELECT * FROM practicasquirofano WHERE Codigo = '$codPrac1';");
	while($consultapr = mysqli_fetch_array($pr)){					 
		$tiempoPracticar = $consultapr['TiempoEstimado'];// 
	}
 
	echo 'tiempo Estimado'.$tiempoPracticar."<br>";

	

	echo 'fecha seleccionada nueva'.$fechaSelec."<br>";
	
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
	$tiempoPractica = $tiempoPracticar + $entreTurno;

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
										AND tq.numero <> $numero
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

			/// sumo intervalo
			$fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPra ) ) ;	
			$horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );
			// resto hora a una fecha inicio
			$fechaAuxiliarR	= strtotime ( '-'.$tiempoPractica.' minutes' , strtotime ( $horaInPra ) ) ;						
			$horaInPra	= date ( 'Y-m-d H:i' , $fechaAuxiliarR );

			echo 'horamas'.$horaFiPra."<br>";

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
							$horaFiPrac = date("Y-m-d H:i", strtotime($valoresF [$z]));
							//sumo Intervalo
							$fechaAuxiliar	= strtotime ( $entreTurno.' minutes' , strtotime ( $horaFiPrac ) ) ;	
							$horaFiPra	= date ( 'Y-m-d H:i' , $fechaAuxiliar );
							// resto hora a una fecha inicio
							$fechaAuxiliarR	= strtotime ( '-'.$tiempoPractica.' minutes' , strtotime ( $horaInPra ) ) ;						
							$horaInPra	= date ( 'Y-m-d H:i' , $fechaAuxiliarR );
						}
						
					}
				}

				
			}
			$op.="</select> ";
			echo $op;
	}
}
/* ----------- Hora Fin Modificar ------------------ */
if(isset($_POST['horaFinMas'])){ 
	
	$codPra = $_POST['codPra'];
	$tiempoMas = $_POST['tiempoMas'];
	$timInicio = $_POST['tiempoInicio'];

		$tiemp = mysqli_query($conSanatorio,"SELECT * FROM practicasquirofano WHERE codigo = '$codPra';");
		while($consulta = mysqli_fetch_array($tiemp)){					 
			$tiempoPractica = $consulta['TiempoEstimado'];			
		}

		$segundos_horaInicial=strtotime($timInicio);
	
		$segundos_minutoAnadir=($tiempoPractica + $tiempoMas) *60;
	
		$nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);


	$valore['existe'] = "1";
	$valore['hf'] = $nuevaHora;
	$valore = json_encode($valore);
		echo $valore;	
}
/*----------------Chequear turno Modificacion----------------*/
if(isset($_POST['confirmarModi'])){
    $fech = $_POST['mfec'];
	$inicio = $fech.' '.$_POST['horaInicio'].':00';
	$fin = $fech.' '.$_POST['horafin'].':00';
	$mquir = $_POST['mquir'];
	$num = $_POST['num'];


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
												AND (HoraFin > '$fin'))OR((HoraFin > '$inicio') AND (HoraInicio <= '$fin')))
												AND numero <>  $num ");

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
/* --------- GUARDAR MODIFICACION ------------------*/
if(isset($_POST['GuardarDatosModi'])){
 
    $registro = $_POST['registro'];
        mysqli_query($conSanatorio,"UPDATE turnosquirofano SET Estado = 'MODIFICADO' WHERE Numero = $registro");
    
        $resnum = mysqli_query($conSanatorio, "SELECT MAX(Numero+1) AS Numero FROM TurnosQuirofano");

		while($consulta = mysqli_fetch_array($resnum)){
			$numeroTurno = $consulta['Numero']; // NUMERO DE TURNO
		} 
   
    $matricula = $_POST['matricula'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $valorDocumento = $_POST['valorDocumento'];
    $nomyapel = $_POST['nomyapel'];
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
    //------ ESTADO------------
    $mfec = $_POST['mfec'];
    $horaInicio = $mfec.' '.$_POST['horaInicio'].':00';
    $horafin = $mfec.' '.$_POST['horafin'].':00';
    $Codobrasocial = $_POST['Codobrasocial'];
        $menuObra = mysqli_query($conSanatorio, "SELECT LTRIM(RTRIM(CodigoObraSocial)) AS Codigo,
                        Descripcion,Deshabilitada FROM obrassociales 
                        WHERE web = '1' AND CodigoObraSocial = '$Codobrasocial'");
            while($row=mysqli_fetch_array($menuObra)) {
            $nom = $row['Descripcion'];
            }

    $NomObraSocial = $nom;
    $monitoreo = $_POST['monitoreo'];
    $rx = $_POST['rx'];
    $sangre = $_POST['sangre'];
    $mquir = $_POST['mquir'];
    $tel = $_POST['tel'];
    $anestesitaRadio = $_POST['anestesitaRadio'];
    
    
        date_default_timezone_set("America/Argentina/Tucuman");
        $DateAndTime = date('Y-m-d H:i:s', time()); 
    $fechaGrabacion = $DateAndTime; //fECHA DE GRABACIÓN
    $arcoC = $_POST['arcoC'];
    $ForceSana = $_POST['ForceSana'];
    $uti = $_POST['uti'];
    $laparo = $_POST['laparo'];
    $tarea = $_POST['tarea'];
    // Codobrasocial
    $tipCirugia = $_POST['tipCirugia']; // para internar
    $email = $_POST['email'];
    $ForcePro = $_POST['ForcePro'];
    $usuario = $_POST['usuario'];
                
    $CodPrac1 = $_POST['CodPrac1'];
    $CodPrac2 = $_POST['CodPrac2'];
    $CodPrac3 = $_POST['CodPrac3'];
    
    
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
                                                Email,                                                                                                                   
                                                ForceTriad_Propio,
                                                usuario,
                                                Marca)
						VALUES($numeroTurno,
                                $matricula,
                                $tipoDocumento,
                                $valorDocumento,
                                '$nomyapel',
                                '$estado',
                                '$mfec',
                                '$horaInicio',
                                '$horafin',
                                '$NomObraSocial',
                                '$monitoreo',
                                '$rx',
                                '$sangre',
                                0,
                                '$mquir',
                                '$tel',
                                '$anestesitaRadio',
                                '$fechaGrabacion',
                                '$arcoC',
                                '$ForceSana',
                                '$uti',
                                '$laparo',
                                '$tarea',
                                '$Codobrasocial',
                                $tipCirugia,
                                '$email',
                                '$ForcePro',
                                '$usuario',
                                    1)";
    
    // echo $consulta;
    $resultadoUno = mysqli_query($conSanatorio,$consulta);
		if (!$resultadoUno) {
			echo "Error en la inserción Modificacion: ".$conSanatorio->error;
		}
        if ($resultadoUno) {
			$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$CodPrac1')";
			$resultadoDos = mysqli_query($conSanatorio,$consulta);
			if ($resultadoDos){
                $valores['existe'] = "1";
				if (!empty($CodPrac2)){
					$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$CodPrac2')";
					$practicaDos = mysqli_query($conSanatorio,$consulta);
				}
				if (!empty($CodPrac3)){
					$consulta = "INSERT INTO turnosquirofanospracticas (numero,codigopractica) VALUES ('$numeroTurno','$CodPrac3')";
					$practicaTres = mysqli_query($conSanatorio,$consulta);
				}
            }else {
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


/*---- SUSPENDER ------*/
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