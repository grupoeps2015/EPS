$(document).ready(function(){
    $('#frSecciones').validate({
        rules:{
            txtNombre:{
                required: true
            }
        },
        messages:{
            txtNombre:{
                required: "Ingrese el nombre de la sección"
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

