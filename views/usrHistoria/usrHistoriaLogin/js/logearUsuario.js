$(document).ready(function(){

    
//    $('#frEstudiantes').validate({
//        rules:{
//            txtCarnetEst:{
//                required: true
//            },
//            txtNombreEst1:{
//                required: true
//            },
//            txtApellidoEst1:{
//                required: true
//            },
//            txtCorreoEst:{
//                required: true
//            }
//        },
//        messages:{
//            txtCarnetEst:{
//                required: "Ingrese el carnet del estudiante"
//            },
//            txtNombreEst1:{
//                required: "Es necesario ingresar al menos el primer nombre"
//            },
//            txtApellidoEst1:{
//                required: "Ingresar el primer apellido del estudiante"
//            },
//            txtCorreoEst:{
//                required: "El email del estudiante es un dato requerido"
//            }
//        }
//    });
    
    
    $("#aEstudiante").click(function() {
        $("#tipo").val("1");
    });
    $("#aCatedratico").click(function() {
        $("#tipo").val("2");
    });
});

