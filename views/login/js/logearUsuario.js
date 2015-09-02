$(document).ready(function(){
        
    $('#frLogin').validate({
        rules:{
            usuario:{
                required: true,
                //min: 1000000,
                maxlength: 9
            },
            pass:{
                required: true
            }
        },
        messages:{
            usuario:{
                required: "Ingrese su id de usuario (carnet/codigo)",
                //min: "El usuario contine al menos 7 digitos",
                maxlength: "El usuario no es mayor a 9 digitos"
            },
            pass:{
                required: "Es necesario ingresar su password"
            }
        }
    });
    
    $("#aEstudiante").click(function() {
        $("#tipo").val("1");
//        $("#radios").css("display","none");
    });
    
    $("#aCatedratico").click(function() {
        $("#tipo").val("2");
//        $("#radios").css("display","none");
    });
    
    $("#aEmpleado").click(function() {
        $("#tipo").val("3");
//        $("#radios").css("display","block");
    });
    
//    $("#radios").click(function(){
//       var i = $("input[name=rbTipo]:checked").val();
//       $("#tipo").val(i);
//    });
});

