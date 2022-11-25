function EnviarMensaje(){
    var $destinatario = $("#name").val();
    var $mensaje = $("#mensaje").val();
    var $titulo = $("#titulo").val();
    var $iduser = $("#iduser").val();
    var $importancia = $("#importancia").val();
    console.log ($destinatario, $mensaje, $titulo, $iduser);
    var parametros = {
            "enviar" : "1",
            "nombre" : $destinatario,
            "mensaje" : $mensaje,
            "titulo" : $titulo,
            "iduser" : $iduser,
            "importancia" : $importancia
        }
    $.ajax({
		data:  parametros,
		dataType: 'json',
		url:   'codigo_php.php',
		type: 'POST',
		success:  function (valores){
        }
    });

}


function Mensaje(id){
	console.log (id)
	id = id
	
	var parametros = 
	{
		"buscarM": "1",
		"id" : id,
	};
  	$.ajax(
  	{ 
		data:  parametros,
		dataType: "json",
		url:   'codigo_php.php',
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

function Editar(matricula) {
	console.log(matricula);
	matricula = matricula;
	var parametros = 
	{
		"editarUser": "1",
		"matricula" : matricula,
	};
  	$.ajax(
  	{ 
		data:  parametros,
		dataType: "json",
		url:   'codigo_php.php',
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
				$('#matricula').val(valores.matricula);
				$('#nombre').val(valores.nombre);
				$('#email').val(valores.mail);
				$('#usuario').val(valores.usuario);				
				$vall = valores.tipo;
				$('#tipos').val($vall);
				
				$turno = valores.turno;
				$('#reporteTurno').val($turno);
				$creacion = valores.creacion;
				$('#reporteCreacion').val($creacion);
				$mensaje = valores.mensajes;				
				$('#mensajes').val($mensaje);
				$panel = valores.panel;
				$('#panel').val($panel);
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

function GuardarCambio(){
	var parametros = 
	{
		"editarGuardar": "2",
		"matricula" : $('#matricula').val(),
		"nombre" : $('#nombre').val(),
		"mail" : $('#email').val(),
		"usuario" : $('#usuario').val(),
		"tipo" : $('#tipos').val(),
		"turno" : $('#reporteTurno').val(),
		"creacion" : $('#reporteCreacion').val(),
		"mensajes" : $('#mensajes').val(),
		"panel" : $('#panel').val(),
	};
	console.log (parametros);
  	$.ajax(
  	{ 
		data:  parametros,
		dataType: "json",
		url:   'codigo_php.php',
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
  
			}
			else if (textStatus === 'error') {

				alert('Error al conectar con el servidor.');
			}
			else {
				
				alert('Uncaught Error: ' + jqXHR.responseText);
  
			}

		},

		complete: function(){},

		success:  function (valores)
		{
			if(valores.existe == "1") //A
			{
				Swal.fire({
					icon: 'success',
					title: 'Éxito',
					text: 'Se actualizó el usuario.'}),
					$('#exampleModal').modal('hide'),
					setTimeout(function(){
						$(location).attr('href','actUsuarios.php');
					}, 2000);
			}
			else
			{
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'No se actualizó el usuario.'})
				
			}
		}
	})
}


function validEmail(){
	email = $("#email1").val();
	var parametros = 
	{
	  "validEmail": "1",
	  "email" : email,
	};
	console.log(email)
	$.ajax(
	{
	  data:  parametros,
	  dataType: 'json',
	  url:   'codigo_php.php',
	  type:  'post',
	  beforeSend: function(){}, 
  
	  error: function()
	  {alert("Error");},
	  
	  complete: function(){},
  
	  success:  function (valores) 
	  {
		if(valores.existe=="1") //A
		{
		  Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'El email ya esta registrado'})
		}
		else
		{
		  
		}
  
	  }
	}) 	


}

function validContra () {
	pass1 = $("#pass").val();
	pass2 = $("#passw").val();
	console.log(pass1);
	console.log(pass2);
	if(pass1 == pass2){
		console.log("iguales");
	}
	else{
		Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'Las contraseñas no coinciden'})
	}
}

function validUser(){
	username = $("#user2").val();
	var parametros =
	{ "validUser" : "1",
	  "username" : username,
	};
	console.log(username)
	$.ajax(
	{

				  data:  parametros,
				  dataType: 'json',
				  url:   'codigo_php.php',
				  type:  'post',
				  beforeSend: function(){},
				  error: function()
				  {alert("Error");}
				  ,
				  complete: function(){},
				  success:  function (valores)
				  {
					if(valores.existe=="1") //A
					{
						Swal.fire({		
							icon: 'error',
							title: 'Oops...',
							text: 'El usuario ya esta registrado'})
					}
					else{

					}
				}
	})
}


function ConfirmarR() {
	profesional =$("#profesional").val();
	valorMatricula = $("#vMatricula").text();
	pass1 = $("#pass").val();
	pass2 = $("#passw").val();
	email = $("#email").val();
	username = $("#user").val();

	console.log(profesional);
	console.log(pass1);
	console.log(pass2);
	console.log(email);
	console.log(username);


	var parametros = {
		"registrarDoc": "1",
		"valorMatricula": valorMatricula,
		"profesional": profesional,
		"pass1": pass1,
		"pass2": pass2,
		"email": email,
		"username": username
		
	};

	console.log(parametros);
	$.ajax(
	{
		data:  parametros,
		dataType: 'json',
		url:   'codigo_php.php',
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
				Swal.fire('Cuenta Creada, Recibirás un email de Confirmación', '', 'success')
					setTimeout(function(){
					$(location).attr('href','actUsuarios.php');
					}, 1000);			
			}
			else{
				Swal.fire('Error en Crear La cuenta Comuníquese con el Administrador', '', 'error')
			}

		}
	})



	
}

function TipoSelect(){
	var tipo = $("#tiposCrea").val();
	console.log(tipo);
	if(tipo == 2){
		console.log(tipo);
		$('#selectProfesional').show();
		$('#mosNombre').hide();
	}
	else{
		$('#selectProfesional').hide();
		$('#mosNombre').show();
	}

}

function EditarQ (quirofano){
	var parametros =
	{ "quirofano": quirofano,
	  "editarQuirofano": "1",
	};
	console.log(parametros)
	$.ajax(
	{
				  data:  parametros,
				  dataType: 'json',
				  url:   'codigo_php.php',
				  type:  'post',
				  beforeSend: function(){},
				  error: function()
				  {alert("Error");}
				  ,
				  complete: function(){},
				  success:  function (valores)
				  {
					if(valores.existe=="1") //A
					{
						$("#tp").val(valores.tp);
						$hora1 = valores.horaI;
						$("#HoraI").val($hora1);
						$("#HoraF").val(valores.horaF);
						$("#intervalo").val(valores.intervalo);
						$("#entre").val(valores.entre);
						$("#esta").val(valores.esta);
						$("#q").val(valores.q);
					}
					else{
						console.log("error")
					}
				}
	})
}
function GuardarModi(){

	tp = $("#tp").val();
	horaI = $("#HoraI").val();
	horaF = $("#HoraF").val();
	inter = $("#intervalo").val();
	entre = $("#entre").val();
	esta = $("#esta").val();
	q = $("#q").val();
	var parametros =
	{ "tp": tp,
	  "horaI": horaI,
	  "horaF": horaF,
	  "intervalo": inter,
	  "entre": entre,
	  "esta": esta,
	  "q": q,
	  "modificarQuirofano": "1",
	};
	console.log(parametros)
	$.ajax(
	{
		data:  parametros,
		dataType: 'json',
		url:   'codigo_php.php',
		type:  'post',
		beforeSend: function(){},
		error: function()

		{alert("Error");},
		complete: function(){},
		success:  function (valores)
		{
			if(valores.existe=="1") //A
			{
				Swal.fire('Quirofano Modificado', '', 'success')
					setTimeout(function(){
					$(location).attr('href','actQuirofano.php');
					}, 1000);
			}
			else{
				Swal.fire('Error en Modificar', '', 'error')
			}
		}
	})


}