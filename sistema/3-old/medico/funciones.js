$(document).ready(function(){
	$('#ModalBucarPractica1').DataTable();
	$('#tablaBucarPractica33').DataTable();
	
	$('#tablaBucarAyudante1').DataTable();
	$('#tablaBucarAyudante2').DataTable();
	$('#tablaBucarAyudante3').DataTable();

	$('#tablaAnestesista').DataTable();

	$('#tablaInstrumentista').DataTable();

	$('#tablaCirculares').DataTable();

/*--- Tabla calendario*/
	$("#showT").on('click', function() {
		$("#tabla").show();
		return false;
	})
	$("#hideT").on('click', function() {
		
		return false;
	});	
/*---- */





});

/*-----------------*/

/*---- ----------------*/


	vm = $("#Matricula").val();
	$('#vMatricula').text(vm);

/*-- BOTON DE SEGUNDO FORM  -- */
	var element = document.getElementById("oldNews");
	if(element != null){
		element.style.display = "none";
	}
	function showHide(elementId) { 
		if ($('#selectMenuQuirofano').text().trim() === '') {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Seleccione Menu de Quirofano.'})
		} else {
			if ($('#selecFecha').text().trim() === '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Seleccione una Fecha.'})		
			}else {
				if ($('#selectHoraInicio').text().trim() === '') {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Debe seleccionar una hora'})			
				}else {
					if ($('#tarea').val().trim() === '') {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Debe escribir un DIAGNOSTICO'})				
					}else {
						if ($('#cod1Tiem').text().trim() === '') {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'Debe Seleccionar un CÓDIGO'})
						}else {
							var element = document.getElementById(elementId);
							if (element != null) {
								if(element.style.display != "none"){
									element.style.display = "none";
									$("#cont").show()
									
								}else{
									doc = $("#Hfin").val();
									$('#selectHoraFin').text(doc);
									
									$("#cont").hide()
									
									var valor = chequear1(valor);
								}
							}
						}
					}
				}
			}
		}
	}

function confirmarDos(){
	if ($('#selectMenuQuirofano').text().trim() === '') {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: 'Seleccione Menu de Quirofano.'})
	} else {
		if ($("#fechaSelec").val().trim() === '') {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Seleccione una Fecha.'})		
		}else {
			if ($('#selectHoraInicio').text().trim() === '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Debe seleccionar una hora'})			
			}else {
				if ($('#tarea').val().trim() === '') {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Debe escribir un DIAGNOSTICO'})				
				}else {
					if ($('#cod1Tiem').text().trim() === '') {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Debe Seleccionar un CÓDIGO'})
					}else {																		
						confirmarTres();
					}
				}
			}
		}
	}
}
						
/*-- chequea anestesista-- */
$(".micheckbox").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioAnestesista').text('SI');
		$('#selectRadioAnestesistaa').val('SI');
	} else {
		$('#selectRadioAnestesista').text('NO');
		$('#selectRadioAnestesistaa').val('NO');
	}
})

$(".monitoreo").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioMonitoreo').text('SI');
		$('#selectRadioMonitoreoo').val('SI');	
	} else {
		$('#selectRadioMonitoreo').text('NO');
		$('#selectRadioMonitoreoo').val('NO');	
	}
})
$(".rx").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioRX').text('SI');
		$('#selectRadioRXx').val('SI');
	} else {
		$('#selectRadioRX').text('NO');
		$('#selectRadioRXx').val('NO');
	}
})
$(".sangre").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioSangre').text('SI');
		$('#selectRadioSangree').val('SI');
	} else {
		$('#selectRadioSangre').text('NO');
		$('#selectRadioSangree').val('NO');
	}
})
$(".sangre").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioSangre').text('SI');
	} else {
		$('#selectRadioSangre').text('NO');
	}
})
$("input[name=tipocirugia]").change(function () {	 
	a = $(this).val();
	$('#selectRadiotipo_cirugia').text(a);
	$('#selectRadiotipo_cirugiaa').val(a);
});
/*---- */
$(".aro").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectArco').text('SI');
		$('#selectArcoo').val('SI');
	} else {
		$('#selectArco').text('NO');
		$('#selectArcoo').val('NO');
	}
})
$(".uti").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectUti').text('SI');
		$('#selectUtii').val('SI');
	} else {
		$('#selectUti').text('NO');
		$('#selectUtii').val('NO');
	}
})
/*---- */
$(".ForS").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectforceSana').text('SI');
		$("#ForP").prop('checked', false);
		$('#selectforceProp').text('NO');
	} else {
		$('#selectforceSana').text('NO');
	}
})
$(".ForP").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectforceProp').text('SI');
		$("#ForS").prop('checked', false);
		$('#selectforceSana').text('NO');
	} else {
		$('#selectforceProp').text('NO');
	}
})

$("input[name=FORCE]").change(function () {	 
	a = $(this).val();
	if (a == 0){
		$('#selectforceSana').text('SI');
		$('#selectforceSanaa').val('SI');
		$('#selectforcePropp').text('NO');
		$('#selectforcePropp').val('NO');
	}
	else{
		$('#selectforceSana').text('NO');
		$('#selectforceSanaa').val('NO');
		$('#selectforcePropp').text('SI');
		$('#selectforcePropp').val('SI');
	}
	
});


$(".intru").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectintru').text('SI');
	} else {
		$('#selectintru').text('NO');
	}
})


function Lapachar(){

	mfec = $("#fechaSelec").val(); // fecha seleccionada
	tiempoInicio = $("#selectHoraInicio").text(); // hora seleccionada
	tiempoFin = $("#selectHoraFin").text();	// fin de hora seleccionada
	mquir = $('#selectMenuQuirofano').text();
	
	var parametros = {
		"lap": "1",
		"mfec" : mfec,
		"tiempoInicio" : tiempoInicio,
		"tiempoFin" : tiempoFin,
		"mquir" : mquir
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:  function (valores){
		if(valores.existe == "1") {			
			$('#selectLaparo').text('SI');
			$('#selectLaparoo').val('SI');
		}
		else{
			console.log('h');
			$('.laparo').prop('checked', false);
			$('#selectLaparo').text('NO');
			$('#selectLaparoo').val('NO');		
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Equipo LAPAROSCÓPICA no disponible.'				
			  })
		}
		}
	})



}

function ArC(){
	
	mfec = $("#fechaSelec").val(); // fecha seleccionada
	tiempoInicio = $("#selectHoraInicio").text(); // hora seleccionada
	tiempoFin = $("#selectHoraFin").text();	// fin de hora seleccionada
	mquir = $('#selectMenuQuirofano').text();
	
	var parametros = {
		"arco": "1",
		"mfec" : mfec,
		"tiempoInicio" : tiempoInicio,
		"tiempoFin" : tiempoFin,
		"mquir" : mquir
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:  function (valores){
		if(valores.existe == "1") {			
			$('#selectArco').text('SI');
			$('#selectArcoo').val('SI');
		}
		else{
			console.log('h');
			$('.aro').prop('checked', false);
			$('#selectArco').text('NO');
			$('#selectArcoo').val('NO');		
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Equipo ARCO no disponible.'				
			  })
		}
		}
	})
}

function chequear1 (){
	valorUsuario = $("#vUserr").val(); // valor Usuario
	mfec = $("#fechaSelec").val(); // fehca seleccionada
	tiempoInicio = $("#selectHoraInicio").text(); // hora seleccionada
	tiempoFin = $("#selectHoraFin").text();	// fin de hora seleccionada
	mquir = $('#selectMenuQuirofano').text();
	var parametros = {
		"chequear": "1",
		"mfec" : mfec,
		"tiempoInicio" : tiempoInicio,
		"tiempoFin" : tiempoFin,
		"mquir" : mquir
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:  function (valores){
		if(valores.existe == "1") {			
			$("#element").show();
			$('#dosForm').show();
			$("#tabla").hide();
			element.style.display = "block";
		}
		else{
			$("#cont").show();
			$("#element").hide();			
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'FECHA//HORA no disponible.'				
			  })
		}
		}
	})
}

function practica2(datos){
	d=datos.split('||');
	$('#codPrac2').val(d[0]);
	$('#codDesc2').val(d[2]);
}
function practica3(datos){
	d=datos.split('||');
	$('#codPrac3').val(d[0]);
	$('#codDesc3').val(d[2]);
}
function practica1(practica1){
	d=practica1.split('||');
	$('#cod1Prac').val(d[0]);
	$('#cod1Desc').val(d[2]);

	$('#codPrac1').val(d[0]);
	$('#codDesc1').val(d[2]);

	$('#cod1Tiem').text(d[3]);
	
	$('#cod1Practica').text(d[0]);
	$('#cod1Practica').text(d[0]);
	$('#cod1Descripcion').text(d[2]);
	$('#Cpra').val(d[0]);
	

	console.log ('practica1');
	HoraInicioTurno();
	
}
function Ayudante1 (datos){
	d=datos.split('||');
	$('#matAyu1').val(d[0]);
	$('#nomAyu1').val(d[1]);

}
function Ayudante2 (datos){
	d=datos.split('||');
	$('#matAyu2').val(d[0]);
	$('#nomAyu2').val(d[1]);
}
function Ayudante3 (datos){
	d=datos.split('||');
	$('#matAyu3').val(d[0]);
	$('#nomAyu3').val(d[1]);
}
function Anestesista (datos){
	d=datos.split('||');
	$('#anMat').val(d[0]);
	$('#anAyud').val(d[1]);
}

function buscar_datos(){
  doc = $("#doc").val();
  tip = $("#selectMenuDoc").text();
  
  
  var parametros = 
  {
	"buscar": "1",
	"doc" : doc,
	"tip" : tip
  };
  $.ajax(
  {
	data:  parametros,
	dataType: 'json',
	url:   'codigos_php.php',
	type:  'post',
	beforeSend: function(){}, 

	error: function()
	{alert("Error");},
	
	complete: function(){},

	success:  function (valores) 
	{
	  if(valores.existe=="1") //A
	  {
		$("#NomyApe").val(valores.Nombre_Paciente);
		$("#tel").val(valores.Tel_Paciente);
		$("#email").val(valores.email);
	/*	$("#nombre").val(valores.Codigo_Obra_Social);
		$("#dir").val(valores.Obra_Social_Estado);
		$("#tel").val(valores.telefono); */

	  }
	  else
	  {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: 'No Se Encontro Paciente, crealo.'})
	  }

	}
  }) 
  

}

function fecha(){
	console.log('fecha onchage')
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	var parametros = {
		"fbuscar": "1",
		"mquir" : mquir,
		"mfec" : mfec
	};
	$.ajax({
		data:  parametros,
		url:   'codigos_php.php',
		type: 'POST',
		success:function(r){
			HoraInicioTurno()
			$('#select2lista').html(r);
		}
	})
}

function HoraInicio2(){
	tiempoPractica = $("#cod1Tiem").text();
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	console.log(mfec);

	var parametros = {
		"mHoras": "1",
		"mquir" : mquir,
		"mfec" : mfec,
		"tiempoPractica" : tiempoPractica
	};

	$.ajax({
		data:  parametros,
		url: 'codigos_php.php',
		type: 'POST',
		success:function(r){   			
			$('#Hinicio').html(r)
		}
	})
}


function HoraInicioo(practica1){
	
	d=practica1.split('||');
	console.log(d[3]);
	tiempoPractica = d[3] ;
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	console.log(mfec);

	var parametros = {
		"mHoras": "1",
		"mquir" : mquir,
		"mfec" : mfec,
		"tiempoPractica" : tiempoPractica
	};

	$.ajax({
		data:  parametros,
		url: 'codigos_php.php',
		type: 'POST',
		success:function(r){   			
			$('#Hinicio').html(r)
		}
	})
}

function HoraFin(){	
	
	tiempoPractica = $("#cod1Tiem").text();
	tiempoInicio = $("#selectHoraInicio").text();

	var parametros = {
		"horaFin": "1",
		"tiempoPractica" : tiempoPractica,
		"tiempoInicio" : tiempoInicio
	};
	$.ajax({		
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:function(valore){
			if(valore.existe == "1"){
				$("#Hfin").val(valore.hf);
				$("#Hinicio").prop("disabled", false);
			}
		}
	})
}
 
$('#Hinicio').on('change', function(){
	var valor = this.value;
	$('#selectHoraInicio').text(valor);
	HoraFin();
})

$('#tiempomas').on('change', function(){
	var valor = this.value;
	$('#selectTiempoMas').text(valor);
	console.log (valor)	
	AgregarTiempoM();
	agregarTiempo();
})

function agregarTiempo() {
	tiempoPractica = $("#cod1Tiem").text();
	tiempoInicio = $("#selectHoraInicio").text();
	tiempoMas = $("#selectTiempoMas").text();
	var parametros = {
		"horaMasFin": "1",
		"tiempoPractica" : tiempoPractica,
		"tiempoInicio" : tiempoInicio,
		"tiempoMas" : tiempoMas
	};
	console.log (parametros);
	$.ajax({	
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',

		beforeSend: function(){}, 

		error: function( jqXHR, textStatus, errorThrown ) {

			if (jqXHR.status === 0) {
  
			  alert('Not connect: Verify Network.');
  
			} else if (jqXHR.status == 404) {
  
			  alert('Requested page not found [404]');
  
			} else if (jqXHR.status == 500) {
  
			  alert('Internal Server Error [500].');
  
			} else if (textStatus === 'parsererror') {
  
			  alert('Requested JSON parse failed.');
  
			} else if (textStatus === 'timeout') {
  
			  alert('Time out error.');
  
			} else if (textStatus === 'abort') {
  
			  alert('Ajax request aborted.');
  
			} else {
  
			  alert('Uncaught Error: ' + jqXHR.responseText);
  
			}
  
		  },
		
		complete: function(){},
		
		success:  function (valores)
		{
			console.log('succes');
			if(valores.existe == "1"){
				
				$("#Hfin").val(valores.hf);

			}
		}
	})

}


function confirmar(){
	console.log('confirmar');
	valorUsuario = $("#vUserr").val(); // valor Usuario 
	valorMatricula = $("#vMatricula").text(); // valor matricula
	numeroQuirofano = $("#selectMenuQuirofano").text(); //numero de quirofano
	fechas = $("#fechaSelec").val(); //Fecha
	horaInicio = $("#selectHoraInicio").text(); // Hora Inicio
	horaFin = $("#selectHoraFin").text(); // Hora Fin
	codigoPracticaU = $("#cod1Practica").text(); //Codigo Practica uno
	codigoDescripcionU = $("#cod1Descripcion").text(); //Codigo Descripcion uno
	anestesitaRadio = $('#selectRadioAnestesistaa').val(); //Anestesista SI/no
	tarea = $("#tarea").val(); // tarea

	/// FORMULARIO DE PACIENTE
	tipoDocumento = $("#selectMenuDoc").text(); //Tipo de documento
	valorDocumento = $("#doc").val(); // valor del documento
	nomyapel =$("#NomyApe").val();
	obrasocial =$("#selectObraSoc").val();



	// codigo de practica
	codigoPracticaD = $('#codPrac2').val();
	codigoPracticaT =  $('#codPrac3').val();
	// ayudante
	matriculaAyuU = $('#matAyu1').val();
	matriculaAyuD = $('#matAyu2').val();
	matriculaAyuT = $('#matAyu3').val();
	// anestesista
	matriculaAneste = $('#anMat').val();
	
	monitoreo = $("#selectRadioMonitoreoo").val();
	sangre = $('#selectRadioSangree').val();
	tipCirugia = $('#selectRadiotipo_cirugiaa').val();
	rx = $('#selectRadioRXx').val();

	tel = $('#tel').val();
	arcoC = $('#selectArcoo').val();
	uti = $('#selectUtii').val();
	laparo = $('#selectLaparoo').val();

	ForceSana = $('#selectforceSanaa').val();
	ForcePro = $('#selectforcePropp').val();

	intruPro =  $('#selectintru').text();

	InsumoNH = $('#InsumoNH').val();
 
	var parametros = {
		"guardar": '1',
		"valorMatricula" : valorMatricula,
		"valorUsuario" : valorUsuario,
		"numeroQuirofano" : numeroQuirofano,
		"fechas" : fechas,
		"horaInicio" : horaInicio,
		"horaFin" : horaFin,
		
		"codigoPracticaU" : codigoPracticaU,
		"codigoDescripcionU" : codigoDescripcionU,
		"anestesitaRadio" : anestesitaRadio,
		"tarea" : tarea,


		"monitoreo" : monitoreo,
		"sangre" : sangre,
		"tipCirugia" : tipCirugia,
		"rx" : rx,
		"tel" : tel,
		"arcoC" : arcoC,
		"uti" : uti,
		"laparo" : laparo,


		"tipoDocumento" : tipoDocumento,
		"valorDocumento" : valorDocumento,
		"nomyapel" : nomyapel,
		"obrasocial" : obrasocial,

		'ForceSana' : ForceSana,
		'ForcePro' : ForcePro,



		"codigoPracticaD" : codigoPracticaD,
		"codigoPracticaT" : codigoPracticaT,



		"intruPro" : intruPro,
		"InsumoNH" : InsumoNH
	};

	console.log(parametros);

	$.ajax({		
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		error: function() {
			alert('There was some error performing the AJAX call!');
		},

		error: function( jqXHR, textStatus, errorThrown ) {

			if (jqXHR.status === 0) {
  
			  alert('Not connect: Verify Network.');
  
			} else if (jqXHR.status == 404) {
  
			  alert('Requested page not found [404]');
  
			} else if (jqXHR.status == 500) {
  
			  alert('Internal Server Error [500].');
  
			} else if (textStatus === 'parsererror') {
  
			  alert('Requested JSON parse failed.');
  
			} else if (textStatus === 'timeout') {
  
			  alert('Time out error.');
  
			} else if (textStatus === 'abort') {
  
			  alert('Ajax request aborted.');
  
			} else {
  
			  alert('Uncaught Error: ' + jqXHR.responseText);
  
			}
  
		  },
		
		complete: function(){},

		success:  function (valores){

			if(valores.existe == "1") {
				Swal.fire(
					'Turno Confirmado',
					'datos guardado correctamente',
					'success'
				  );
				  	setTimeout(function(){
					$(location).attr('href','nuevoT.php');
					}, 2000);
				  
			}
			else{
				alert("Error")
			}
		}
	})
}

function Modificar(numero){
	console.log('Modificar')
	console.log(numero);
	var $n = numero;

	Swal.fire({
		title: 'Quieres modificar este Turno????',
		text: "",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Modificar!'
	}).then((result) => {
		if (result.isConfirmed) {			
			setTimeout(function(){
			$(location).attr('href','modificarD.php'+'?num='+$n);
			}, 50);
		}
	})
}

function ModificarError(numero){
	console.log('Modificar')
	console.log(numero);
	var $n = numero;

	Swal.fire({
		title: 'Quieres modificar este Turno????',
		text: "¡No podrás revertir esto!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Modificar!'
	}).then((result) => {
		if (result.isConfirmed) {			
			setTimeout(function(){
			$(location).attr('href','error404.php'+'?num='+$n);
			}, 50);
		}
	})
}

function Suspenderr(numero){
	console.log('Suspender')
	console.log(numero)


	Swal.fire({
        title: "Motivo de Suspecion.",
		icon: 'question',
        input: "text",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
		inputValidator: nombre => {
            // Si el valor es válido, debes regresar undefined. Si no, una cadena
            if (!nombre) {
                return "Por favor escribe el motivo de Suspensión.!";
            } else {
                return undefined;
            }
        }	
    })
    .then(resultado => {
        if (resultado.value) {
            let nombre = resultado.value;
			TurnoSuspender(numero, nombre);			
        };
		setTimeout(function(){
			$(location).attr('href','misTurnos.php');
			}, 50);
    }); 
}

function TurnoSuspender(numero, nombre){
	console.log ('turno suspender')
	console.log (numero)
	console.log (nombre)
	numero = numero;
	motivo = nombre;
	var parametros = {
		"suspender": "1",
		"numero" : numero,
		"motivo" : motivo
	};
	$.ajax(
	{
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type:  'post',
		beforeSend: function(){}, 

		error: function( jqXHR, textStatus, errorThrown ) {

			if (jqXHR.status === 0) {
  
			  alert('Not connect: Verify Network.');
  
			} else if (jqXHR.status == 404) {
  
			  alert('Requested page not found [404]');
  
			} else if (jqXHR.status == 500) {
  
			  alert('Internal Server Error [500].');
  
			} else if (textStatus === 'parsererror') {
  
			  alert('Requested JSON parse failed.');
  
			} else if (textStatus === 'timeout') {
  
			  alert('Time out error.');
  
			} else if (textStatus === 'abort') {
  
			  alert('Ajax request aborted.');
  
			} else {
  
			  alert('Uncaught Error: ' + jqXHR.responseText);
  
			}
  
		  },
		
		complete: function(){},

		success:  function (valores) 
		{
		if(valores.existe=="1"){ //A		
			Swal.fire('Suspensión Correcta!', '', 'success')			
		}
		else{
			Swal.fire('Suspensión Incorrecta!', '', 'error')
		}

		}
	}) 

}

function Mensaje(id, matricula){
	console.log (id)
	console.log (matricula)
	id = id
	matricula = matricula
	
	var parametros = 
	{
		"buscarM": "1",
		"id" : id,
		"matricula" : matricula
	};
  	$.ajax(
  	{ 
		data:  parametros,
		dataType: "json",
		url:   'codigos_php.php',
		type:  'post',
		beforeSend: function(){}, 

		error: function( jqXHR, textStatus, errorThrown ) {

			if (jqXHR.status === 0) {
  
			  alert('Not connect: Verify Network.');
  
			} else if (jqXHR.status == 404) {
  
			  alert('Requested page not found [404]');
  
			} else if (jqXHR.status == 500) {
  
			  alert('Internal Server Error [500].');
  
			} else if (textStatus === 'parsererror') {
  
			  alert('Requested JSON parse failed.');
  
			} else if (textStatus === 'timeout') {
  
			  alert('Time out error.');
  
			} else if (textStatus === 'abort') {
  
			  alert('Ajax request aborted.');
  
			} else {
  
			  alert('Uncaught Error: ' + jqXHR.responseText);
  
			}
  
		  },
		
		complete: function(){},
		
		success:  function (valores) 
		{
			console.log ('entre')
			if(valores.existe=="1") //A
			{
				$("#Fecha").val(valores.Fecha);
				$("#Remitente").val(valores.Usuario);
				$("#Mensaje").val(valores.Mensaje);
			}
			else
			{
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'No Se encontró el mensaje.'})
			}

		}
	}) 


}

function confirmarM(){
	console.log('confirmar modificar');

	NumeroMod = $('#nNumero').val();


	valorMatricula = $("#vMatricula").text(); // valor matricula
	numeroQuirofano = $("#menuQuirofano").val(); //numero de quirofano
	fechas = $("#fechaSelec").val(); //Fecha

	horaInicio = $("#Hinicio").val(); // Hora Inicio
	horaFin = $("#Hfin").val(); // Hora Fin

	codigoPracticaU = $("#cod1Prac").val(); //Codigo Practica uno
	codigoDescripcionU = $("#cod1Desc").val(); //Codigo Descripcion uno


	anestesitaRadio = $('#selectRadioAnestesistaa').val(); //Anestesista SI/no

	tarea = $("#tarea").val(); // tarea

	/// FORMULARIO DE PACIENTE
	tipoDocumento = $("#menuDoc").val(); //Tipo de documento

	valorDocumento = $("#doc").val(); // valor del documento

	nomyapel =$("#NomyApe").val();
	obrasocial =$("#menuObraSoc").val();
	email =$("#email").val();



	// codigo de practica
	codigoPracticaD = $('#codPrac2').val();
	codigoPracticaT =  $('#codPrac3').val();
	/* ayudante
	matriculaAyuU = $('#matAyu1').val();
	matriculaAyuD = $('#matAyu2').val();
	matriculaAyuT = $('#matAyu3').val();
	// anestesista
	matriculaAneste = $('#anMat').val(); */
	
	monitoreo = $("#selectRadioMonitoreoo").val();
	sangre = $('#selectRadioSangree').val();
	tipCirugia = $('#selectRadiotipo_cirugiaa').val();
	rx = $('#selectRadioRXx').val();

	tel = $('#tel').val();
	arcoC = $('#selectArcoo').val();
	uti = $('#selectUtii').val();
	laparo = $('#selectLaparoo').val();

	ForceSana = $('#selectforceSanaa').val();
	ForcePro = $('#selectforcePropp').val();

	intruPro =  $('#selectintru').text();
	InsumoNH = $('#InsumoNH').val();
	var parametros = {
		"guardarModi": '1',
		"valorMatricula" : valorMatricula,
		"numeroQuirofano" : numeroQuirofano,
		"fechas" : fechas,
		"horaInicio" : horaInicio,
		"horaFinn" : horaFin,
		"codigoPracticaU" : codigoPracticaU,
		"codigoDescripcionU" : codigoDescripcionU,
		"anestesitaRadio" : anestesitaRadio,
		"tarea" : tarea,


		"monitoreo" : monitoreo,
		"sangre" : sangre,
		"tipCirugia" : tipCirugia,
		"rx" : rx,
		"tel" : tel,
		"arcoC" : arcoC,
		"uti" : uti,
		"laparo" : laparo,


		"tipoDocumento" : tipoDocumento,
		"valorDocumento" : valorDocumento,
		"nomyapel" : nomyapel,
		"email" : email,
		"obrasocial" : obrasocial,

		'ForceSana' : ForceSana,
		'ForcePro' : ForcePro,



		"codigoPracticaD" : codigoPracticaD,
		"codigoPracticaT" : codigoPracticaT,

		/* "matriculaAyuU" : matriculaAyuU,
		"matriculaAyuD" : matriculaAyuD,
		"matriculaAyuT" : matriculaAyuT,

		"matriculaAneste" : matriculaAneste, */
		"NumeroMod" : NumeroMod
	};

	$.ajax({		
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		error: function() {
			alert('There was some error performing the AJAX call!');
		},

		error: function( jqXHR, textStatus, errorThrown ) {

			if (jqXHR.status === 0) {
  
			  alert('Not connect: Verify Network.');
  
			} else if (jqXHR.status == 404) {
  
			  alert('Requested page not found [404]');
  
			} else if (jqXHR.status == 500) {
  
			  alert('Internal Server Error [500].');
  
			} else if (textStatus === 'parsererror') {
  
			  alert('Requested JSON parse failed.');
  
			} else if (textStatus === 'timeout') {
  
			  alert('Time out error.');
  
			} else if (textStatus === 'abort') {
  
			  alert('Ajax request aborted.');
  
			} else {
  
			  alert('Uncaught Error: ' + jqXHR.responseText);
  
			}
  
		  },
		
		complete: function(){},

		success:  function (valores){

			if(valores.existe == "1") {
				Swal.fire(
					'Turno Modificado',
					'datos guardado correctamente',
					'success'
				  );
				  	setTimeout(function(){
					$(location).attr('href','turnoQuirofano.php');
					}, 2000);
			}
			else{
				alert("Error")
			}
		}
	})
} 

function confirmarTres(){
	
	valorUsuario = $("#vUserr").val(); // valor Usuario 
	valorMatricula = $("#vMatricula").text(); // valor matricula
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	tiempoInicio = $("#selectHoraInicio").text(); // hora seleccionada
	tiempoFin = $("#Hfin").val();	// fin de hora seleccionada
	mquir = $('#selectMenuQuirofano').text();

	codigoPracticaU = $("#cod1Prac").val(); //Codigo Practica uno
	codigoDescripcionU = $("#cod1Desc").val(); //Codigo Descripcion uno
	codigoPracticaD = $("#cod2Prac").val(); //Codigo Practica uno
	codigoDescripcionD = $("#cod2Desc").val(); //Codigo Descripcion uno
	codigoPracticaT = $("#cod3Prac").val(); //Codigo Practica uno
	codigoDescripcionT = $("#cod3Desc").val(); //Codigo Descripcion uno

	anestesitaRadio = $("#anestesitaRadio").val(); // Anestesista
	arcoC = $('#selectArcoo').val();
	uti = $('#selectUtii').val();
	laparo = $('#selectLaparoo').val();

	ForceSana = $('#selectforceSanaa').val();
	ForcePro = $('#selectforcePropp').val();

	monitoreo = $("#selectRadioMonitoreoo").val();
	sangre = $('#selectRadioSangree').val();
	rx = $('#selectRadioRXx').val();

	tipCirugia = $('#selectRadiotipo_cirugiaa').val();

	tarea = $("#tarea").val(); // Tarea

	console.log('entre');

	

	var parametros = {
		"chequear": "1",
		"mfec" : mfec,
		"tiempoInicio" : tiempoInicio,
		"tiempoFin" : tiempoFin,
		"mquir" : mquir
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:  function (valores){
		if(valores.existe == "1") {			
			$("#element").show();
			$('#dosForm').show();
			$("#tabla").hide();
			$('.collapse').collapse('show');
		}
		else{
			$("#cont").show();
			$("#element").hide();			
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'FECHA//HORA no disponible.'				
			  })
		}
		}

	})
}

function confirmarCuatros(){
	
	
	valorUsuario = $("#vUserr").val(); // valor Usuario 
	valorMatricula = $("#vMatricula").text(); // valor matricula
	numeroQuirofano = $("#selectMenuQuirofano").text(); //numero de quirofano
	fechas = $("#fechaSelec").val(); //Fecha
	horaInicio = $("#selectHoraInicio").text(); // Hora Inicio
	horaFinn = $("#selectHoraFin").text(); // Hora Fin
	horaFin = $("#Hfin").val();	
	codigoPracticaU = $("#cod1Practica").text(); //Codigo Practica uno
	codigoDescripcionU = $("#cod1Descripcion").text(); //Codigo Descripcion uno
	anestesitaRadio = $('#selectRadioAnestesistaa').val(); //Anestesista SI/no
	tarea = $("#tarea").val(); // tarea

	/// FORMULARIO DE PACIENTE
	tipoDocumento = $("#selectMenuDoc").text(); //Tipo de documento
	valorDocumento = $("#doc").val(); // valor del documento
	nomyapel =$("#NomyApe").val();
	Codobrasocial =$("#selectObraSoc").val();
	email =$("#email").val(); //

 

	// codigo de practica
	codigoPracticaD = $('#codPrac2').val();
	codigoPracticaT =  $('#codPrac3').val();
	// ayudante
	matriculaAyuU = $('#matAyu1').val();
	matriculaAyuD = $('#matAyu2').val();
	matriculaAyuT = $('#matAyu3').val();
	// anestesista
	matriculaAneste = $('#anMat').val();
	
	monitoreo = $("#selectRadioMonitoreoo").val();
	sangre = $('#selectRadioSangree').val();
	tipCirugia = $('#selectRadiotipo_cirugiaa').val();
	rx = $('#selectRadioRXx').val();

	tel = $('#tel').val();
	arcoC = $('#selectArcoo').val();
	uti = $('#selectUtii').val();
	laparo = $('#selectLaparoo').val();

	ForceSana = $('#selectforceSanaa').val();
	ForcePro = $('#selectforcePropp').val();

	intruPro =  $('#selectintru').text();
 
	InsumoNH = $('#InsumoNH').val();
 
	var parametros = {
		"guardar": '1',
		"valorMatricula" : valorMatricula,
		"valorUsuario" : valorUsuario,
		"numeroQuirofano" : numeroQuirofano,
		"fechas" : fechas,
		"horaInicio" : horaInicio,
		"horaFinn" : horaFin,
		"codigoPracticaU" : codigoPracticaU,
		"codigoDescripcionU" : codigoDescripcionU,

		"codigoPracticaD" : codigoPracticaD,
		
		"codigoPracticaT" : codigoPracticaT,
		
		"anestesitaRadio" : anestesitaRadio,
		"tarea" : tarea,


		"monitoreo" : monitoreo,
		"sangre" : sangre,
		"tipCirugia" : tipCirugia,
		"rx" : rx,
		"tel" : tel,
		"arcoC" : arcoC,
		"uti" : uti,
		"laparo" : laparo,


		"tipoDocumento" : tipoDocumento,
		"valorDocumento" : valorDocumento,
		"nomyapel" : nomyapel,
		"Codobrasocial" : Codobrasocial,
		"email" : email,

		'ForceSana' : ForceSana,
		'ForcePro' : ForcePro,
		

		
		"intruPro" : intruPro
		
	};

	console.log(parametros);

	$.ajax({		
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		error: function() {
			alert('There was some error performing the AJAX call!');
		},

		error: function( jqXHR, textStatus, errorThrown ) {

			if (jqXHR.status === 0) {
  
			  alert('Not connect: Verify Network.');
  
			} else if (jqXHR.status == 404) {
  
			  alert('Requested page not found [404]');
  
			} else if (jqXHR.status == 500) {
  
			  alert('Internal Server Error [500].');
  
			} else if (textStatus === 'parsererror') {
  
			  alert('Requested JSON parse failed.');
  
			} else if (textStatus === 'timeout') {
  
			  alert('Time out error.');
  
			} else if (textStatus === 'abort') {
  
			  alert('Ajax request aborted.');
  
			} else {
  
			  alert('Uncaught Error: ' + jqXHR.responseText);
  
			}
  
		  },
		
		complete: function(){},

		success:  function (valores){

			if(valores.existe == "1") {
				Swal.fire(
					'Turno Confirmado',
					'datos guardado correctamente',
					'success'
				  );
				  	setTimeout(function(){
					$(location).attr('href','nuevoT.php');
					}, 2000);
				  
			}
			else{
				alert("Error")
			}
		}
	})
}


function suspenderCon (){
	
	codSuspen = $("#selectSuspen").text();
	numSuspen = $("#idSuspender").text();
	console.log(codSuspen);
	console.log(numSuspen);

	if (codSuspen == 0){
			Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: 'Erro seleccione un motivo de suspensión',
			
		  })

	}else{
		var parametros = {
			"suspender": "1",
			"numero" : numSuspen,
			"motivo" : codSuspen
		};
		$.ajax(
		{
			data:  parametros,
			dataType: 'json',
			url:   'codigos_php.php',
			type:  'post',
			beforeSend: function(){}, 
	
			error: function( jqXHR, textStatus, errorThrown ) {
	
				if (jqXHR.status === 0) {
	  
				  alert('Not connect: Verify Network.');
	  
				} else if (jqXHR.status == 404) {
	  
				  alert('Requested page not found [404]');
	  
				} else if (jqXHR.status == 500) {
	  
				  alert('Internal Server Error [500].');
	  
				} else if (textStatus === 'parsererror') {
	  
				  alert('Requested JSON parse failed.');
	  
				} else if (textStatus === 'timeout') {
	  
				  alert('Time out error.');
	  
				} else if (textStatus === 'abort') {
	  
				  alert('Ajax request aborted.');
	  
				} else {
	  
				  alert('Uncaught Error: ' + jqXHR.responseText);
	  
				}
	  
			  },
			
			complete: function(){},
	
			success:  function (valores) 
			{
				if(valores.existe=="1"){ //A		
					Swal.fire('Suspensión Correcta!', '', 'success')
						setTimeout(function(){
						$(location).attr('href','turnoQuirofano.php');
						}, 1000);			
				}
				else{
					Swal.fire('Suspensión Incorrecta!', '', 'error')
				}
	
			}
		})
		
	}


	

	
}
function Sus(numero){	
	$("#idSuspender").text(numero);
}

function CancelarMod(){
	setTimeout(function(){
	$(location).attr('href','index.php');
	}, 1000);

}

function chequear3 (){
	valorUsuario = $("#vUserr").val(); // valor Usuario 
	valorMatricula = $("#vMatricula").text(); // valor matricula
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	tiempoInicio = $("#selectHoraInicio").text(); // hora seleccionada
	tiempoFin = $("#Hfin").val();	// fin de hora seleccionada
	mquir = $('#selectMenuQuirofano').text();

	codigoPracticaU = $("#cod1Prac").val(); //Codigo Practica uno
	codigoDescripcionU = $("#cod1Desc").val(); //Codigo Descripcion uno
	codigoPracticaD = $("#cod2Prac").val(); //Codigo Practica uno
	codigoDescripcionD = $("#cod2Desc").val(); //Codigo Descripcion uno
	codigoPracticaT = $("#cod3Prac").val(); //Codigo Practica uno
	codigoDescripcionT = $("#cod3Desc").val(); //Codigo Descripcion uno

	anestesitaRadio = $("#anestesitaRadio").val(); // Anestesista
	arcoC = $('#selectArcoo').val();
	uti = $('#selectUtii').val();
	laparo = $('#selectLaparoo').val();

	ForceSana = $('#selectforceSana').text();
	ForcePro = $('#selectforceProp').text();

	monitoreo = $("#selectRadioMonitoreoo").val();
	sangre = $('#selectRadioSangree').val();
	rx = $('#selectRadioRXx').val();

	tipCirugia = $('#selectRadiotipo_cirugiaa').val();

	tarea = $("#tarea").val(); // Tarea

	console.log('entre');

	

	var parametros = {
		"chequear": "1",
		"mfec" : mfec,
		"tiempoInicio" : tiempoInicio,
		"tiempoFin" : tiempoFin,
		"mquir" : mquir
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:  function (valores){
		if(valores.existe == "1") {
			confirmarCuatros();

		}
		else{
			$("#cont").show();
			$("#element").hide();			
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'FECHA//HORA no disponible.'				
			  })
			  setTimeout(function(){
				$(location).attr('href','nuevoT.php');
				}, 2000);
		}
		}

	})
}



function chequear2(){
	if ($('#NomyApe').val().trim() === '') {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: 'Debe escribir un Nombre'})
	} else {
		if ($('#doc').val().trim() === '') {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Debe escribir un Documento'})		
		}else {
			if ($('#tel').val().trim() === '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Debe escribir un telefono'})			
			}else {
				if ($('#menuObraSoc').val().trim() === '') {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Debe seleccionar una obra social'})				
				}else {																						
					chequear3();					
				}
			}
		}
	}
}


function FechaOnchange(){
	console.log('FechaOnchange');
}


/* MODIFICACIÓN */
function FechaModificar(){
	console.log('Fecha Modificar');
	fecha = $('#fechaSelec').val();
	numquir = $('#menuQuirofano').val();

	var parametros = {
		"mfec": fecha,
		"mquir": numquir,
		"fbuscar": '1'
	}
	$.ajax({
		data:  parametros,
		url:   'codigos_php.php',
		type: 'POST',
		success:function(r){
			$('#select2lista').html(r);
			HoraInicioM();
		}
	})

}

function QuirModi(){
	FechaModificar();
}

function HoraInicioM(){
	
	console.log('HoraInicioModificar');
	num = $("#NumReg").val();
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	codPrac1 = $("#Cpra").val();

	console.log(parametros)
	var parametros = {
		"mHorasTurnos": "1",
		"mquir" : mquir,
		"mfec" : mfec,
		"numero" : num,
		"codPrac1" : codPrac1
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		url: 'codigos_php.php',
		type: 'POST',
		success:function(r){   
			console.log('entre')
			document.getElementById("Hinicio").style.display = "block";
			$('#Hinicio').html(r)
			document.getElementById("element").style.display = "none";
		}
	})
}

function HoraFinM(valor){

	numreg = $("#codPrac1").val();
	tiempoMas = $("#tiempomas").val();
	valInicioModi = valor;
	ValInicio = $("#selectHoraInicioAc").val();


if (valInicioModi != '' ) {
console.log('no Vacio');
val = valInicioModi;
}else{
console.log('vacio');
val = ValInicio; 
}

	var parametros = {
		"horaFinM": "1",
		"codPra" : numreg,
		"tiempoInicio" : val,
		"tiempoMas" : tiempoMas
	};
	console.log(parametros);
	$.ajax({		
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:function(valore){
			if(valore.existe == "1"){
				$("#HfinModi").val(valore.hf);
				$("#selectHoraFinModi").text(valore.hf);
			}
		}
	})
}

function AgregarTiempoM(){

	numreg = $("#codPrac1").val();
	tiempoMas = $("#tiempomas").val();
	HfinModi = $("#HfinModi").val();
	numreg = $("#codPrac1").val();

	
	hi1 = $("#Hinicio").val(); // Hora Inicio nuevo
	h2 = $("#selectHoraInicioAc").val(); // Hora Inicio actual

	if (hi1 != '' ) {
		horaInicio = hi1;
	}else {
		horaInicio = h2;
	}

	if (tiempoMas != '' ) {
		tiempoFin = HfinModi;
	}else {
		tiempoFin = 0;
	}


	var parametros = {
		"horaFinMas": "1",
		"codPra" : numreg,
		"tiempoInicio" : horaInicio,
		"tiempoFin": HfinModi,
		"numreg" : numreg,
		"tiempoMas" : tiempoMas
	};
	console.log(parametros);
	$.ajax({		
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:function(valore){
			if(valore.existe == "1"){
				$("#HfinModi").val(valore.hf);
				$("#selectHoraFinModi").text(valore.hf);
			}
		}
	})
}




function chequeaTurno (){
	console.log('chequear1')
	num = $("#NumReg").val();
	mfec = $("#fechaSelec").val(); // fecha seleccionada

	hi1 = $("#selectHoraInicio").text(); // Hora Inicio
	h2 = $("#disableTimeRangesExample").val(); // Hora In
	if (hi1.length > 0) {
		tiempoInicio = hi1;
	}else {
		tiempoInicio = h2;
	}
	tiempoFin = $("#selectHoraFinModi").text(); // Hora Fin
	mquir = $("#menuQuirofano").val(); //numero de quirofano	
	var parametros = {
		"chequearModi": "1",
		"mfec" : mfec,
		"tiempoInicio" : tiempoInicio,
		"tiempoFin" : tiempoFin,
		"mquir" : mquir,
		"num" : num
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		success:  function (valores){
		if(valores.existe == "1") {			
			GuardarDatosModificar();
		}
		else{
			$("#cont").show();
			$("#element").hide();			
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'FECHA//HORA no disponible.'				
			  })
		}
		}
	})
}

function GuardarDatosModificar(){
	console.log('Guarda Datos Modificar Turnos');
	num = $("#NumReg").val();
	valorUsuario = $("#vUserr").val(); // valor Usuario
	valorMatricula = $("#vMatricula").val(); // valor matricula	
	numeroQuirofano = $("#menuQuirofano").val(); //numero de quirofano	
	fechas = $("#fechaSelec").val(); //Fecha

	// codigo de practica
	codigoPracticaU = $("#codPrac1").val();
	codigoPracticaD = $('#codPrac2').val();
	codigoPracticaT =  $('#codPrac3').val();
	
	hi1 = $("#Hinicio").val(); // Hora Inicio nuevo
console.log('hora Nuevo');
console.log(hi1);
	h2 = $("#selectHoraInicioAc").val(); // Hora Inicio actual
console.log('hora actual');
console.log(h2);

	if (hi1 != '' ) {
		horaInicio = hi1;
	}else {
		horaInicio = h2;
	}
console.log('hora inicio');
console.log(horaInicio);
 
	horaFin = $("#selectHoraFinModi").text(); // Hora Fin

	anestesitaRadio = $('#selectRadioAnestesistaa').val(); //Anestesista SI/no
	arcoC = $('#selectArcoo').val(); //Arco SI/no
	uti = $('#selectUtii').val(); //UTI SI/no
	laparo = $('#selectLaparoo').val(); //Laparo SI/no

	ForceSana = $('#selectforceSana').text();
	ForcePro = $('#selectforceProp').text();

	monitoreo = $("#selectRadioMonitoreoo").val();
	sangre = $('#selectRadioSangree').val();
	tipCirugia = $('#selectRadiotipo_cirugiaa').val();
	rx = $('#selectRadioRXx').val();

	tarea = $("#tarea").val(); // tarea

	/// FORMULARIO DE PACIENTE
	tipoDocumento = $("#menuDoc").val(); //Tipo de documento
	valorDocumento = $("#doc").val(); // valor del documento
	nomyapel = $("#NomyApe").val();	
	Codobrasocial = $("#selectObraSoc").val();
	tel = $('#tel').val();



	// codigo de practica
	codigoPracticaD = $('#codPrac2').val();
	codigoPracticaT =  $('#codPrac3').val();
	// ayudante
	matriculaAyuU = $('#matAyu1').val();
	matriculaAyuD = $('#matAyu2').val();
	matriculaAyuT = $('#matAyu3').val();
	// anestesista
	matriculaAneste = $('#anMat').val();
	
	

	InsumoNH = $('#InsumoNH').val();

	var parametros = {
		"guardarTurnoModificar": '1',
		"num" : num,
		"valorUsuario": valorUsuario,
		"valorMatricula": valorMatricula,
		"numeroQuirofano": numeroQuirofano,
		"fechas": fechas,
		"codigoPracticaU": codigoPracticaU,
		"codigoPracticaD": codigoPracticaD,
		"codigoPracticaT": codigoPracticaT,
		"horaInicio": horaInicio,
		"horaFinn": horaFin,
		"anestesitaRadio": anestesitaRadio,
		"arcoC": arcoC,
		"uti": uti,
		"laparo": laparo,
		"ForceSana": ForceSana,
		"ForcePro": ForcePro,
		"monitoreo": monitoreo,
		"sangre": sangre,
		"tipCirugia": tipCirugia,
		"rx": rx,
		"tarea": tarea,
		"tipoDocumento": tipoDocumento,
		"valorDocumento": valorDocumento ,
		"nomyapel": nomyapel,
		
		"Codobrasocial": Codobrasocial,
		"tel": tel		
	};

	console.log(parametros);

	$.ajax({		
		data:  parametros,
		dataType: 'json',
		url:   'codigos_php.php',
		type: 'POST',
		error: function() {
			alert('There was some error performing the AJAX call!');
		},

		error: function( jqXHR, textStatus, errorThrown ) {

			if (jqXHR.status === 0) {

			alert('Not connect: Verify Network.');

			} else if (jqXHR.status == 404) {

			alert('Requested page not found [404]');

			} else if (jqXHR.status == 500) {

			alert('Internal Server Error [500].');

			} else if (textStatus === 'parsererror') {

			alert('Requested JSON parse failed.');

			} else if (textStatus === 'timeout') {

			alert('Time out error.');

			} else if (textStatus === 'abort') {

			alert('Ajax request aborted.');

			} else {

			alert('Uncaught Error: ' + jqXHR.responseText);

			}

		},
		 
		complete: function(){},

		success:  function (valores){

			if(valores.existe == "1") {
				Swal.fire(
					'Turno Confirmado',
					'datos Modificado correctamente',
					'success'
				);
					 setTimeout(function(){
					$(location).attr('href','misTurnos.php');
					}, 1000);
				
			}
			else{
				alert("Error")
			}
		}
	})	
}



/* Creacion de Turno */
function fechaTurno(){
	console.log('fecha Turno')
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	var parametros = {
		"fbuscar": "1",
		"mquir" : mquir,
		"mfec" : mfec
	};
	$.ajax({
		data:  parametros,
		url:   'codigos_php.php',
		type: 'POST',
		success:function(r){
			HoraInicioTurno()
			$('#select2lista').html(r);
		}
	})
}
function QuirofanoCambio(){
	console.log('cambio quirofano Turno')
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	var parametros = {
		"fbuscar": "1",
		"mquir" : mquir,
		"mfec" : mfec
	};
	$.ajax({
		data:  parametros,
		url:   'codigos_php.php',
		type: 'POST',
		success:function(r){
			HoraInicioTurno()
			$('#select2lista').html(r);
		}
	})

}

function HoraInicioTurno(){
	console.log('HoraInicioTurno');
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	codPrac1 = $("#cod1Practica").text();

	console.log(parametros)
	var parametros = {
		"HorasTurnos": "1",
		"mquir" : mquir,
		"mfec" : mfec,
		"codPrac1" : codPrac1
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		url: 'codigos_php.php',
		type: 'POST',
		success:function(r){   
			$('#Hinicio').html(r)
		}
	})

}
