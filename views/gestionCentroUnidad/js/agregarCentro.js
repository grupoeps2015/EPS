$(document).ready(function(){
    
    $('#frCentros').validate({
        rules:{
            slDeptos:{
                required: true
            },
            slMunis:{
                required: true  
            },
            txtZona:{
                required: true,
                min: 0,
                max: 27
            },
            txtDireccion:{
                required: true
            },
            txtNombreCen:{
                required: true
            },
            txtCodigo:{
                required: true,
                max: 99,
                min: 0
            }
        },
        messages:{
            slDeptos:{
                required: "Elija un departamento para elejir un municipio"
            },
            slMunis:{
                required: "Elija un municipio para indicar su direccion"
            },
            txtZona:{
                required: "Ingrese una zona, en caso de no existir, ingrese 0",
                min: "La zona minima permitida es 0",
                max: "La zona maxima permitida es 27"
            },
            txtDireccion:{
                required: "Ingrese una direccion domiciliar"
            },
            txtNombreCen:{
                required: "Ingrese el nombre del centro que va a agregar"
            },
            txtCodigo:{
                required: "Ingrese el codigo del centro universitario",
                max: "El codigo debe ser como maximo 99",
                min: "El codigo debe ser como minimo 0"
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
        var i = parseInt($("#hdFile").val());
        if(i !== 1){
            alert('Debe cargar un archivo');
        }
    });
    
    function getMunicipio(){
        $.post('../ajax/getMunicipio',
               'Depto=' + $("#slDeptos").val(),
               function(datos){
                   $("#slMunis").html('');
                   for(var i =0; i < datos.length; i++){
                       $("#slMunis").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                   }
               },
               'json');
    }
    
    $("#slDeptos").change(function(){
        if(!$("#slDeptos").val()){
            $("#slMunis").html('');
            $("#slMunis").append('<option value="" disabled>- Municipios -</option>')
        }else{
            getMunicipio();
        }
    });
});