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
        }
    });
    
    function getUnidadesAjax(){
        $.post('/EPS/ajax/getUnidadesAjax',
               'centro=' + $("#slCentros").val(),
               function(datos){
                    $("#slUnidad").html('');
                    if(datos.length>0){
                        $("#slUnidad").append('<option value="">-- Seleccione alguna --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slUnidad").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slUnidad").append('<option value="" disabled>No hay informacion disponible</option>' );
                    }
               },
               'json');
    }
} );