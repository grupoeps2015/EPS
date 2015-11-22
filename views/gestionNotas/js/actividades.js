$(document).ready( function () {
    var base_url = $("#hdBASE_URL").val();
    var numTarea = 0;
    var totalAsignados = 0;
    
    $('#frmGenerales').validate({
        rules:{
            slTipoActividad:{
                required: true
            },
            txtNombreAct:{
                required: true  
            },
            txtValorAct:{
                required: true,
                min: 1,
                max: 100
            }
        },
        messages:{
            slTipoActividad:{
                required: "Seleccione un tipo de actividad"
            },
            txtNombreAct:{
                required: "Ingrese el nombre de la actividad segun el ejemplo"
            },
            txtValorAct:{
                required: "Ingrese una zona, en caso de no existir, ingrese 0",
                min: "La nota no puedes ser menor o igual a 0",
                max: "La nota no puede ser mayor a 100 puntos"
            }
        }
    });
    
    $("#slTipos").change(function(){
        if(!$("#slTipos").val()){
            $("#slAnio").html('');
            $("#slCiclo").html('');
            $("#slSeccion").html('');
            $("#slAnio").append('<option value="-1" disabled>-- A&ntilde;o --</option>')
            $("#slCiclo").append('<option value="-1" disabled>-- Ciclo --</option>')
            $("#slSeccion").append('<option value="-1" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getAniosAjax();
        }
    });
    
    $("#slAnio").change(function(){
        if(!$("#slAnio").val()){
            $("#slCiclo").html('');
            $("#slSeccion").html('');
            $("#slCiclo").append('<option value="-1" disabled>-- Ciclo --</option>')
            $("#slSeccion").append('<option value="-1" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getCiclosAjax();
        }
    });
    
    $("#slCiclo").change(function(){
        if(!$("#slCiclo").val()){
            $("#slSeccion").html('');
            $("#slSeccion").append('<option value="-1" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getDocenteSeccion();
        }
    });
    
    $("#slSeccion").change(function() {
        var id = $("#slSeccion").val();
        $("#slCursoxSeccion").val(id);
    });
    
    $("#btnActividades").click(function() {
        $.post(base_url+'ajax/getIdTrama',
            { 
                cat: $("#idCatedratico").val(),
                ciclo: $("#slCiclo").val(),
                sec: $("#slSeccion").val(), 
                cur: $("#slCursoxSeccion option:selected").text()
            },
            function(datos){
                if(datos.length>0){
                    var identificador = parseInt(datos[0].spidtrama);
                    llenarAsignados(identificador, $("#slCiclo").val());
                    
                    $.post(base_url+'gestionNotas/getEstadoCicloActividades',
                        { cicloaver: $("#slCiclo").val() },
                        function(datos){
                            var estado = 0;
                            if(datos.length>0){
                                estado = parseInt(datos[0].estado.toString());
                                if(estado === 1){
                                    verificarActividades();
                                }else{
                                    $("#spanMsg").html('El periodo de ingreso de actividades no se encuentra activado');
                                    $("#tbActividades").css('display','none');
                                }
                            }
                        },
                        'json');
                    
                }else{
                    $("#spanMsg").html('No se encontro ningun alumno asignado, por lo que no es necesario crear actividades');
                    $("#tbActividades").css('display','none');
                }
            },
            'json');
    });
    
    $("#btnNvaActividad").click(function(){
        var padre = $("#slActPadre").val();
        var tipo = $("#slTipoActividad").val();
        var nombre = $("#txtNombreAct").val();
        var valor = $("#txtValorAct").val();
        var desc = $("#txtDescAct").val();
        var boton = $('<button/>',
        {
            id: 'btAct'+numTarea,
            value: numTarea,
            class: 'btn btn-danger input-sm',
            text: '-',
            style: 'width: 25%',
            click: function(){ $('#trAct'+$(this).val()).remove(); return false;}
        }).wrap('<td style="width:25%"></td>').closest('td');

        if(nombre !== "" && valor !== "" && tipo !== ""){
            $("#tbodyAct").append(
                '<tr id="trAct'+numTarea+'" name="trAct'+numTarea+'">' + 
                    '<td style="width:19%;">'+$("#slTipoActividad option:selected").text()+'</td>' +
                    '<td style="width:30%;">'+nombre+'&nbsp;</td>' +
                    '<td style="width:1%">&nbsp;</td>' +
                    '<td style="width:24%">'+valor+' pts.&nbsp;</td>' +
                    '<td style="width:1%">&nbsp;' +
                        '<input type="hidden" id="hdPd'+numTarea+'" name="hdPd'+numTarea+'" value="'+padre+'"/>' +
                        '<input type="hidden" id="hdTp'+numTarea+'" name="hdTp'+numTarea+'" value="'+tipo+'"/>' +
                        '<input type="hidden" id="hdNm'+numTarea+'" name="hdNm'+numTarea+'" value="'+nombre+'"/>' +
                        '<input type="hidden" id="hdVl'+numTarea+'" name="hdVl'+numTarea+'" value="'+valor+'"/>' +
                        '<input type="hidden" id="hdDs'+numTarea+'" name="hdDs'+numTarea+'" value="'+desc+'"/>' +
                    '</td>' +
                '</tr>');
            numTarea = numTarea + 1;
            $("#slTipoActividad").val("");
            $("#slTipoActividad").focus();
            $("#txtNombreAct").val("");
            $("#txtValorAct").val("");
            $("#txtDescAct").val("");
            $("#spanConfirma").html('Nueva Actividad Agregada ('+nombre+')');
            $("#tbodyAct td:last").after(boton);
        }else{
            $("#spanConfirma").html('Informaci&oacute;n incompleta');
        }
    });
    
    $("#btnGuardar").confirm({
        text: "No podrá modificar las actividades ingresadas sin autorización de un usuario de unidad académica.<br/> ¿Está seguro de agregar solo estas actividades?",
        title: "Confirmacion requerida",
        confirm: function() {
            // Por orden se utilizo el boton de confirmar como cancelar y vicebersa
        },
        cancel: function() {
            //Esta es la accion al dar click en Continuar
            guardarActividad();
            $("#btnGuardar").prop('disabled',true);
            $("#tbActividades").css('display','none');
            $("#slTipos").prop('disabled',false);
            $("#slTipos").val("-1");
            $("#slAnio").prop('disabled',false);
            $("#slAnio").val("-1");
            $("#slCiclo").prop('disabled',false);
            $("#slCiclo").val("-1");
            $("#slSeccion").prop('disabled',false);
            $("#slSeccion").val("-1");
            $("#btnActividades").prop('disabled',false);
        },
        cancelButton: "Continuar",
        confirmButton: "Regresar",
        post: true,
        cancelButtonClass: "btn-warning",
        confirmButtonClass: "btn-warning",
        dialogClass: "modal-dialog modal-lg text-primary"
    });
    
    function getAniosAjax(){
        $.post(base_url+'ajax/getAniosAjax',
               'tipo=' + $("#slTipos").val(),
               function(datos){
                    $("#slAnio").html('');
                    if(datos.length>0 ){
                        $("#slAnio").append('<option value="-1">-- A&ntilde;o --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slAnio").append('<option value="' + datos[i].anio + '">' + datos[i].anio + '</option>' );
                        }
                    }else{
                        $("#slAnio").append('<option value="-1" disabled>No hay info.</option>' );
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
                        $("#slCiclo").append('<option value="-1">-- Ciclo --</option>' );
                        for(var i=0; i < datos.length; i++){
                            $("#slCiclo").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slCiclo").append('<option value="-1" disabled>No hay info.</option>' );
                    }
               },
               'json');
    }
    
    function getDocenteSeccion(){
        $.post(base_url+'ajax/getDocenteSeccion',
            {
                cat: $("#idCatedratico").val(), 
                ciclo: $("#slCiclo").val() 
            },
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
                     $("#slSeccion").append('<option value="-1" disabled>No hay informaci&oacute;n disponible</option>' );
                     $("#btnActividades").prop("disabled",true);
                 }
            },
            'json');
    }
       
    function verificarActividades(){
        $("#slIdxAsignacion").val(0);
        var idTrama = $("#slIdxAsignacion option:selected").text();
        var zona = $("#hdZonaTotal").val();
        var final = $("#hdFinalTotal").val();
        $.post(base_url+'gestionNotas/contarActividades',
            {trama: idTrama},
            function(respuesta){
                if(parseInt(respuesta.total) <= 2){
                    $("#spanMsg").html('Por defecto se tiene zona de ' + zona + ' puntos y final de ' + final + ' puntos.<br/>Puede guardar la informacion de esta manera o crear actividades.<br/>Las actividades creadas seran asociadas a los puntos de zona.<br/>');
                }else{
                    listarActividades();
                }
            },
            'json');
        $("#tbActividades").css('display','block');
        $("#slTipos").prop('disabled',true);
        $("#slAnio").prop('disabled',true);
        $("#slCiclo").prop('disabled',true);
        $("#slSeccion").prop('disabled',true);
        $("#btnActividades").prop('disabled',true);
    }
       
    function guardarActividad(){
        $("#spanMsg").html('');
        var TotalFinal = parseFloat($("#hdFinalTotal").val());
        var TotalZona = parseFloat($("#hdZonaTotal").val());
        var SumarZona = 0;
        var Pd = 0;  //Id Actividad Padre
        var Tp = 0;  //Id Tipo Actividad
        var Nm = ""; //Nombre Actividad
        var Vl = 0;  //Valor Actividad
        var Ds = ""; //Descripcion Actividad
        var Hd = ""; //Identificar del hidden
        var num = 0;
        var inputs = $("#tbActividades :input");
        $.each(inputs, function(i, field){
            if(field.type === "hidden"){
                Hd = field.name.substring(0,4);
                num = field.name.substring(5);
                if(Hd === "hdVl"){
                    SumarZona = SumarZona + parseFloat(field.value);
                }
            }
        });
        if(SumarZona === 0){
            //No agrego actividades, asi que no se hacen inserts
            alert("Sin actividades "  + SumarZona + "=" + TotalZona);
        }else{
            if(SumarZona > TotalZona){
                alert("Las actividades suman mas puntos que la zona actual, verifique las actividades ingresadas. " + SumarZona + ">" + TotalZona);
            }else if(SumarZona < TotalZona){
                alert("Las actividades suman menos puntos que la zona actual, agregue actividades para completar la nota o edite alguna de las ya existentes"  + SumarZona + "<" + TotalZona);
            }else if(SumarZona === TotalZona){
                //Las actividades suman la zona de forma correcta
                $.each(inputs, function(i, field){
                    if(field.type === "hidden"){
                        Hd = field.name.substring(0,4);
                        switch(Hd){
                            case "hdPd":
                                Pd = parseInt(field.value);
                                break;
                            case "hdTp":
                                Tp = parseInt(field.value);
                                break;
                            case "hdNm":
                                Nm = field.value;
                                break;
                            case "hdVl":
                                Vl = parseFloat(field.value);
                                break;
                            case "hdDs":
                                Ds = field.value;
                                agregarActividad(Pd,Tp,Nm,Vl,Ds);
                                break;
                        }
                    }
                });
            }
        }
    }
    
    function agregarActividad(padre,tipo,nombre,valor,descripcion){
        $.post(
            base_url+'gestionNotas/guardarActividad',{ 
                idPadre: padre,
                idTipo: tipo,
                txtNombre: nombre,
                flValor: valor,
                txtDesc: descripcion
            },
            function(respuesta){
                $("#spanMsg").append(respuesta.mensaje + '<br/>');
                asociarActivida(respuesta.id);
            },
            'json'
        );
    }

    function llenarAsignados(id,idCiclo){
        $.post(base_url+'ajax/getListaAsignados',
            {trama: id, ciclo: idCiclo },
            function(datos){
                if(datos.length>0){
                    $("#slIdxAsignacion").html("");
                    totalAsignados = parseInt(datos.length.toString());
                    for(var i =0; i < datos.length; i++){
                        $("#slIdxAsignacion").append('<option value="' + i + '">' + datos[i].idasignacion + '</option>' );
                    }
                }else{
                    $("#slSeccion").append('<option value="-1" disabled>No hay informaci&oacute;n disponible</option>' );
                }
            },
            'json');
    }

    function asociarActivida(idActividad){
        var idAsignado = 0;
        for(var i=0; i < totalAsignados; i++){
            $("#slIdxAsignacion").val(i);
            idAsignado = $("#slIdxAsignacion option:selected").text();
            $("#slIdxAsignacion").val(i);
            $.post(base_url+'gestionNotas/setActividadAsignado',
            {actividad: idActividad, asignado: idAsignado },
            function(datos){
                //alert('transaccion exitosa');
            });
        }
    }
    
    function listarActividades(){
          $("#tbodyAct").html('');
          $("#spanMsg").html('Ya han sido agregadas actividades para este curso');
//        $("#tbodyAct").append(
//                '<tr id="trAct'+numTarea+'" name="trAct'+numTarea+'">' + 
//                    '<td style="width:19%;">'+$("#slTipoActividad option:selected").text()+'</td>' +
//                    '<td style="width:30%;">'+nombre+'&nbsp;</td>' +
//                    '<td style="width:1%">&nbsp;</td>' +
//                    '<td style="width:24%">'+valor+' pts.&nbsp;</td>' +
//                    '<td style="width:1%">&nbsp;' +
//                        '<input type="hidden" id="hdPd'+numTarea+'" name="hdPd'+numTarea+'" value="'+padre+'"/>' +
//                        '<input type="hidden" id="hdTp'+numTarea+'" name="hdTp'+numTarea+'" value="'+tipo+'"/>' +
//                        '<input type="hidden" id="hdNm'+numTarea+'" name="hdNm'+numTarea+'" value="'+nombre+'"/>' +
//                        '<input type="hidden" id="hdVl'+numTarea+'" name="hdVl'+numTarea+'" value="'+valor+'"/>' +
//                        '<input type="hidden" id="hdDs'+numTarea+'" name="hdDs'+numTarea+'" value="'+desc+'"/>' +
//                    '</td>' +
//                '</tr>');
    }
});