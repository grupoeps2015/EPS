$(document).ready(function(){
    
    $('#frmUsuario').validate({
        rules:{
            txtNombre:{
                required: true
            },
            txtCorreo:{
                required: true,
                email: true
            },
            slPregunta:{
                required: true
            },
            txtRespuesta:{
                required: true                
            }
        },
        messages:{
            txtNombre:{
                required: "Ingresa el nombre del usuario"
            },
            txtCorreo:{
                required: "Debes ingresar un email para el usuario",
                email:"El formato para email es invalido"
            },
            slPregunta:{
                required: "Debes seleccionar una pregunta"
            },
            txtRespuesta:{
                required: "Debes ingresar una respuesta",
               
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