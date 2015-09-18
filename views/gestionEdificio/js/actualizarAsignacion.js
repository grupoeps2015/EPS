$(document).ready(function(){
    $('#frAsignacion').validate({
        rules:{
            slCentroUnidadAcademica:{
                required: true
            },
            slJornadas:{
                required: true
            }
        },
        messages:{
            slCentroUnidadAcademica:{
                required: "Es necesario seleccionar un centro unidad."
            },
            slJornadas:{
                required: "Es necesario seleccionar una jornada."
            }
        }
    });
});

