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

