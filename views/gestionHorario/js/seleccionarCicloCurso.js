$(document).ready( function () {
    $("#slTipos").change(function(){
        if(!$("#slTipos").val()){
            $("#slCiclo").html('');
            $("#slCiclo").append('<option value="" disabled>-- Ciclo --</option>')
        }else{
            $('#divTabla').css("display","none");
            getCiclosAjax();
        }
    });
    
    $("#slCiclo").change(function(){
        if(!$("#slCiclo").val() || !$("#slSec").val()){
            $('#btnConsultar').prop("disabled",true);
        }else{
            $('#hdSeccion').val($.trim($('#slSec :selected').text()));
            $('#btnConsultar').prop("disabled",false);
        }
    });
    
    $("#slSec").change(function(){
        if(!$("#slCiclo").val() || !$("#slSec").val()){
            $('#btnConsultar').prop("disabled",true);
        }else{
            $('#hdSeccion').val($.trim($('#slSec :selected').text()));
            $('#btnConsultar').prop("disabled",false);
        }
    });
    
    function getCiclosAjax(){
        $.post('/EPS/ajax/getCiclosAjax',
               'tipo=' + $("#slTipos").val(),
               function(datos){
                    $("#slCiclo").html('');
                    if(datos.length>0){
                        $("#slCiclo").append('<option value="">-- Ciclo --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slCiclo").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slCiclo").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
} );