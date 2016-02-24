$(document).ready(function(){
    
    $('#frExtensiones').validate({
        rules:{
            txtNombre:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Ingrese el nombre de la extensión"
            }
        }
    });
    
});