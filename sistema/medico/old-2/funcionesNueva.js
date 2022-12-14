/* Nuevo Turno */
    function fechaTurno(){        
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
            url:   'codigo_php_Nuevo.php',
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
        codPrac1 = $("#codigoPractica1").val();

        if (mquir != '' && mfec != '' && codPrac1 != '') {
            var parametros = {
                "HorasTurnos": "1",
                "mquir" : mquir,
                "mfec" : mfec,
                "codPrac1" : codPrac1
            };
            console.log(parametros)
            $.ajax({
                data:  parametros,
                url: 'codigo_php_Nuevo.php',
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
        else{
            
        }
         
    }
/* tiempo practica */
    function tiempopractica(){
        codPrac1 = $("#codigoPractica1").val();
        var parametros = {
            "tiempoPr" : 1,
            "pract" : codPrac1
        };
        console.log(parametros)
        $.ajax({
            data:  parametros,
            url: 'codigo_php_Nuevo.php',
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
        codPrac1 = $("#codigoPractica1").val();
        tiempoInicio = $("#Hinicio").val();
        tiempomas = $("#tiempomas").val();

        var parametros = {
            "HoraFinTurno": "1",
            "codPrac1" : codPrac1,
            "tiempoInicio" : tiempoInicio,
            "tiempomas" : tiempomas
        };
        console.log(parametros)
        $.ajax({		
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
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
                        if ($('#codigoPractica1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Debe Seleccionar un C??DIGO'})
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
            url:   'codigo_php_Nuevo.php',
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
                    text: 'FECHA//HORA no disponible.'				
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
        valorMatricula = $("#vMatricula").val(); // valor matricula

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
            url:   'codigo_php_Nuevo.php',
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
        url:   'codigo_php_Nuevo.php',
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
            url:   'codigo_php_Nuevo.php',
            type: 'POST',
            success:  function (valores){
                if(valores.existe == "1") {			
                    veriDatoPaciente();
                }
                else{                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'FECHA//HORA no disponible.'
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
        valorUsuario = $("#vUserr").val(); // valor Usuario 
        valorMatricula = $("#vMatricula").val(); // valor matricula

        numeroQuirofano = $("#selectMenuQuirofano").text(); //numero de quirofano
        fechas = $("#fechaSelec").val(); //Fecha
        horaInicio = $("#Hinicio").val(); // Hora Inicio        
        horaFin = $("#Hfin").val();	

        codigoPracticaU = $("#codigoPractica1").val(); //Codigo Practica uno

        anestesitaRadio = $('#selectRadioAnestesistaa').val(); //Anestesista SI/no
        tarea = $("#tarea").val(); // tarea

        /// FORMULARIO DE PACIENTE
        tipoDocumento = $("#menuDoc").val(); //Tipo de documento
        valorDocumento = $("#doc").val(); // valor del documento
        nomyapel =$("#NomyApe").val();
        Codobrasocial =$("#codigoObraSocial").val();
        email =$("#email").val(); //

        

        // codigo de practica
        codigoPracticaD = $('#codigoPractica2').val();
        codigoPracticaT =  $('#codigoPractica3').val();

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
            url:   'codigo_php_Nuevo.php',
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
                        $(location).attr('href','NuevoTurnoPrueba.php');
                        }, 500);
                        
                }
                else{
                    alert("Error")
                }
            }
        })
    }
/*------- MODIFICAR -------*/
/* Hora InicioTurno */
    function HoraInicioTurnoModificar(){
        mquir = $("#menuQuirofano").val();
        mfec = $("#fechaSelec").val();
        codPrac1 = $("#codPrac1").val();
        num = $("#NumReg").val();

        if (mquir != '' && mfec != '' && codPrac1 != '') {
            var parametros = {
                "HorasTurnosModificar": "1",
                "mquir" : mquir,
                "mfec" : mfec,
                "numero" : num,
                "codPrac1" : codPrac1
            };
            console.log(parametros)
            $.ajax({
                data:  parametros,
                url: 'codigo_php_Nuevo.php',
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
        else{
            
        }    
    }
    /* hora fin turno m */
    function HoraFinTurnoM(){
        console.log('Hora Fin Turno M')
        codPrac1 = $("#codPrac1").val();
        tiempoInicio = $("#Hinicio").val();
        tiempomas = $("#tiempomas").val();

        var parametros = {
            "HoraFinTurno": "1",
            "codPrac1" : codPrac1,
            "tiempoInicio" : tiempoInicio,
            "tiempomas" : tiempomas
        };
        console.log(parametros)
        $.ajax({		
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
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
    function AgregarTiempoModi(){
        numreg = $("#codPrac1").val();
                
        h1 = $("#Hinicio").val(); // Hora Inicio nuevo
        h2 = $("#hiactual").val(); // Hora Inicio actual
        if (h1 != '' ) {
            horaInicio = h1;
        }else {
            horaInicio = h2;
        }
    
        hf1 = $("#Hfin").val();
        hf2 = $("#hfactual").val();
        if (hf1 != '' ) {
            horafin = hf1;
        }else {
            horafin = hf2;
        }

        tiempoMas = $("#tiempomas").val();
        if (tiempoMas != '' ) {
            tiempoFin = tiempoMas;
        }else {
            tiempoFin = 0;
        }

        var parametros = {
            "horaFinMas": "1",
            "codPra" : numreg,
            "tiempoInicio" : horaInicio,
            "tiempoFin": horafin,
            "numreg" : numreg,
            "tiempoMas" : tiempoMas
        };
        console.log(parametros);
        $.ajax({		
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
            type: 'POST',
            success:function(valore){                
                if(valore.existe == "1"){
                    $("#Hfin").val(valore.hf);
                    $("#selectHoraFinModi").text(valore.hf);
                }
            }
        })
    }

    function confirmarM (){
        num = $("#NumReg").val();
        mquir = $("#menuQuirofano").val();
        mfec = $("#fechaSelec").val();
        h1 = $("#Hinicio").val(); // Hora Inicio nuevo
        h2 = $("#hiactual").val(); // Hora Inicio actual
        if (h1 != '' ) {
            horaInicio = h1;
        }else {
            horaInicio = h2;
        }
    
        hf1 = $("#Hfin").val();
        hf2 = $("#hfactual").val();
        if (hf1 != '' ) {
            horafin = hf1;
        }else {
            horafin = hf2;
        }
        var parametros = {
            "confirmarModi": "1",
            "mquir" : mquir,
            "mfec" : mfec,
            "horaInicio" : horaInicio,
            "horafin" : horafin,
            "num" : num
        }
        console.log(parametros);
        $.ajax({		
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
            type: 'POST',
            success:function(valore){                
                if(valore.existe == "1") {			
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

    function PreGuardarDatos (){
        num = $("#NumReg").val();
        mquir = $("#menuQuirofano").val();
        mfec = $("#fechaSelec").val();
        h1 = $("#Hinicio").val(); // Hora Inicio nuevo
        h2 = $("#hiactual").val(); // Hora Inicio actual
        if (h1 != '' ) {
            horaInicio = h1;
        }else {
            horaInicio = h2;
        }
    
        hf1 = $("#Hfin").val();
        hf2 = $("#hfactual").val();
        if (hf1 != '' ) {
            horafin = hf1;
        }else {
            horafin = hf2;
        }
        var parametros = {
            "confirmarModi": "1",
            "mquir" : mquir,
            "mfec" : mfec,
            "horaInicio" : horaInicio,
            "horafin" : horafin,
            "num" : num
        }
        console.log(parametros);
        $.ajax({		
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
            type: 'POST',
            success:function(valore){                
                if(valore.existe == "1") {			
                    GuardarDatos ();
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
    function GuardarDatos (){
        num = $("#NumReg").val();
        mquir = $("#menuQuirofano").val();
        mfec = $("#fechaSelec").val();
        h1 = $("#Hinicio").val(); // Hora Inicio nuevo
        h2 = $("#hiactual").val(); // Hora Inicio actual
        if (h1 != '' ) {
            horaInicio = h1;
        }else {
            horaInicio = h2;
        }    
        hf1 = $("#Hfin").val();
        hf2 = $("#hfactual").val();
        if (hf1 != '' ) {
            horafin = hf1;
        }else {
            horafin = hf2;
        }
        CodPrac1 = $("#codPrac1").val(); // Codigo Practica
        CodPrac2 = $("#codPrac2").val(); // Codigo Practica
        CodPrac3 = $("#codPrac3").val(); // Codigo Practica
        tarea = $("#tarea").val() // tarea        
        anestesitaRadio = $('#selectRadioAnestesistaa').val(); //Anestesista SI/no
        monitoreo = $("#selectRadioMonitoreoo").val();
        sangre = $('#selectRadioSangree').val();
        tipCirugia = $('#selectRadiotipo_cirugiaa').val();
        rx = $('#selectRadioRXx').val();
        arcoC = $('#selectArcoo').val();
        uti = $('#selectUtii').val();
        laparo = $('#selectLaparoo').val();
        ForceSana = $('#selectforceSana').text();
        ForcePro = $('#selectforceProp').text();
 
         /// FORMULARIO DE PACIENTE
         tipoDocumento = $("#menuDoc").val(); //Tipo de documento
         valorDocumento = $("#doc").val(); // valor del documento
         nomyapel =$("#NomyApe").val();
         Codobrasocial =$("#menuObraSoc").val();
         email =$("#email").val(); //
         tel = $('#tel').val(); 

         /// user
         matricula = $("#vMatricula").val();
         usuario = $("#vUserr").val();
         registro = $("#NumReg").val();

         var parametros = {
            "GuardarDatosModi": "1",
            "mquir" : mquir,
            "mfec" : mfec,
            "horaInicio" : horaInicio,
            "horafin" : horafin,
            "num" : num,
            "CodPrac1" : CodPrac1,
            "CodPrac2" : CodPrac2,
            "CodPrac3" : CodPrac3,
            "tarea" : tarea,
            "anestesitaRadio" : anestesitaRadio,
            "monitoreo" : monitoreo,
            "sangre" : sangre,
            "tipCirugia" : tipCirugia,
            "rx" : rx,
            "arcoC" : arcoC,
            "uti" : uti,
            "laparo" : laparo,
            "ForceSana" : ForceSana,
            "ForcePro" : ForcePro,
            "tipoDocumento" : tipoDocumento,
            "valorDocumento" : valorDocumento,
            "nomyapel" : nomyapel,
            "Codobrasocial" : Codobrasocial,
            "email" : email,
            "tel" : tel,
            "matricula" : matricula,
            "usuario" : usuario,
            "registro" : registro
         }
         console.log(parametros);
         
        $.ajax({		
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
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
                        $(location).attr('href','misTurnos.php');
                        }, 500);
                        
                }
                else{
                    alert("Error")
                }
            }
        })
    }

/* Practicas */
    function practicaUno(){        
        HoraInicioTurno();
    }
    function cambiarPractica1(){ 
        nombrePractica1 = $("#nombrePractica1").val();
        var parametros ={
            "buscarPractica": "1",
            "nombrePractica1" : nombrePractica1
            };
            console.log(parametros)
            $.ajax({
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
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
        
            success:  function (valores){
                console.log(valores)
                $("#codigoPractica1").val(valores.Codigo);
                tiempopractica()
            }})
    }
    function cambiarPractica2(){ 
        nombrePractica1 = $("#nombrePractica2").val();
        var parametros ={
            "buscarPractica": "1",
            "nombrePractica1" : nombrePractica1
            };
            console.log(parametros)
            $.ajax({
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
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
        
            success:  function (valores){
                console.log(valores)
                $("#codigoPractica2").val(valores.Codigo);
                
            }})
    }
    function cambiarPractica3(){ 
        nombrePractica1 = $("#nombrePractica3").val();
        var parametros ={
            "buscarPractica": "1",
            "nombrePractica1" : nombrePractica1
            };
            console.log(parametros)
            $.ajax({
            data:  parametros,
            dataType: 'json',
            url:   'codigo_php_Nuevo.php',
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
        
            success:  function (valores){
                console.log(valores)
                $("#codigoPractica3").val(valores.Codigo);
                
            }})
    }
 

/* PERFIL */
/* CAMBIO DE CONTRASE??A */
function validarContra (){
    actual = $("#actual").val();
    matricula = $("#matricula").val();
    var parametros = {
        "actual" : actual,
        "matricula" : matricula,
        "veriActual" : 1
    }
    console.log(parametros);    
    $.ajax(
    {
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
        if(valores.existe=="1") //A
        {
            document.getElementById('actSi').style.display = 'block';
            document.getElementById('actNo').style.display = 'none';
            document.getElementById('con1').disabled = false; // habilitar
            document.getElementById('con2').disabled = false; // habilitar
        }
        else
        {
            document.getElementById('actNo').style.display = 'block';
            document.getElementById('actSi').style.display = 'none';
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Contrase??a invalida'})
        }
    }
    })

}
function validarIgual(){
    con1 = $("#con1").val();
    con2 = $("#con2").val();
    if (con1 == con2){
        document.getElementById('contrNo').style.display = 'none';
        document.getElementById('contrSi').style.display = 'block';
    }
    else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Contrase??as no coinciden'})
        document.getElementById('contrNo').style.display = 'block';
        document.getElementById('contrSi').style.display = 'none'
    }
}
function cambiarContra(){
    con1 = $("#con1").val();
    con2 = $("#con2").val();
    matricula = $("#matricula").val();
    var parametros = {
        "con1" : con1,
        "con2" : con2,
        "matricula" : matricula,
        "cambiarContra" : 1
    }
    console.log(parametros);
    $.ajax(
        {
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
                if(valores.existe=="1") //A
                {
                    Swal.fire({
                          icon: 'success',
                          title: 'Exito',
                          text: 'Contrase??a cambiada'});
                          setTimeout(function(){
                            $(location).attr('href','../salir.php');
                            }, 500);
                }
                else
                {
                    Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Error al cambiar contrase??a'})
                }
            }
        })
}

/* MIS MENSAJES */
function Mensaje(id, matricula){	
	id = id
	matricula = matricula	
	var parametros = 
	{
		"buscarM": "1",
		"id" : id,
		"matricula" : matricula
	};
    console.log(parametros);
  	$.ajax(
  	{ 
		data:  parametros,
		dataType: "json",
		url:   'codigo_php_Nuevo.php',
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
		success:  function (valores){			
			if(valores.existe=="1") //A
			{
				$("#Fecha").val(valores.Fecha);
				$("#Remitente").val(valores.Usuario);
				$("#Mensaje").val(valores.Mensaje);
			}else{
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'No Se encontr?? el mensaje.'})
			}
		}
	}) 
}

/* MIS TURNOS */
function Modificar(numero){	
	var $n = numero;

    setTimeout(function(){
    $(location).attr('href','modificarNuevo.php'+'?num='+$n);
    }, 50);
		
	
}
function BorrarFiltro(){
    setTimeout(function(){
        $(location).attr('href','misTurnos.php');
        }, 10);
}
$(".checkfechaFin").on('change', function() {
    if( $(this).is(':checked') ) {
        document.getElementById('fechaFin').disabled = false;
        console.log('si')        
    } else {
        console.log('no')
        document.getElementById('fechaFin').disabled = true;
        $("#fechaFin").val("");
        ModiNuevo();
    }
})
function ModiNuevo(){
    fecha = $("#fecha").val();
    fechaFin = $("#fechaFin").val();
    menuQuirofano = $("#menuQuirofano").val();
    matricula = $("#vMatricula").val();
    paciente = $("#paciente").val()
    var parametros = {
        "misTurnos" : 1,
        "fecha" : fecha,
        "fechaFin" : fechaFin,
        "menuQuirofano" : menuQuirofano,
        "matricula" : matricula,
        "paciente" : paciente
    };
    console.log(parametros)
    $.ajax({
        data:  parametros,
        url: 'codigo_php_Nuevo.php',
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
            $('#misTurnos').html(r)
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
			text: 'Erro seleccione un motivo de suspensi??n',
			
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
			url:   'codigo_php_Nuevo.php',
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
					Swal.fire('Suspensi??n Correcta!', '', 'success')
						setTimeout(function(){
						$(location).attr('href','misTurnos.php');
						}, 500);			
				}
				else{
					Swal.fire('Suspensi??n Incorrecta!', '', 'error')
				}
	
			}
		})
		
	}	
}
function Sus(numero){	
	$("#idSuspender").text(numero);
}

/* TODOS LOS TURNOS */
function VerTodosTurnos(){
    fecha = $("#fecha").val();
    menuQuirofano = $("#menuQuirofano").val();
    var parametros = {
        "todosTurnos" : 1,
        "fecha" : fecha,
        "menuQuirofano" : menuQuirofano        
    };
    console.log(parametros)
    $.ajax({
        data:  parametros,
        url: 'codigo_php_Nuevo.php',
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
            $('#TodosTurnos').html(r)
        }
    })
    
}

function pulsar(e) {    
    if (e.keyCode === 13) {
        console.log ('presione enter');
        buscar_datos();
    }else{
        console.log ('letra')
    }
    setTimeout(function(){
        console.log("Hola Mundo");
    }, 20000);
}
 

/* Checkboxes */
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
            document.getElementById("TS").style.display = "none";
            document.getElementById("TSangre").style.display = "none";

        } else {
            $('#selectRadioSangre').text('NO');
            document.getElementById("TS").style.display = "none";
            document.getElementById("TSangre").style.display = "none";

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
    $(".laparo").on('change', function() {
        if( $(this).is(':checked') ) {
            $('#selectLaparo').text('SI');
            $('#selectLaparoo').val('SI');
        } else {
            $('#selectLaparo').text('NO');
            $('#selectLaparoo').val('NO');
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


