$(document).ready(function(){
    
    $('#frSecciones').validate({
        rules:{
            txtNombre:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Ingrese el nombre de la sección"
            }
        }
    });
    
});