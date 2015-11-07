$(document).ready(function(){
    $('#frCarreras').validate({
        rules:{
            txtCodigo:{
                required: true
            },
            txtNombre:{
                required: true
            }
        },
        messages:{
            txtCodigo:{
                required: "Ingrese el código de la carrera"
            },
            txtNombre:{
                required: "Ingrese el nombre de la carrera"
            }
        }
    });

});

