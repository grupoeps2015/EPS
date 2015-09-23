$(document).ready(function(){
    
    $('#frCursos').validate({
        rules:{
            txtCodigo:{
                required: true
            },
            txtNombre:{
                required: true
            },
            slTiposCurso:{
                required: true
            },
            slTraslape:{
                required: true
            }
        },
        messages:{
            txtCodigo:{
                required: "Ingrese el código del curso"
            },
            txtNombre:{
                required: "Ingrese el nombre del curso"
            },
            slTiposCurso:{
                required: "Seleccione un tipo de curso"
            },
            slTraslape:{
                required: "Seleccione el traslape"
            }
        }
    });
    
});