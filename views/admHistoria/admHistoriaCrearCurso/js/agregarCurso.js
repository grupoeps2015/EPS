
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
            txtCarnetEst:{
                required: "Ingrese el código del curso"
            },
            txtNombreEst1:{
                required: "Ingrese el nombre del curso"
            }
        }
    });
});

