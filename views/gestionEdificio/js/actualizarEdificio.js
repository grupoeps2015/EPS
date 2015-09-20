$(document).ready(function(){
    $('#frEdificio').validate({
        rules:{
            txtNombre:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Es necesario ingresar un nombre."
            }
        }
    });
});

