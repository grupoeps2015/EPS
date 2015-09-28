$(document).ready( function () {
    $('#frmGenerales').validate({
        rules:{
            txtAnio:{
                required: true
            },
            txtCiclo:{
                required: true
            }
        },
        messages:{
            txtAnio:{
                required: "Ingrese el año"
            },
            txtCiclo:{
                required: "Ingrese el número de ciclo"
            }
        }
    });
    
    $("#slAnio").change(function(){
        if(!$("#slAnio").val()){
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
        $.post('../../ajax/getCiclosAjax',
               { anio: $("#slAnio").val() },
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
    
    $('#linkNuevoCic').click(function(){
        getSiguienteCicloAjax();
    });
    
    function getSiguienteCicloAjax(){
        $.post('../../ajax/getSiguienteCicloAjax',
               { tipo: $("#slTipos").val() },
               function(datos){
                    if(datos.length>0){
                        $("#txtAnio").val(datos[0].anio);
                        $("#txtCiclo").val(datos[0].ciclo);
                    }
               },
               'json');
    }
    
} );