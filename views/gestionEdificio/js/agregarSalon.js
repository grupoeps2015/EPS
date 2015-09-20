$(document).ready( function () {
    $('#frSalones').validate({
        rules:{
            txtNombre:{
                required: true
            },
            txtNivel:{
                required: true
            },
            txtCapacidad:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Es necesario ingresar el nombre del salón."
            },
            txtNivel:{
                required: "Es necesario ingresar el nivel en donde se encuentra el salón."
            },
            txtCapacidad:{
                required: "Es necesario ingresar la capacidad del salón."
            }
        }
    }); 
} );