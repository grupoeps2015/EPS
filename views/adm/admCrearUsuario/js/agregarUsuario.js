
$(document).ready(function(){
    
    $('#divEstudiantes').css("display", "none");
    $('#divEmpleados').css("display", "none");
    $('#divCatedraticos').css("display", "none");
    
    $('#frEstudiantes').validate({
        rules:{
            txtCarnetEst:{
                required: true
            },
            txtNombreEst1:{
                required: true
            },
            txtApellidoEst1:{
                required: true
            },
            txtCorreoEst:{
                required: true
            }
        },
        messages:{
            txtCarnetEst:{
                required: "Ingrese el carnet del estudiante"
            },
            txtNombreEst1:{
                required: "Es necesario ingresar al menos el primer nombre"
            },
            txtApellidoEst1:{
                required: "Ingresar el primer apellido del estudiante"
            },
            txtCorreoEst:{
                required: "El email del estudiante es un dato requerido"
            }
        }
    });
    
    $('#frCatedraticos').validate({
        rules:{
            txtCodigoCat:{
                required: true
            },
            txtNombreCat1:{
                required: true
            },
            txtApellidoCat1:{
                required: true
            },
            txtCorreoCat:{
                required: true
            }
        },
        messages:{
            txtCodigoCat:{
                required: "Ingrese el codigo del catedratico"
            },
            txtNombreCat1:{
                required: "Es necesario ingresar al menos el primer nombre"
            },
            txtApellidoCat1:{
                required: "Ingresar el primer apellido del catedratico"
            },
            txtCorreoCat    :{
                required: "El email del catedratico es un dato requerido"
            }
        }
    });
    
    $('#frEmpleados').validate({
        rules:{
            txtCodigoEmp:{
                required: true
            },
            txtNombreEmp1:{
                required: true
            },
            txtApellidoEmp1:{
                required: true
            },
            txtCorreoEmp:{
                required: true
            }
        },
        messages:{
            txtCodigoEmp:{
                required: "Ingrese el codigo del empleado"
            },
            txtNombreEmp1:{
                required: "Es necesario ingresar al menos el primer nombre"
            },
            txtApellidoEmp1:{
                required: "Ingresar el primer apellido del empleado"
            },
            txtCorreoEmp:{
                required: "El email del empleado es un dato requerido"
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

