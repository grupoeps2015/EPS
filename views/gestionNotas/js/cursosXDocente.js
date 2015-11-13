$(document).ready( function () {
    var base_url = $("#hdBASE_URL").val();
    
    $("#slTipos").change(function(){
        if(!$("#slTipos").val()){
            $("#slAnio").html('');
            $("#slCiclo").html('');
            $("#slSeccion").html('');
            $("#slAnio").append('<option value="" disabled>-- A&ntilde;o --</option>')
            $("#slCiclo").append('<option value="" disabled>-- Ciclo --</option>')
            $("#slSeccion").append('<option value="" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getAniosAjax();
        }
    });
    
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
        $.post(base_url+'ajax/getEstadoCicloNotas',
            { cicloaver: $("#slCiclo").val() },
            function(datos){
                if(datos.length>0){
                    $('#hdEstadoCiclo').val(datos[0].estadociclo.toString());
                }else{
                    $('#hdEstadoCiclo').val("0");
                }
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
                //alert($("#idCatedratico").val() + ' ' + $("#slCiclo").val() + ' ' + $("#slCursoxSeccion option:selected").text() + ' ' + $("#slSeccion").val());
                var tipo = $("#hdTipo").val();
                if(datos.length>0){
                    if(tipo === "1") { 
                        var identificador = parseInt(datos[0].spidtrama);
                        mostrarListadoAsignados(identificador, $("#slCiclo").val());
                    }
                    else{
                        var identificador = parseInt(datos[0].spidtrama);
                        mostrarListado(identificador, $("#slCiclo").val());
                    }
                }else{
                    mostrarListado(0,0);
                }
            },
            'json');
    });
    
    $("#btnGuardar").click(function(){
        guardarNota();
    });
    
    $("#csvFile").change(function(){
        $("#frFile").submit();
    });
    
    $("#frFile").submit(function(){
        var datos = new FormData();
        datos.append('csvFile',$("#csvFile")[0].files[0]);
        $.ajax({
            type:"post",
            dataType:"json",
            url:"http://localhost/EPS/gestionNotas/notasCSV",
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
    
    function getAniosAjax(){
        $.post(base_url+'ajax/getAniosAjax',
               'tipo=' + $("#slTipos").val(),
               function(datos){
                    $("#slAnio").html('');
                    if(datos.length>0 ){
                        $("#slAnio").append('<option value="">-- A&ntilde;o --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slAnio").append('<option value="' + datos[i].anio + '">' + datos[i].anio + '</option>' );
                        }
                    }else{
                        $("#slAnio").append('<option value="" disabled>No hay info.</option>' );
                    }
               },
               'json');
    }
    
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
        alert(id);
        alert(ciclo);
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
        var estado = parseInt($('#hdEstadoCiclo').val());
        var notas = "";
        $("#slCarnetxAsignacion").html('');
        $.post(base_url+'ajax/getListaAsignados',
            {trama: id, ciclo: idCiclo },
            function(datos){
                $("#tbAsignados").css('display','block');
                $("#bodyAsignados").html('');
                if(datos.length>0){
                    $('#hdTotalAsignados').val(datos.length.toString());
                    for(var i =0; i < datos.length; i++){
                        if(estado === 1){
                            $("#slCarnetxAsignacion").append('<option value="' + datos[i].carnet + '" name="' + datos[i].carnet + '" >' + datos[i].idasignacion + '</option>' );
                            
                            notas = '</td><td><input id="z' + datos[i].idasignacion + '" name="z' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + datos[i].zona + '" style="width:60%; text-align:center;"/>' + 
                                    '</td><td><input id="f' + datos[i].idasignacion + '" name="f' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + datos[i].final + '" style="width:60%; text-align:center;"/>' + 
                                    '</td><td><input id="t' + datos[i].idasignacion + '" name="t' + datos[i].idasignacion + '" type="text" maxlength="5" value="' + datos[i].total + '" style="width:60%; text-align:center;" readonly/>';
                        }else{
                            notas = '</td><td>' + datos[i].zona + 
                                    '</td><td>' + datos[i].final + 
                                    '</td><td>' + datos[i].total;
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
});


