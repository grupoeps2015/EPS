$(document).ready(function(){
    $('#frCarreras').validate({
        rules:{
            txtNombre:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Ingrese el nombre de la carrera"
            }
        }
    });
    
    $("#slTiposPeriodos").change(function(){
        if(!$("#slTiposPeriodos").val()){
            $("#slPeriodos").html('');
            $("#slPeriodos").append('<option value="" disabled>-- Período --</option>')
        }else{
            getPeriodosAjax();
        }
    });
    
    function getPeriodosAjax(){
        $.post('/EPS/ajax/getPeriodosAjax',
               'tipo=' + $("#slTiposPeriodos").val(),
               function(datos){
                    
                    if(datos.length>0){
                        $("#slPeriodos").html('');
                        for(var i =0; i < datos.length; i++){
                            $("#slPeriodos").append('<option value="' + datos[i].codigo + '">' + datos[i].minutos + ' minutos</option>' );
                        }
                    }else{
                        $("#slPeriodos").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    $("#slEdificios").change(function(){
        if(!$("#slEdificios").val()){
            $("#slSalones").html('');
            $("#slSalones").append('<option value="" disabled>-- Salón --</option>')
        }else{
            getSalonesAjax();
        }
    });
    
    function getSalonesAjax(){
        $.post('/EPS/ajax/getSalonesAjax',
               'edificio=' + $("#slEdificios").val(),
               function(datos){
                    
                    if(datos.length>0){
                        $("#slSalones").html('');
                        for(var i =0; i < datos.length; i++){
                            $("#slSalones").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slSalones").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
});

