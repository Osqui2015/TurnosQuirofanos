let Ane= 'SI';
function anestesia(){
    if(document.getElementById("Anestesia").checked==true){        
        Ane = 'SI';
    }else{        
        Ane = 'NO';
    }
}
let Util= 'NO';
function Uti(){
    if(document.getElementById("Uti").checked==true){        
        Util = 'SI';
    }else{        
        Util = 'NO';
    }
}
let lapa= 'NO';
function laparo(){
    if(document.getElementById("laparo").checked==true){        
        lapa = 'SI';
    }else{        
        lapa = 'NO';
    }
}
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
let moni= 'NO';
function Monitoreo(){
    if(document.getElementById("Monitoreo").checked==true){        
        moni = 'SI';
    }else{        
        moni = 'NO';
    }
}
let inte= 'NO';
function Intensificador(){
    if(document.getElementById("Intensificador").checked==true){        
        inte = 'SI';
    }else{        
        inte = 'NO';
    }
}
let san= 'NO';
function Sangre(){
    if(document.getElementById("Sangre").checked==true){        
        san = 'SI';
    }else{        
        san = 'NO';
    }
}
let tInternación; // alert($('input:radio[name=tipocirugia]:checked').val());
/* Nuevo Turno */
function fechaTurno(){ 
    console.log('fechaTurno');
    mquir = $("#menuQuirofano").val();
    mfec = $("#fechaSelec").val();        
    var parametros = {
        "fbuscar": "1",
        "mquir" : mquir,
        "mfec" : mfec
    };
    console.log(parametros)
    $.ajax({
        data:  parametros,
        url:   'codigo_php_gerente.php',
        type: 'POST',
        success:function(r){
            HoraInicioTurno();
            $('#select2lista').html(r);                
        }
    })
} 
/* Hora InicioTurno */
function HoraInicioTurno(){
    console.log('Hora Inicio Turno')
    mquir = $("#menuQuirofano").val();
    mfec = $("#fechaSelec").val();
    codPrac1 = $("#codPrac1").val();

    if (mquir != '' && mfec != '' && codPrac1 != '') {
        if (mquir == 6){
            console.log ('soy igual a 6')
            $("#tiempomas").prop("disabled", true);
            var parametros = {
                "HorasTurnosCesaria": "1",
                "mquir" : mquir,
                "mfec" : mfec,
                "codPrac1" : codPrac1
            };
            console.log(parametros)
            $.ajax({
                data:  parametros,
                url: 'codigo_php_gerente.php',
                type: 'POST',
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
                success:function(r){                                       
                    $('#Hinicio').html(r)
                }
            })
        }else{
            console.log ('NO 6')
            $("#tiempomas").prop("disabled", false);
            var parametros = {
                "HorasTurnos": "1",
                "mquir" : mquir,
                "mfec" : mfec,
                "codPrac1" : codPrac1
            };
            console.log(parametros)
            $.ajax({
                data:  parametros,
                url: 'codigo_php_gerente.php',
                type: 'POST',
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
                success:function(r){                                       
                    $('#Hinicio').html(r)
                }
            })
        }
        

    }
    else{
        
    }
     
}
/* tiempo practica */
function tiempopractica(){
    console.log('tiempo practica')
    codPrac1 = $("#codPrac1").val();
    var parametros = {
        "tiempoPr" : 1,
        "pract" : codPrac1
    };
    console.log(parametros)
    $.ajax({
        data:  parametros,
        url: 'codigo_php_gerente.php',
        type: 'POST',
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
        success:function(r){                     
            $('#tp').html(r)
            HoraInicioTurno()
        }
    })

}
/* Hora FinTurno */
function HoraFinTurno(){
    console.log('Hora Fin Turno')
    codPrac1 = $("#codPrac1").val();
    tiempoInicio = $("#Hinicio").val();
    tiempomas = $("#tiempomas").val();
    mquir = $("#menuQuirofano").val();

    if (mquir == 6){
        var parametros = {
            "HoraFinTurnoCesaria": "1",
            "codPrac1" : codPrac1,
            "tiempoInicio" : tiempoInicio,
            "tiempomas" : tiempomas,
            "mquir" : mquir
        };            
    }else{
        var parametros = {
            "HoraFinTurno": "1",
            "codPrac1" : codPrac1,
            "tiempoInicio" : tiempoInicio,
            "tiempomas" : tiempomas,
            "mquir" : mquir
        };
    }
    console.log(parametros)
    $.ajax({		
        data:  parametros,
        dataType: 'json',
        url:   'codigo_php_gerente.php',
        type: 'POST',
        success:function(valore){
            if(valore.existe == "1"){
                $("#Hfin").val(valore.hf);
                $("#Hinicio").prop("disabled", false);
            }
        }
    })
}
/* Agregar Tiempo */
function AgregarTiempo(){
    console.log('Agregar Tiempo')
    HoraFinTurno();
}
/* CONFIRMAR TURNO */
function Confirmar(){
    console.log()
    if ($('#selectMenuQuirofano').text().trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Seleccione Menu de Quirofano.'})
    } else {
        if ($('#fechaSelec').val().trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Seleccione una Fecha.'})		
        }else {
            if ($('#Hinicio').val().trim() === '') {
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
                    if ($("#codPrac1").val().trim() === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe Seleccionar un CÓDIGO'})
                    }else {																		
                        confirmarDos();
                    }
                }
            }
        }
    }
}
function confirmarDos(){
    mquir = $("#menuQuirofano").val();
    mfec = $("#fechaSelec").val();
    tiempoInicio = $("#Hinicio").val(); // hora seleccionada
    tiempoFin = $("#Hfin").val();	// fin de hora seleccionada

    var parametros = {
        "chequearTurno": "1",
        "mfec" : mfec,
        "tiempoInicio" : tiempoInicio,
        "tiempoFin" : tiempoFin,
        "mquir" : mquir
    };
    console.log(parametros)
    $.ajax({
        data:  parametros,
        dataType: 'json',
        url:   'codigo_php_gerente.php',
        type: 'POST',
        success:  function (valores){
        if(valores.existe == "1") {
            ConfirmarDoc();
        }
        else{
            $("#cont").show();
            $("#element").hide();			
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'FECHA//HORA NO disponible.'
            })
        }
        }

    })
}
function ConfirmarDoc (){
    mquir = $("#menuQuirofano").val();
    mfec = $("#fechaSelec").val();
    tiempoInicio = $("#Hinicio").val(); // hora seleccionada
    tiempoFin = $("#Hfin").val();	// fin de hora seleccionada
    valorMatricula = $("#profesional").val() // valor matricula

    var parametros = {
        "chequearTurnoDoc": "1",
        "mfec" : mfec,
        "tiempoInicio" : tiempoInicio,
        "tiempoFin" : tiempoFin,
        "mquir" : mquir,
        "valorMatricula" : valorMatricula
    };
    console.log(parametros)
    $.ajax({
        data:  parametros,
        dataType: 'json',
        url:   'codigo_php_gerente.php',
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
                text: 'Usted ya tiene turno programado en otro Quirofano'
            })
        }
        }

    })
}

/* GUARDAR TURNO*/
function GuardarConfirmar(){
    mquir = $("#menuQuirofano").val();
    mfec = $("#fechaSelec").val();
    tiempoInicio = $("#Hinicio").val(); // hora seleccionada
    tiempoFin = $("#Hfin").val();	// fin de hora seleccionada

    var parametros = {
        "chequearTurno": "1",
        "mfec" : mfec,
        "tiempoInicio" : tiempoInicio,
        "tiempoFin" : tiempoFin,
        "mquir" : mquir
    };
    console.log(parametros)
    $.ajax({
        data:  parametros,
        dataType: 'json',
        url:   'codigo_php_gerente.php',
        type: 'POST',
        success:  function (valores){
            if(valores.existe == "1") {			
                veriDatoPaciente();
            }
            else{                    
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'FECHA//HORA NO disponible.'
                })
            }
        }
    })
}
function veriDatoPaciente(){
    valorDocumento = $("#doc").val(); // valor del documento
    nomyapel =$("#NomyApe").val();
    Codobrasocial =$("#selectObraSoc").val();
    if ( valorDocumento == '' || nomyapel == '' || Codobrasocial == ''){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Falta Datos Completar'
        })
    }else{
        GuardarTurnos()
    }
}
function GuardarTurnos(){
    $("#tiempomas").prop("disabled", true);
    valorUsuario = $("#vUserr").val(); // valor Usuario 
    valorMatricula = $("#profesional").val() // valor matricula

    numeroQuirofano = $("#menuQuirofano").val(); //numero de Quirofano
    fechas = $("#fechaSelec").val(); //Fecha
    horaInicio = $("#Hinicio").val(); // Hora Inicio        
    horaFin = $("#Hfin").val();	

    codigoPracticaU = $("#codPrac1").val()//Codigo Practica uno

    anestesitaRadio = Ane; //Anestesista SI/NO
    tarea = $("#tarea").val(); // tarea

    /// FORMULARIO DE PACIENTE
    tipoDocumento = $("#menuDoc").val(); //Tipo de documento
    valorDocumento = $("#doc").val(); // valor del documento
    nomyapel =$("#NomyApe").val();
    Codobrasocial =$("#menuObraSoc").val(); 
    email =$("#email").val(); //

    

    // codigo de practica
    codigoPracticaD = $("#codPrac2").val();
    codigoPracticaT =  $("#codPrac3").val();

    // ayudante
    matriculaAyuU = $('#matAyu1').val();
    matriculaAyuD = $('#matAyu2').val();
    matriculaAyuT = $('#matAyu3').val();
    // anestesista
    matriculaAneste = $('#anMat').val();
    
    monitoreo = moni;
    sangre = san;
    tipCirugia = $('input:radio[name=tipocirugia]:checked').val()
    rx = inte;

    tel = $('#tel').val();
    arcoC = inte;
    uti = Util;
    laparos = lapa;

    ForceSana = $('#selectforceSana').text();
    ForcePro = $('#selectforceProp').text();

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
        "laparo" : laparos,


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
        url:   'codigo_php_gerente.php',
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
                    $(location).attr('href','turnos.php');
                    }, 500);
                    
            }
            else{
                Swal.fire(
                    'Error',
                    'Datos No Guardados',
                    'error'
                    );
                        setTimeout(function(){
                    $(location).attr('href','nuevoTurnoPrueba.php');
                    }, 500);
            }

        }
    })
}

/* TRAER DATOS PACIENTE */
function buscar_datos(){
    doc = $("#doc").val();
    tip = $("#menuDoc").val();
    
    var parametros ={
    "buscar": "1",
    "doc" : doc,
    "tip" : tip
    };
    console.log(parametros)
    $.ajax({
    data:  parametros,
    dataType: 'json',
    url:   'codigo_php_gerente.php',
    type:  'post',
    beforeSend: function(){}, 

    error: function(){},
    
    complete: function(){},

    success:  function (valores){
        if(valores.existe=="1") //A
        {
        $("#NomyApe").val(valores.Nombre_Paciente);
        $("#tel").val(valores.Tel_Paciente);
        $("#email").val(valores.email);
        }else{
        
        }

    }})
}
/* codigo Obra social */
function camObra(){
    nombreObraSocial = $("#nombreObraSocial").val();
    var parametros = {
    "buscarCodigoObraSocial": "1",
    "nombreObraSocial" : nombreObraSocial
    };
    console.log(parametros)
    $.ajax({
    data:  parametros,
    dataType: 'json',
    url:   'codigo_php_Nuevo.php',
    type:  'post',
    beforeSend: function(){}, 

    error: function()
    {alert("Error");},
    
    complete: function(){},

    success:  function (valores) 
    {
        if(valores.existe=="1"){
        $("#codigoObraSocial").val(valores.Codigo);
        }else{
            
        }

    }
    }) 
}
