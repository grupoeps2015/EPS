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
    
});