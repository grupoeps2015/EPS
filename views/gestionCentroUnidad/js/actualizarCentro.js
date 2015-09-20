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
            }
        }
    });
    
    function getMunicipio(){
        var muniActual =  parseInt($('#hdMunicipio').val());
        $.post('/EPS/ajax/getMunicipio',
               'Depto=' + $("#slDeptos").val(),
               function(datos){
                   $("#slMunis").html('');
                   for(var i =0; i < datos.length; i++){
                       if(muniActual === datos[i].codigo){
                           $("#slMunis").append('<option value="' + datos[i].codigo + '" selected>' + datos[i].nombre + '</option>' );
                       }else{
                           $("#slMunis").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                       }
                   }
               },
               'json');
    }
    
    $("#slDeptos").change(function(){
        if(!$("#slDeptos").val()){
            $("#slMunis").html('');
            $("#slMunis").append('<option value="" disabled>(Seleccione un Municipios)*</option>')
        }else{
            getMunicipio();
        }
    });
    
    getMunicipio();
});

