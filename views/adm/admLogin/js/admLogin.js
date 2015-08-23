$(document).ready(function(){
    $('#frLogin').validate({
        rules:{
            usuario:{
                required: true
            },
            pass:{
                required: true
            }
        },
        messages:{
            usuario:{
                required: "Ingrese su codigo de empleado"
            },
            pass:{
                required: "Ingrese su password"
            }
        }
    });
});