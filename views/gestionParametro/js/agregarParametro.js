$(document).ready(function(){
    
    $('#divParametros').css("display", "block");
    
    $('#frParametros').validate({
        rules:{
            txtNombreParametro:{
                required: true
            },
            txtValorParametro:{
                required: true
            },
            txtDescripcionParametro:{
                required: true
            },
            txtCodigoParametro:{
                required: false
            },
            slCentroUnidadAcademica:{
                required: true
            },
            slTipoParametro:{
                required: true
            }
        },
        messages:{
            txtNombreParametro:{
                required: "Es necesario ingresar el nombre del parámetro."
            },
            txtValorParametro:{
                required: "Es necesario ingresar el valor del parámetro."
            },
            txtDescripcionParametro:{
                required: "Es necesario ingresar la descripción del parámetro."
            },
            slCentroUnidadAcademica:{
                required: "Elija un centro y unidad académica."
            },
            slTipoParametro:{
                required: "Elija un tipo de parámetro."
            }
        }
    }); 
    
    $("#slCentroUnidadAcademica").change(function(){        
       if(!$("#slCentroUnidadAcademica").val()){
            $("#slCarreras").html('');
            $("#slCarreras").append('<option value="" disabled>-- Carrera --</option>')
        }else{
            $('#divTabla').css("display","none");
            getCarrerasAjax();
        }
    });
   
    $("#slCarreras").change(function(){
        if(!$("#slCarreras").val()){
        }else{
            getCentroUnidadAjax();
        }
    });
           
    function getCarrerasAjax(){
        $.post('/EPS/ajax/getInfoCarreras',
               'centro_unidadacademica=' + $("#slCentroUnidadAcademica").val(),
               function(datos){
                    $("#slCarreras").html('');
                    if(datos.length>0){
                        $("#slCarreras").append('<option value="">-- Carrera --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slCarreras").append('<option value="' + datos[i].id + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slCarreras").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
        
});

