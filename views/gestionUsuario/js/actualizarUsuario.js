$(document).ready(function(){
    
    $('#slPregunta').change(function(){
        if(!$("#slPregunta").val()){
            $('#txtRespuesta').prop("disabled",true);
            $('#txtRespuesta').attr("placeholder", "");
        }else{
            $('#txtRespuesta').prop("disabled",false);
            $('#txtRespuesta').attr("placeholder", "Escriba su Respuesta")
        }
    });
    
    $('#frmUsuario').validate({
        rules:{
            txtCorreo:{
                required: true,
                email: true
            }
        },
        messages:{
            txtCorreo:{
                required: "Debes ingresar un email para el usuario",
                email:"El formato para email es invalido"
            }
        }
    });
    
    $("#slUnidadAcademica").change(function(){
        if(!$("#slUnidadAcademica").val()){
            $("#slCarreras").html('');
            $("#slCarreras").append('<option value="" disabled>- carreras -</option>')
        }else{
            getCarreras();
        }
    });
    
    function getCarreras(){
        $.post('/EPS/ajax/getCarreras',
               'carr=' + $("#slUnidadAcademica").val(),
               function(datos){
                   $("#slCarreras").html('');
                   for(var i =0; i < datos.length; i++){
                       $("#slCarreras").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                   }
               },
               'json');
    }
    
});

