$(document).ready(function(){
    $('#frArea').validate({
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
                required: "Es necesario ingresar el nombre del Area."
            },
            txtDescripcion:{
                required: "Es necesario ingresar la descripción del Area."
            }
        }
    });
});

