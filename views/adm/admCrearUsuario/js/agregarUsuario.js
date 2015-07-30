
$(document).ready(function(){
    $('#frEstudiantes').validate({
        rules:{
            txtNombre:{
                required: true
            },
            txtCorreo:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Nombre es un campo obligatorio"
            },
            txtCorreo:{
                required: "Email es un campo obligatorio"
            }
        }
    });
});