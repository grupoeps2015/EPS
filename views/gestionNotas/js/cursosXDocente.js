$(document).ready( function () {
    var base_url = $("#hdBASE_URL").val();
    var tipoIngresoNota = 10;
    var totalReprobados = 0;
    var totalAprobados = 0;
    
    $("#slAnio").change(function(){
        if(!$("#slAnio").val()){
            $("#slCiclo").html('');
            $("#slSeccion").html('');
            $("#slCiclo").append('<option value="" disabled>-- Ciclo --</option>')
            $("#slSeccion").append('<option value="" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getCiclosAjax();
        }
    });
    
    $("#slCiclo").change(function(){
        if(!$("#slCiclo").val()){
            $("#slSeccion").html('');
            $("#slSeccion").append('<option value="" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getDocenteSeccion();
        }
    });
    
    $("#slSeccion").change(function() {
        var id = $("#slSeccion").val();
        $("#slCursoxSeccion").val(id);
    });
    
    $("#btnActividades").click(function() {
        var tpretra = 0;
        var funcion = "/getEstadoCicloNotas";
        
        tipoIngresoNota = parseInt($("input[type='radio'][name='rbTipoNota']:checked").val());
        if(tipoIngresoNota === 20){
            funcion = "/getEstadoCicloRetra";
            tpretra=1;
        }else if(tipoIngresoNota === 30){
            funcion = "/getEstadoCicloRetra";
            tpretra=2;
        }
        
        $.post(base_url+'gestionNotas'+funcion,
            {
                cicloaver: $("#slCiclo").val(),
                tipoAs: $("#hdtipoAs").val(),
                centrounidad: $("#hdcentrounidad").val(),
                retra: tpretra
            },
            function(datos){
                var est = parseInt(datos.estado);
                $('#hdEstadoCiclo').val(est);
            },
            'json');
        
        $.post(base_url+'ajax/getIdTrama',
            {
                cat: $("#idCatedratico").val(),
                ciclo: $("#slCiclo").val(),
                sec: $("#slSeccion").val(), 
                cur: $("#slCursoxSeccion option:selected").text()
            },
            function(datos){
                var tipo = $("#hdTipo").val(); 
                if(datos.length>0){
                    var identificador = parseInt(datos[0].spidtrama);
                    if(tipo === "1") { 
                        mostrarListadoAsignados(identificador, $("#slCiclo").val());
                    }
                    else{
                        mostrarListado(identificador, $("#slCiclo").val());
                    }
                }else{
                    mostrarListado(0,0);
                }
            },
            'json');
    });
    
    $("#btnGuardar").click(function(){
        var zona = 0;
        var final = 0;
        var zonaMax = parseFloat($("#hdZonaTotal").val());
        var finalMax = parseFloat($("#hdFinalTotal").val());
        var todoOK = true;

        var inputs = $("#tbAsignados :input");
        $.each(inputs, function(i, field){
            if(field.type === "text"){
                tipo = field.name.substring(0,1);
                if(tipo === "z"){
                    zona = parseFloat(field.value);
                    if(zona > zonaMax){
                        todoOK = false;
                    }
                }

                if(tipo === "f"){
                    final = parseFloat(field.value);
                    if(final > finalMax){
                        todoOK = false;
                    }
                }

            }    
        });

        if(todoOK){
            if(tipoIngresoNota === 10){
                guardarNota();
            }else if(tipoIngresoNota === 20){
                guardarRetrasada(1);
            }else if(tipoIngresoNota === 30){
                guardarRetrasada(2);
            }
        }else{
            $("#spanMsg").html('Algunas de las notas ingresadas no cumplen con los <br/> valores establecidos para zona y examen final. <br/>Verifique y vuelva a intentar.');
        }
    });
    
    $("#csvFile").change(function(){
        $("#frFile").submit();
    });
    
    $("#frFile").submit(function(){
        var datos = new FormData();
        var path = base_url + "gestionNotas/notasCSV";
        datos.append('csvFile',$("#csvFile")[0].files[0]);
        $.ajax({
            type:"post",
            dataType:"json",
            url:path,
            contentType:false,
            data:datos,
            processData:false
        }).done(function(respuesta){
            //alert(respuesta.mensaje);
            for(var i =0; i < respuesta.info.length; i++){
                var indice = respuesta.info[i]['carnet'];
                $("#slCarnetxAsignacion").val(indice);
                var idAsigna = $("#slCarnetxAsignacion option:selected").text()
                var totalAsignado = parseFloat(respuesta.info[i]['zona']) + parseFloat(respuesta.info[i]['final']);
                $("#z"+idAsigna).val(respuesta.info[i]['zona']);
                $("#f"+idAsigna).val(respuesta.info[i]['final']);
                $("#t"+idAsigna).val(totalAsignado);
            }
            $("#spanMsg").append(respuesta.mensaje);
        })
        .error(function(respuesta){
            alert('Error inesperado: ' + respuesta.mensaje);
        });
        return false;
    });
    
    $("#btnAprobarNotas").click(function(){
        $("#spanMsg").html('');
        var tipo = "";
        var idAsignado = 0;;
        var total;
        
        var notaAprobacion = parseInt($("#hdNotaAprobacion").val());
        var estado = parseInt($("#hdEstadoCiclo").val());
        if(estado===1){
            $("#spanMsg").html('El periodo de ingreso de notas sigue vigente');
        }else{
            
            var inputs = $("#tbAsignados :input");
            $.each(inputs, function(i, field){
                if(field.type === "hidden"){
                    tipo = field.name.substring(0,1);
                    if(tipo === "t"){
                        idAsignado = field.name.substring(1);
                        total = field.value;
                        
                        if(tipoIngresoNota === 10){
                            if(total>=notaAprobacion){
                                aprobarNota(idAsignado);
                            }else{
                                reprobarNota(idAsignado);
                            }
                        }else{
                            if(total>=notaAprobacion){
                                aprobarRetra(idAsignado);
                            }else{
                                reprobarRetra(idAsignado);
                            }
                        }
                        //bitacora(idAsignado);
                    }

                }
            });
            $("#spanMsg").html('Total Alumnos Aprobados: '+totalAprobados + '<br/>');
            $("#spanMsg").append('Total Alumnos Reprobados: '+totalReprobados);
            $("#btnAprobarNotas").prop('disabled',true);
        }
    });
    
    function getCiclosAjax(){
        $.post(base_url+'ajax/getCiclosAjax',
               'anio=' + $("#slAnio").val(),
               function(datos){
                    $("#slCiclo").html('');
                    if(datos.length>0){
                        $("#slCiclo").append('<option value="">-- Ciclo --</option>' );
                        for(var i=0; i < datos.length; i++){
                            $("#slCiclo").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slCiclo").append('<option value="" disabled>No hay info.</option>' );
                    }
               },
               'json');
    }
    
    function getDocenteSeccion(){
        $.post(base_url+'ajax/getDocenteSeccion',
               { cat: $("#idCatedratico").val(), ciclo: $("#slCiclo").val() },
               function(datos){
                   $("#slSeccion").html('');
                   $("#slCursoxSeccion").html('');
                    if(datos.length>0){
                        for(var i =0; i < datos.length; i++){
                            $("#slSeccion").append('<option value="' + datos[i].idseccion + '">' + datos[i].infoseccion + '</option>' );
                            $("#slCursoxSeccion").append('<option value="' + datos[i].idseccion + '" name="' + datos[i].idcurso + '" >' + datos[i].idcurso + '</option>' );
                        }
                        $("#btnActividades").prop("disabled",false);
                    }else{
                        $("#slSeccion").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                        $("#btnActividades").prop("disabled",true);
                    }
               },
               'json');
    }
    
    function mostrarListadoAsignados(id, ciclo){
        var notas = "";
        $.post(base_url+'ajax/getListaAlumnosAsignados',
        { trama: id, ciclo: ciclo },
            function(datos){
                $("#tbAsignados").css('display','block');
                $("#bodyAsignados").html('');
                if(datos.length>0){
                    for(var i =0; i < datos.length; i++){
                            notas = '</td><td>' + datos[i].nombreseccion + 
                                    '</td><td>' + datos[i].oportunidadactual;
                        
                        $("#bodyAsignados").append('<tr><td>' + datos[i].carnet + 
                                                   '</td><td>' + datos[i].nombre + 
                                                   notas + '</td><td>' + datos[i].telefonoemergencia);
                    }
                }
                $('#tdBotones').css('display','none');
                aplicarCss();
            },
            'json');
    }
    
    function mostrarListado(id, idCiclo){
        if(tipoIngresoNota === 10 ){
            $("#slCarnetxAsignacion").html('');
            $.post(base_url+'gestionNotas/getListaAsignados',
                {trama: id, ciclo: idCiclo },
                function(datos){
                    var idAsignaActividad = -1;
                    if(datos.length>0){
                        idAsignaActividad = parseInt(datos[0].idasignacion);
                        hayActividades(idAsignaActividad,id,idCiclo);
                    }else{
                        alert('Error inesperado, contacte con el administrador');
                    }
                },
                'json');
        }else if(tipoIngresoNota === 20){
            datosRetrasada(id,idCiclo,1);
        }else if(tipoIngresoNota === 30){
            datosRetrasada(id,idCiclo,2);
        }
    }
    
    function hayActividades(idAA,id,idCiclo){
        var contador = 0;
        $.post(base_url+'gestionNotas/contarActividades',
            {trama: idAA},
            function(respuesta){
                //contador = respuesta.total;
                if(parseInt(respuesta.total) <= 2){
                    notaNormal(id,idCiclo);
                }else{
                    notaNormal(id,idCiclo);
                    //notaActividad(id,idCiclo);
                }
            },
            'json');
            return contador;
    }
    
    function notaNormal(id,idCiclo){
        var estado = 0;
        var notas = "";
        $("#slCarnetxAsignacion").html('');
        $.post(base_url+'gestionNotas/getListaAsignados',
            {trama: id, ciclo: idCiclo },
            function(datos){
                $("#tbAsignados").css('display','block');
                $("#bodyAsignados").html('');
                if(datos.length>0){
                    estado = parseInt($('#hdEstadoCiclo').val());
                    $('#hdTotalAsignados').val(datos.length.toString());
                    
                    if(parseInt(datos[0].estado) !== 2){
                        $("#tdExtra").remove();
                    }

                    for(var i=0; i < datos.length; i++){
                        if(estado === 1){
                            $("#slCarnetxAsignacion").append('<option value="' + datos[i].carnet + '" name="' + datos[i].carnet + '" >' + datos[i].idasignacion + '</option>' );                            
                            notas = '</td><td><input id="z' + datos[i].idasignacion + '" name="z' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + datos[i].zona + '" style="width:60%; text-align:center;"/>' + 
                                    '</td><td><input id="f' + datos[i].idasignacion + '" name="f' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + datos[i].final + '" style="width:60%; text-align:center;"/>' + 
                                    '</td><td><input id="t' + datos[i].idasignacion + '" name="t' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + datos[i].total + '" style="width:60%; text-align:center;" readonly/>';
                        }else{
                            notas = '</td><td>' + datos[i].zona + 
                                    '</td><td>' + datos[i].final + 
                                    '</td><td>' + datos[i].total +
                                    '<input type="hidden" id="t' + datos[i].idasignacion + '" name="t' + datos[i].idasignacion + '" maxlength="5" value="' + datos[i].total + '"/>';
                        }
                        $("#bodyAsignados").append('<tr><td>' + datos[i].carnet + 
                                                   '</td><td>' + datos[i].nombre + 
                                                   notas + '</td>');
                    }
                }
                if(estado === 1){
                    $('#tdBotones').css('display','block');
                }else{
                    $('#tdBotones').css('display','none');
                }
                aplicarCss();
            },
            'json');
    }
    
    function notaActividad(id,idCiclo){
        alert(id +" - hay actividades - " + idCiclo);
    }
    
    function aplicarCss(){
        $('#slTipos').prop('disabled',true);
        $('#slAnio').prop('disabled',true);
        $('#slCiclo').prop('disabled',true);
        $('#slSeccion').prop('disabled',true);
        $('#btnActividades').css('display','none');
        $('#btnNuevaBusqueda').css('display','block');
        
        $('#tbAsignados').DataTable({
            language:{
                emptyTable: "No hay informaci&oacute;n disponible.",
                sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda",
                info: "Se muestran del _START_ al _END_ de _TOTAL_ registros",
                infoEmpty: "No hay registros que mostrar",
                paginate:{
                    next: "Siguiente",
                    previous: "Anterior"
                },
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                iDisplayLength: 100
            }
        });
    }
    
    function guardarNota(){
        $("#spanMsg").html('');
        var tipo = "";
        var idAsignado = 0;
        var zonaAsignada = 0;
        var finalAsignado = 0;
        var inputs = $("#tbAsignados :input");
        $.each(inputs, function(i, field){
            if(field.type === "text"){
                tipo = field.name.substring(0,1);
                if(tipo === "z"){
                    idAsignado = field.name.substring(1);
                    zonaAsignada = field.value;
                }
                
                if(tipo === "f"){
                    finalAsignado = field.value;
                    $.post(
                        base_url+'gestionNotas/guardarNota',{ 
                            zonaN: zonaAsignada,
                            finalN: finalAsignado, 
                            idAs: idAsignado
                        },
                        function(respuesta){
                            $("#t"+field.name.substring(1)).val(respuesta.total);
                            $("#spanMsg").html(respuesta.mensaje);
                        },
                        'json'
                    );
                    
                    bitacora(idAsignado);
                }
                
            }    
        });
    }
    
    function guardarRetrasada(){
        $("#spanMsg").html('');
        var tipo = "";
        var idAsignado = 0;
        var zonaAsignada = 0;
        var finalAsignado = 0;
        var inputs = $("#tbAsignados :input");
        $.each(inputs, function(i, field){
            if(field.type === "text"){
                tipo = field.name.substring(0,1);
                if(tipo === "z"){
                    idAsignado = field.name.substring(1);
                    zonaAsignada = field.value;
                }
                
                if(tipo === "f"){
                    finalAsignado = field.value;
                    $.post(
                        base_url+'gestionNotas/guardarRetrasada',{ 
                            zonaN: zonaAsignada,
                            finalN: finalAsignado, 
                            idAs: idAsignado
                        },
                        function(respuesta){
                            $("#t"+field.name.substring(1)).val(respuesta.total);
                            $("#spanMsg").html(respuesta.mensaje);
                        },
                        'json'
                    );
                    
                    bitacoraretra(idAsignado);
                }
                
            }    
        });
    }
    
    function aprobarNota(idAsignado){
        $.post(
            base_url+'gestionNotas/aprobarNota',{
                idAs: idAsignado
            },
            function(respuesta){
            },
            'json');
        totalAprobados += 1;
    }
    
    function reprobarNota(idAsignado){
        $.post(
            base_url+'gestionNotas/reprobarNota',{
                idAs: idAsignado
            },
            function(respuesta){
            },
            'json');
        totalReprobados += 1;
    }
    
    function aprobarRetra(idAsignado){
        $.post(
            base_url+'gestionNotas/aprobarRetra',{
                idAs: idAsignado
            },
            function(respuesta){
            },
            'json');
        totalAprobados += 1;
    }
    
    function reprobarRetra(idAsignado){
        $.post(
            base_url+'gestionNotas/reprobarRetra',{
                idAs: idAsignado
            },
            function(respuesta){
            },
            'json');
        totalReprobados += 1;
    }
    
    function datosRetrasada(id,idCiclo,tipoRetra){
        var estado = 1;
        var notas = "";
        var total = -1;
        $("#slCarnetxAsignacion").html('');
        $.post(base_url+'gestionNotas/getListaAsignadosRetra',
            {trama: id, ciclo: idCiclo, retra: tipoRetra },
            function(datos){
                $("#tbAsignados").css('display','block');
                $("#bodyAsignados").html('');
                if(datos.length>0){
                    //CAMBIAR EL ESTADO A UN CICLO DE INGRESO DE RETRA ACTIVO
                    estado = parseInt($('#hdEstadoCiclo').val());
                    if(parseInt(datos[0].estado) !== 2){
                        $("#tdExtra").remove();
                    }

                    $('#hdTotalAsignados').val(datos.length.toString());
                    for(var i=0; i < datos.length; i++){
                        total = parseFloat(datos[i].zona) + parseFloat(datos[i].retra);
                        if(estado === 1){
                            $("#slCarnetxAsignacion").append('<option value="' + datos[i].carnet + '" name="' + datos[i].carnet + '" >' + datos[i].idasignacion + '</option>' );                            
                            notas = '</td><td><input id="z' + datos[i].idasignacion + '" name="z' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + datos[i].zona + '" style="width:60%; text-align:center;" readonly/>' + 
                                    '</td><td><input id="f' + datos[i].idasignacion + '" name="f' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + datos[i].retra + '" style="width:60%; text-align:center;"/>' + 
                                    '</td><td><input id="t' + datos[i].idasignacion + '" name="t' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + total + '" style="width:60%; text-align:center;" readonly/>';
                        }else{
                            notas = '</td><td>' + datos[i].zona + 
                                    '</td><td>' + datos[i].retra + 
                                    '</td><td>' + total +
                                    '<input type="hidden" id="t' + datos[i].idasignacion + '" name="t' + datos[i].idasignacion + '" maxlength="5" value="' + total + '"/>';
                        }
                        $("#bodyAsignados").append('<tr><td>' + datos[i].carnet + 
                                                   '</td><td>' + datos[i].nombre + 
                                                   notas + '</td>');
                    }
                }else{
                    $("#tdExtra").remove();
                    $('#tdBotones').remove();
                }
                if(estado === 1){
                    $('#tdBotones').css('display','block');
                }else{
                    $('#tdBotones').css('display','none');
                }
                aplicarCss();
            },
            'json');
    }
    
    function bitacora(idRegistro){
        $.post(
            base_url+'bitacora/insertarBitacoraNota',
            { 
                registro: idRegistro
            },
            function(info){
                //alert(info);
            }
        );
    }
    
    function bitacoraretra(idRegistro){
        $.post(
            base_url+'bitacora/insertarBitacoraRetra',
            { 
                registro: idRegistro
            },
            function(info){
                //alert(info);
            }
        );
    }
    
});