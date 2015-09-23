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
    
    $("#csvFile").change(function(){
        var path = $('#csvFile').val();
        if(path == ""){
            $('#hdFile').val("0");
            $('#divcsvFile').removeClass("btn-success");
            $('#divcsvFile').addClass("btn-warning");
        }else{
            //archivo de cursos cargado con exito
            $('#hdFile').val("1");
            $('#divcsvFile').removeClass("btn-warning");
            $('#divcsvFile').addClass("btn-success");
        }
    });
    
    $("#btnCargar").click(function(){
        var i = $("#hdFile").val();
        if(i == "1"){
            
        }else{
            alert('Debe cargar un archivo');
        }
    });
});

