
$(document).ready(function(){
    
    $('#divEstudiantes').css("display", "none");
    $('#divEmpleados').css("display", "none");
    $('#divCatedraticos').css("display", "none");
    
    $('#frEstudiantes').validate({
        rules:{
            txtCarnetEst:{
                required: true,
                min: 1000000,
                maxlength: 9
            },
            txtNombreEst1:{
                required: true
            },
            txtApellidoEst1:{
                required: true
            },
            txtCorreoEst:{
                required: true,
                email: true
            }
        },
        messages:{
            txtCarnetEst:{
                required: "Ingrese el carnet del estudiante",
                min: "El numero de carnet contiene como minimo 7 digitos",
                maxlength: "El numero de carnet contiene como maximo 9 digitos"
            },
            txtNombreEst1:{
                required: "Es necesario ingresar al menos el primer nombre"
            },
            txtApellidoEst1:{
                required: "Ingresar el primer apellido del estudiante"
            },
            txtCorreoEst:{
                required: "El email del estudiante es un dato requerido",
                email: "El formato para email es invalido"
            }
        }
    });
    
    $('#frCatedraticos').validate({
        rules:{
            txtCodigoCat:{
                required: true,
                min: 1000000,
                maxlength: 9
            },
            txtNombreCat1:{
                required: true
            },
            txtApellidoCat1:{
                required: true
            },
            txtCorreoCat:{
                required: true,
                email: true
            }
        },
        messages:{
            txtCodigoCat:{
                required: "Ingrese el codigo del catedratico",
                min: "El numero de registro personal contiene como minimo 7 digitos",
                maxlength: "El numero de registro personal contiene como maximo 9 digitos"
            },
            txtNombreCat1:{
                required: "Es necesario ingresar al menos el primer nombre"
            },
            txtApellidoCat1:{
                required: "Ingresar el primer apellido del catedratico"
            },
            txtCorreoCat    :{
                required: "El email del catedratico es un dato requerido",
                email: "El formato para email es invalido"
            }
        }
    });
    
    $('#frEmpleados').validate({
        rules:{
            txtCodigoEmp:{
                required: true,
                min: 1000000,
                maxlength: 9
            },
            txtNombreEmp1:{
                required: true
            },
            txtApellidoEmp1:{
                required: true
            },
            txtCorreoEmp:{
                required: true,
                email: true
            }
        },
        messages:{
            txtCodigoEmp:{
                required: "Ingrese el codigo del empleado",
                min: "El numero de registro personal contiene como minimo 7 digitos",
                maxlength: "El numero de registro personal contiene como maximo 9 digitos"
            },
            txtNombreEmp1:{
                required: "Es necesario ingresar al menos el primer nombre"
            },
            txtApellidoEmp1:{
                required: "Ingresar el primer apellido del empleado"
            },
            txtCorreoEmp:{
                required: "El email del empleado es un dato requerido",
                email: "El formato para email es invalido"
            }
        }
    });
    
    $("#txtFotoEmp").change(function() {
        var imgVal = $('#txtFotoEmp').val();
        if(imgVal == ""){
            $('#divFotoEmp').removeClass("btn-success");
            $('#divFotoEmp').addClass("btn-warning");
            span = document.getElementById("myspan");
            txt = document.createTextNode("Cargar Imagen");
            span.innerText = txt.textContent;
        }else{
            $('#divFotoEmp').removeClass("btn-warning");
            $('#divFotoEmp').addClass("btn-success");
            span = document.getElementById("spanEmp");
            txt = document.createTextNode("Imagen Cargada");
            span.innerText = txt.textContent;
        }
    });
    
    $("#txtFotoCat").change(function() {
        var imgVal = $('#txtFotoCat').val();
        if(imgVal == ""){
            $('#divFotoCat').removeClass("btn-success");
            $('#divFotoCat').addClass("btn-warning");
            span = document.getElementById("myspan");
            txt = document.createTextNode("Cargar Imagen");
            span.innerText = txt.textContent;
        }else{
            $('#divFotoCat').removeClass("btn-warning");
            $('#divFotoCat').addClass("btn-success");
            span = document.getElementById("spanCat");
            txt = document.createTextNode("Imagen Cargada");
            span.innerText = txt.textContent;
        }
    });
    
    $("#txtFotoEst").change(function() {
        var imgVal = $('#txtFotoEst').val();
        if(imgVal == ""){
            $('#divFotoEst').removeClass("btn-success");
            $('#divFotoEst').addClass("btn-warning");
            span = document.getElementById("myspan");
            txt = document.createTextNode("Cargar Imagen");
            span.innerText = txt.textContent;
        }else{
            $('#divFotoEst').removeClass("btn-warning");
            $('#divFotoEst').addClass("btn-success");
            span = document.getElementById("spanEst");
            txt = document.createTextNode("Imagen Cargada");
            span.innerText = txt.textContent;
        }
    });
    
    $("#slPerfil").change(function() {
        var str = "";
        $( "#slPerfil option:selected" ).each(function() {
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

