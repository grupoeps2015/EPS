$(document).ready(function(){
    
    $('#frmGenerales').validate({
        rules:{
            slDeptos:{
                required: true
            },
            selMunis:{
                required: true  
            },
            txtZona:{
                required: true,
                min: 0,
                max: 27
            },
            txtDireccion:{
                required: true
            },
            txtTelefono:{
                required: true,
                min: 22000000,
                max: 99999999
            },
            slPaises:{
                required: true
            }
        },
        messages:{
            slDeptos:{
                required: "Elija un departamento para elejir un municipio"
            },
            slMunis:{
                required: "Elija un municipio para indicar su direccion"
            },
            txtZona:{
                required: "Ingrese una zona, en caso de no existir, ingrese 0",
                min: "La zona minima permitida es 0",
                max: "La zona maxima permitida es 27"
            },
            txtDireccion:{
                required: "Ingrese una direccion domiciliar"
            },
            txtTelefono:{
                required: "Ingrese un numero telefonico sin guiones",
                min: "El numero de telefono debe tener solo 8 digitios",
                max: "El numero de telefono debe tener solo 8 digitios"
            },
            slPaises:{
                required: "Ingrese un pais para indicar nacionalidad"
            }
        }
    });
    
    function getMunicipio(){
        $.post('/EPS/ajax/getMunicipio',
               'Depto=' + $("#slDeptos").val(),
               function(datos){
                   $("#slMunis").html('');
                   for(var i =0; i < datos.length; i++){
                       $("#slMunis").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                   }
               },
               'json');
    }
    
    $("#slDeptos").change(function(){
        if(!$("#slDeptos").val()){
            $("#slMunis").html('');
            $("#slMunis").append('<option value="" disabled>- Municipios -</option>')
        }else{
            getMunicipio();
        }
    });
    
});