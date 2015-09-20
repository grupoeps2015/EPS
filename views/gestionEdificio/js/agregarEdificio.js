$(document).ready( function () {
    $('#frEdificios').validate({
        rules:{
            txtNombre:{
                required: true
            },
            txtDescripcion:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Es necesario ingresar el nombre del edificio."
            },
            txtDescripcion:{
                required: "Es necesario ingresar la descripción del edificio."
            }
        }
    }); 
} );