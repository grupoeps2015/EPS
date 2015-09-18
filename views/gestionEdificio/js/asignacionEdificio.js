$(document).ready(function(){  
    
    $('#divAsignacion').css("display", "block");
    
     $('#frAsignacion').validate({
        rules:{
            slCentros:{
                required: true
            },
            slJornadas:{
                required: true
            }
        },
        messages:{
            slCentros:{
                required: "Es necesario seleccionar un centro unidad."
            },
            slJornadas:{
                required: "Es necesario seleccionar una jornada."
            }
        }
    }); 
    
     $("#slCentros").change(function(){
        if(!$("#slCentros").val()){
            $("#slCentros").html('');
            $("#slCentros").append('<option value="" disabled>-- Centros --</option>')
        }else{
            getUnidadesAjax();
        }
    });
    
    function getUnidadesAjax(){
        $.post('/EPS/ajax/getUnidades',
               'Unidad=' + $("#slUnidades").val(),
               function(datos){
                    
                    if(datos.length>0){
                        $("#slUnidades").html('');
                        for(var i =0; i < datos.length; i++){
                            $("#slUnidades").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slUnidades").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }    
});

