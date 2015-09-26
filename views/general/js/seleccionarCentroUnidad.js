$(document).ready( function () {
    $("#slCentros").change(function(){
        if(!$("#slCentros").val()){
            $("#slUnidad").html('');
            $("#slUnidad").append('<option value="" disabled>-- Unidad Acad&eacute;mica --</option>')
        }else{
            $('#divTabla').css("display","none");
            getUnidadesAjax();
        }
    });
    
    $("#slUnidad").change(function(){
        if(!$("#slUnidad").val()){
            $('#btnConsultar').prop("disabled",true);
        }else{
            $('#btnConsultar').prop("disabled",false);
            getCentroUnidadAjax();
        }
    });
    
    function getUnidadesAjax(){
        $.post('../../ajax/getUnidadesAjax',
               'centro=' + $("#slCentros").val(),
               function(datos){
                    $("#slUnidad").html('');
                    if(datos.length>0){
                        $("#slUnidad").append('<option value="">-- Unidad Acad&eacute;mica --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slUnidad").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slUnidad").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    function getCentroUnidadAjax(){
        $.post('../../ajax/getCentroUnidadAjax',
                { centro: $("#slCentros").val(), unidad: $("#slUnidad").val() },
               function(datos){
                    if(datos.length>0){
                        for(var i =0; i < datos.length; i++){
                            $('#hdCentroUnidad').val(datos[i].id);
                        }
                    }else{
                    }
               },
               'json');
    }
} );