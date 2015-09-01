
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
            txtExtensionParametro:{
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
            txtExtensionParametro:{
                required: "El necesario ingresar la extensión del parámetro."
            }
        }
    }); 
    
   
        
});

