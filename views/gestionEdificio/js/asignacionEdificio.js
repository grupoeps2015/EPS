$(document).ready(function(){  
    
    $('#divAsignacion').css("display", "block");
    
     $('#frAsignacion').validate({
        rules:{
            slCentros:{
                required: true
            },
            slJornadas:{
                required: true
            }
        },
        messages:{
            slCentros:{
                required: "Es necesario seleccionar un centro unidad."
            },
            slJornadas:{
                required: "Es necesario seleccionar una jornada."
            }
        }
    });
});

