$(document).ready( function () {
    var base_url = $("#hdBASE_URL").val();
    var numTarea = 0;
    
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
        mostrarCreadorActividades();
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
                    '<td style="width:19%;">&nbsp;</td>' +
                    '<td style="width:30%;">'+nombre+'&nbsp;</td>' +
                    '<td style="width:1%">&nbsp;</td>' +
                    '<td style="width:24%">'+valor+' pts.&nbsp;</td>' +
                    '<td style="width:1%">&nbsp;' +
                        '<input type="hidden" id="hdPadre'+numTarea+'" name="hdPadre'+numTarea+'" value="'+padre+'"/>' +
                        '<input type="hidden" id="hdTipo'+numTarea+'" name="hdTipo'+numTarea+'" value="'+tipo+'"/>' +
                        '<input type="hidden" id="hdNombre'+numTarea+'" name="hdNombre'+numTarea+'" value="'+nombre+'"/>' +
                        '<input type="hidden" id="hdValor'+numTarea+'" name="hdValor'+numTarea+'" value="'+valor+'"/>' +
                        '<input type="hidden" id="hdDesc'+numTarea+'" name="hdDesc'+numTarea+'" value="'+desc+'"/>' +
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
        text: "No podra modificar las actividaes ingresadas sin autorizacion de un usuario de unidad academica.<br/> ¿Esta seguro de agregar solo estas actividaes?",
        title: "Confirmacion requerida",
        confirm: function() {
            $( "#frActividades" ).submit();
        },
        cancel: function() {
            // No realiza ninguna accion
        },
        confirmButton: "Continuar",
        cancelButton: "Cancelar",
        post: true,
        confirmButtonClass: "btn-default",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog modal-lg text-primary"
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
                     $("#slSeccion").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                     $("#btnActividades").prop("disabled",true);
                 }
            },
            'json');
    }
        
    function mostrarCreadorActividades(){
        $("#spanMsg").html('Por defecto se tiene zona de 75 puntos y final de 25 puntos<br/>Puede Guardar la informacion de esta manera, modificar la ponderacion que se le presenta o detallar actividades que conformen la zona');
        $("#tbActividades").css('display','block');
    }
        
});