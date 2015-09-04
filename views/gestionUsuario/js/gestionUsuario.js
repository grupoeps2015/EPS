$(document).ready( function () {
    
    $('#tbUsuarios').DataTable();
    
    $("#slCentros").change(function(){
        if(!$("#slCentros").val()){
            $("#slUnidad").html('');
            $("#slUnidad").append('<option value="" disabled>-- Unidad Acad&eacute;mica --</option>')
        }else{
            getUnidadesAjax();
        }
    });
    
    $("#slUnidad").change(function(){
        if(!$("#slUnidad").val()){
            $('#divTabla').css("display","none");
        }else{
            $('#divTabla').css("display","block");
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