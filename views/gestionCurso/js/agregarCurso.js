$(document).ready(function(){
    $('#frCursos').validate({
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
                required: "Ingrese el código del curso"
            },
            txtNombre:{
                required: "Ingrese el nombre del curso"
            }
        }
    });
});

