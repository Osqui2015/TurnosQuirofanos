// JQUERY
$(function() {
	
	var images = ['https://miro.medium.com/max/2400/1*G173aDBoFqhQcC9pqUKthg.jpeg', 'https://miro.medium.com/max/2400/1*G173aDBoFqhQcC9pqUKthg.jpeg'];

   //$('#container').append('<style>#container, .acceptContainer:before, #logoContainer:before {background: url(' + images[Math.floor(Math.random() * images.length)] + ') center fixed }');
	
	setTimeout(function() {
		$('.logoContainer').transition({scale: 1}, 700, 'ease');
		setTimeout(function() {
			$('.logoContainer .logo').addClass('loadIn');
			setTimeout(function() {
				$('.logoContainer .text').addClass('loadIn');
				setTimeout(function() {
					$('.acceptContainer').transition({height: '431.5px'});
					setTimeout(function() {
						$('.acceptContainer').addClass('loadIn');
						setTimeout(function() {
							$('.formDiv, form h1').addClass('loadIn');
						}, 400)
					}, 400)
				}, 400)
			}, 300)
		}, 300)
	}, 10)

});





function BuscarMedico(){
	mat = $("#mat").val();
	
	var parametros = 
	{
	  "buscarDoc": "1",
	  "mat" : mat,
	};
	console.log(mat)
	$.ajax(
	{
	  data:  parametros,
	  dataType: 'json',
	  url:   'codigosphp.php',
	  type:  'post',
	  beforeSend: function(){}, 
  
	  error: function()
	  {alert("Error");},
	  
	  complete: function(){},
  
	  success:  function (valores) 
	  {
		if(valores.existe=="1") //A
		{
		  $("#NomyApedoc").val(valores.Nombre);

		}
		else
		{
		  Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'No Se Encontró Profesional'})
		}
  
	  }
	}) 	
}


function validEmail(){
	email = $("#email").val();
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
	  url:   'codigosphp.php',
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



function validUser(){
	username = $("#user").val();
	var parametros =
	{ "validUser" : "1",
	  "username" : username,
	};
	console.log(username)
	$.ajax(
	{

				  data:  parametros,
				  dataType: 'json',
				  url:   'codigosphp.php',
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

function ValidarCorreo(){
	email = $("#email").val();
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
	  url:   'codigosphp.php',
	  type:  'post',
	  beforeSend: function(){}, 
  
	  error: function()
	  {alert("Error");},
	  
	  complete: function(){},
  
	  success:  function (valores) 
	  {
		if(valores.existe=="1") //A
		{	
			if (valores.tipo=="4") {
				document.getElementById('boton').disabled = false; // habilitar
				document.getElementById('matSi').style.display = 'block';
				document.getElementById('passw').disabled = false; // habilitar
				document.getElementById('pass').disabled = false; // habilitar
				document.getElementById('matNo').style.display = 'none';

			}else{
				document.getElementById('siC').style.display = 'block';			
				document.getElementById('noC').style.display = 'none';
				document.getElementById('mat').disabled = false; // habilitar
			}

		}
		else
		{
			document.getElementById('noC').style.display = 'block';
			document.getElementById('mat').disabled = true; // deshabilitar
			document.getElementById('siC').style.display = 'none';
			
		}
  
	  }
	}) 	
	
	
	
}

function ValidarMatricula(){
	mat = $("#mat").val();
	email = $("#email").val();
	var parametros = 
	{
	  "validMatricula": "1",
	  "mat" : mat,
	  "email" : email
	};
	console.log(mat)
	$.ajax(
	{ 
	  data:  parametros,
	  dataType: 'json',
	  url:   'codigosphp.php',
	  type:  'post',
	  beforeSend: function(){}, 
  
	  error: function()
	  {alert("Error");},
	  
	  complete: function(){},
  
	  success:  function (valores) 
	  {
		if(valores.existe=="1") //A
		{	
			document.getElementById('boton').disabled = false; // habilitar
			document.getElementById('matSi').style.display = 'block';
			document.getElementById('passw').disabled = false; // habilitar
			document.getElementById('pass').disabled = false; // habilitar
			document.getElementById('matNo').style.display = 'none';
		}
		else
		{
			document.getElementById('boton').disabled = true; // habilitar
			document.getElementById('passw').disabled = true; // habilitar
			document.getElementById('pass').disabled = true; // habilitar
			document.getElementById('matNo').style.display = 'block';
			document.getElementById('matSi').style.display = 'none';
			
		}
  
	  }
	}) 	
	
}

function CambioContra() {
	pass1 = $("#pass").val();
	pass2 = $("#passw").val();
	mat = $("#email").val();
	if(pass1 == pass2){
			var parametros =
			{
				"cambioContra" : "1",
				"pass" : pass1,
				"email" : email,
				"mat" : mat
			};
			$.ajax(
			{
				data:  parametros,
				dataType: 'json',
				url:   'codigosphp.php',
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
							  icon: 'success',
							  title: 'Exito',
							  text: 'Contraseña cambiada'});
							  setTimeout(function(){
								$(location).attr('href','login.php');
								}, 2000);
					}
					else
					{
						Swal.fire({
							  icon: 'error',
							  title: 'Oops...',
							  text: 'Error al cambiar contraseña'})
					}
				}
			})

	}
}

 
/*-------------- REGISTRO -------------------*/
function ValidarMatriculaRegistro(){
	matreg = $("#matreg").val();
	var parametros = 
	{
	  "ValidarMatriculaRegistro": "1",
	  "matreg" : matreg,
	  
	};
	console.log(matreg)
	$.ajax(
	{ 
	  data:  parametros,
	  dataType: 'json',
	  url:   'codigosphp.php',
	  type:  'post',
	  beforeSend: function(){}, 
  
	  error: function()
	  {alert("Error");},
	  
	  complete: function(){},
  
	  success:  function (valores) 
	  {		
		if(valores.existe=="1"){						
			document.getElementById('matSi').style.display = 'block';
			document.getElementById('matNo').style.display = 'none'; 
			$("#nya").val(valores.Nombre);
			$("#email").val(valores.email);
			$("#user").val(valores.NumeroDocumento);
		}else{
			
			document.getElementById('matNo').style.display = 'block';
			document.getElementById('matSi').style.display = 'none';
			
		}
  
	  }
	}) 	

} 
function validContra () {
	pass1 = $("#pass").val();
	pass2 = $("#passw").val();
	if(pass1 == pass2){
		document.getElementById('contrSi').style.display = 'block';
		document.getElementById('contrNo').style.display = 'none';
		document.getElementById('conf').style.display = 'block'
	}
	else{
		document.getElementById('contrSi').style.display = 'none';
		document.getElementById('contrNo').style.display = 'block';
		document.getElementById('conf').style.display = 'none'
		Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'Las contraseñas no coinciden'})
	}
}
function validContr () {
	pass1 = $("#pass").val();
	pass2 = $("#passw").val();
	if(pass1 == pass2){
		document.getElementById('contrSi').style.display = 'block';
		document.getElementById('contrNo').style.display = 'none';		
	}
	else{
		document.getElementById('contrSi').style.display = 'none';
		document.getElementById('contrNo').style.display = 'block';
		document.getElementById('conf').style.display = 'none'
	}
}
function ConfirmarR() {
	profesional =$("#nya").val();
	valorMatricula = $("#matreg").val();
	pass1 = $("#pass").val();
	pass2 = $("#passw").val();
	email = $("#email").val();
	username = $("#user").val();	

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
		url:   'codigosphp.php',
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
					$(location).attr('href','login.php');
					}, 1000);			
			}
			else{
				Swal.fire('Error en Crear La cuenta Comuníquese con el Administrador', '', 'error')
			}

		}
	})



	
}

function Recupero() {
	email = $("#mail").val();
	var parametros = {
		"recuperar": "1",
		"email": email,
		
	};
	console.log(parametros);
	$.ajax({
		data:  parametros,
		dataType: 'json',
		url:   'codigosphp.php',
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
				Swal.fire(
					'Recupero Exitoso!',
					'Vas a recibir un email para recuperar la contraseña',
					'success'
				);
				setTimeout(function(){
				  $(location).attr('href','login.php');
				  }, 1500);		
			}
			else{
				Swal.fire('Error Comuníquese con el Administrador', '', 'error')
			}

		}
	})
}