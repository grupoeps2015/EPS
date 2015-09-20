$(document).ready(function(){
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
                required: "Es necesario ingresar un nombre."
            },
            txtNivel:{
                required: "Es necesario indicar el nivel en donde se encuentra el salón."
            },
            txtCapacidad:{
                required: "Es necesario indicar la capacidad."
            }
        }
    });
});

