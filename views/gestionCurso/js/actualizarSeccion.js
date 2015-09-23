$(document).ready(function(){
    
    $('#frSecciones').validate({
        rules:{
            txtNombre:{
                required: true
            },
            slTiposSeccion:{
                required: true
            },
            slCursos:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Ingrese el nombre de la sección"
            },
            slTiposSeccion:{
                required: "Seleccione un tipo de sección"
            },
            slCursos:{
                required: "Seleccione un curso"
            }
        }
    });
    
});