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
		$('#selectRadioAnestesista').text('Si');
		$('#selectRadioAnestesistaa').val('Si');
	} else {
		$('#selectRadioAnestesista').text('No');
		$('#selectRadioAnestesistaa').val('No');
	}
})

$(".monitoreo").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioMonitoreo').text('Si');
		$('#selectRadioMonitoreoo').val('Si');	
	} else {
		$('#selectRadioMonitoreo').text('No');
		$('#selectRadioMonitoreoo').val('No');	
	}
})
$(".rx").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioRX').text('Si');
		$('#selectRadioRXx').val('Si');
	} else {
		$('#selectRadioRX').text('No');
		$('#selectRadioRXx').val('No');
	}
})
$(".sangre").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioSangre').text('Si');
		$('#selectRadioSangree').val('Si');
	} else {
		$('#selectRadioSangre').text('No');
		$('#selectRadioSangree').val('No');
	}
})
$(".sangre").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectRadioSangre').text('Si');
	} else {
		$('#selectRadioSangre').text('No');
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
		$('#selectArco').text('Si');
		$('#selectArcoo').val('Si');
	} else {
		$('#selectArco').text('No');
		$('#selectArcoo').val('No');
	}
})
$(".uti").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectUti').text('Si');
		$('#selectUtii').val('Si');
	} else {
		$('#selectUti').text('No');
		$('#selectUtii').val('No');
	}
})
/*---- */
$(".forceSana").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectforceSana').text('Si');
	} else {
		$('#selectforceSana').text('No');
	}
})
$(".forceProp").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectforceProp').text('Si');
	} else {
		$('#selectforceProp').text('No');
	}
})

$("input[name=FORCE]").change(function () {	 
	a = $(this).val();
	if (a == 0){
		$('#selectforceSana').text('Si');
		$('#selectforceSanaa').val('Si');
		$('#selectforcePropp').text('No');
		$('#selectforcePropp').val('No');
	}
	else{
		$('#selectforceSana').text('No');
		$('#selectforceSanaa').val('No');
		$('#selectforcePropp').text('Si');
		$('#selectforcePropp').val('Si');
	}
	
});

$(".intru").on('change', function() {
	if( $(this).is(':checked') ) {
		$('#selectintru').text('Si');
	} else {
		$('#selectintru').text('No');
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
			$('#selectLaparo').text('Si');
			$('#selectLaparoo').val('Si');
		}
		else{
			console.log('h');
			$('.laparo').prop('checked', false);
			$('#selectLaparo').text('No');
			$('#selectLaparoo').val('No');		
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
			$('#selectArco').text('Si');
			$('#selectArcoo').val('Si');
		}
		else{
			console.log('h');
			$('.aro').prop('checked', false);
			$('#selectArco').text('No');
			$('#selectArcoo').val('No');		
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
	console.log('chequear1')
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
	$('#cod1Descripcion').text(d[2]);	
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
			$('#select2lista').html(r);
			HoraInicioo();
		}
	})
}
function HoraInicioo(){
	mquir = $("#menuQuirofano").val();
	mfec = $("#fechaSelec").val();
	console.log(parametros)
	var parametros = {
		"mHoras": "1",
		"mquir" : mquir,
		"mfec" : mfec
	};
	console.log(parametros)
	$.ajax({
		data:  parametros,
		url: 'codigos_php.php',
		type: 'POST',
		success:function(r){   
			console.log('entre')
			$('#Hinicio').html(r)
		}
	})
}

function HoraFin(){	
	console.log('HoraFin');
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
				$("#selectHoraFin").text(valore.hf);
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
				$("#selectHoraFin").text(valores.hf);

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
	tiempoFin = $("#selectHoraFin").text(); // Hora Fin
	codigoPracticaU = $("#cod1Practica").text(); //Codigo Practica uno
	codigoDescripcionU = $("#cod1Descripcion").text(); //Codigo Descripcion uno
	anestesitaRadio = $('#selectRadioAnestesistaa').val(); //Anestesista SI/no
	tarea = $("#tarea").val(); // tarea

	/// FORMULARIO DE PACIENTE
	tipoDocumento = $("#selectMenuDoc").text(); //Tipo de documento
	valorDocumento = $("#doc").val(); // valor del documento
	nomyapel =$("#NomyApe").val();
	obrasocial =$("#selectObraSoc").val();
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

	alert(monitoreo);
 
	var parametros = {
		"guardar": '1',
		"valorMatricula" : valorMatricula,
		"valorUsuario" : valorUsuario,
		"numeroQuirofano" : numeroQuirofano,
		"fechas" : fechas,
		"horaInicio" : horaInicio,
		"tiempoFin" : tiempoFin,
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
		"valorDoc" : valorDocumento,
		"nomyapel" : nomyapel,
		"obrasocial" : obrasocial,
		"email" : email,

		'ForceSana' : ForceSana,
		'ForcePro' : ForcePro,



		"codigoPracticaD" : codigoPracticaD,
		"codigoPracticaT" : codigoPracticaT,

		"matriculaAyuU" : matriculaAyuU,
		"matriculaAyuD" : matriculaAyuD,
		"matriculaAyuT" : matriculaAyuT,

		"matriculaAneste" : matriculaAneste,
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
					$(location).attr('href','nuevoTurno.php');
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
		text: "¡No podrás revertir esto!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Modificar!'
	}).then((result) => {
		if (result.isConfirmed) {			
			setTimeout(function(){
			$(location).attr('href','modi.php'+'?num='+$n);
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
			$(location).attr('href','turnoQuirofano.php');
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
		
	};
  	$.ajax(
  	{
		data:  {"buscarM": "1",
				"id" : id,
				"matricula" : matricula},
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
	console.log('confirmar');

	NumeroMod = $('#nNumero').val();


	valorMatricula = $("#vMatricula").val(); // valor matricula
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



	// codigo de practica
	codigoPracticaD = $('#codPrac2').val();
	codigoPracticaT =  $('#codPrac3').val();

	
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
		"obrasocial" : obrasocial,

		'ForceSana' : ForceSana,
		'ForcePro' : ForcePro,



		"codigoPracticaD" : codigoPracticaD,
		"codigoPracticaT" : codigoPracticaT,


		"NumeroMod" : NumeroMod
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
					'Turno Modificado',
					'datos guardado correctamente',
					'success'
				  );
				  	setTimeout(function(){
					$(location).attr('href','index.php');
					}, 2000);
			}
			else{
				alert("Error")
			}
		}
	})
}





function confirmarCuatros(){
	console.log('confirmarcuatro')
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
	Codobrasocial =$("#selectObraSoc").val();



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
		"obrasocial" : obrasocial,
		"Codobrasocial" : Codobrasocial,

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
						$(location).attr('href','index.php');
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







function GuardarDatos(){
	console.log('GuardarDatos Confirma Campo Vacíos');
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
						confirmarDisponibilidad();
					}
				}
			}
		}
	}
}

function confirmarDisponibilidad(){
	console.log('verifica hora y fecha disponible')
	tiempoInicio = $("#selectHoraInicio").text(); // hora seleccionada
	tiempoFin = $("#Hfin").val();	// fin de hora seleccionada
	mquir = $('#selectMenuQuirofano').text();
	mfec = $("#fechaSelec").val();
	
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
			verificadatosPaciente();
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

function verificadatosPaciente(){
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
					GuardaTurno();					
				}
			}
		}
	}
}

function GuardaTurno(){
	console.log('Guarda Datos Turnos');

	valorUsuario = $("#vUserr").val(); // valor Usuario
	valorMatricula = $("#vMatricula").text(); // valor matricula	
	numeroQuirofano = $("#selectMenuQuirofano").text(); //numero de quirofano	
	fechas = $("#fechaSelec").val(); //Fecha

	// codigo de practica
	codigoPracticaU = $("#cod1Practica").text();
	codigoPracticaD = $('#codPrac2').val();
	codigoPracticaT =  $('#codPrac3').val();
	
	horaInicio = $("#selectHoraInicio").text(); // Hora Inicio
	horaFin = $("#selectHoraFin").text(); // Hora Fin

	anestesitaRadio = $('#selectRadioAnestesistaa').val(); //Anestesista SI/no
	arcoC = $('#selectArcoo').val(); //Arco SI/no
	uti = $('#selectUtii').val(); //UTI SI/no
	laparo = $('#selectLaparoo').val(); //Laparo SI/no

	ForceSana = $('#selectforceSanaa').val();
	ForcePro = $('#selectforcePropp').val();

	monitoreo = $("#selectRadioMonitoreoo").val();
	sangre = $('#selectRadioSangree').val();
	tipCirugia = $('#selectRadiotipo_cirugiaa').val();
	rx = $('#selectRadioRXx').val();

	tarea = $("#tarea").val(); // tarea

	/// FORMULARIO DE PACIENTE
	tipoDocumento = $("#selectMenuDoc").text(); //Tipo de documento
	valorDocumento = $("#doc").val(); // valor del documento
	nomyapel = $("#NomyApe").val();
	obrasocial = $("#selectObraSoc").val();
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
	
	intruPro =  $('#selectintru').text();

	InsumoNH = $('#InsumoNH').val();
 
	var parametros = {
		"guardarTurno": '1',
		"valorUsuario": valorUsuario,
		"valorMatricula": valorMatricula,
		"numeroQuirofano": numeroQuirofano,
		"fechas": fechas,
		"codigoPracticaU": codigoPracticaU,
		"codigoPracticaD": codigoPracticaD,
		"codigoPracticaT": codigoPracticaT,
		"horaInicio": horaInicio,
		"horaFin": horaFin,
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
		"valorDocumento ": valorDocumento ,
		"nomyapel": nomyapel,
		"obrasocial": obrasocial,
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