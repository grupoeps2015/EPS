$(document).ready(function(){
    
    $('#frCarreras').validate({
        rules:{
            txtNombre:{
                required: true
            },
            slExtensiones:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Ingrese el nombre de la carrera"
            },
            slExtensiones:{
                required: "Seleccione una extensión"
            }
        }
    });
    
});