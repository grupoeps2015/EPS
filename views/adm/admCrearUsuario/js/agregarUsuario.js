
$(document).ready(function(){
    
    $('#divEstudiantes').css("display", "none");
    $('#divEmpleados').css("display", "none");
    $('#divCatedraticos').css("display", "none");
    
    $('#frEstudiantes').validate({
        rules:{
            txtNombre:{
                required: true
            },
            txtCorreo:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Nombre es un campo obligatorio"
            },
            txtCorreo:{
                required: "Email es un campo obligatorio"
            }
        }
    });
    
    $("#slPerfil" ).change(function() {
        var str = "";
        $( "select option:selected" ).each(function() {
            str += $(this).text();
        });
        
        switch(str){
            case "Empleado":
                $('#divEstudiantes').css("display", "none");
                $('#divEmpleados').css("display", "block");
                $('#divCatedraticos').css("display", "none");
                break;
            case "Catedratico":
                $('#divEstudiantes').css("display", "none");
                $('#divEmpleados').css("display", "none");
                $('#divCatedraticos').css("display", "block");
                break;
            case "Estudiante":
                $('#divEstudiantes').css("display", "block");
                $('#divEmpleados').css("display", "none");
                $('#divCatedraticos').css("display", "none");
                break;
            default:
                $('#divEstudiante').css("display", "none");
                $('#divEmpleados').css("display", "none");
                $('#divCatedraticos').css("display", "none");
        }
    });
});

