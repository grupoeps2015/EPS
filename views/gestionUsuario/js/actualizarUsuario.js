$(document).ready(function(){    
    var passValido = false;
    
    $('#txtPassword')
        .focus(function(){
            $('#txtPasswordNuevo').prop("disabled",false);
            $('#txtPasswordNuevo2').prop("disabled",false);
        })
        .blur(function(){
            if(!$("#txtPassword").val()){
                $('#txtPasswordNuevo').prop("disabled",true);
                $('#txtPasswordNuevo2').prop("disabled",true);    
            }
        }
    );
    
    $('#txtPasswordNuevo')
        .keyup(function() {
            var pswd = $('#txtPasswordNuevo').val();
            var bltotal = false;
            var blletra = false;
            var blmayus = false;
            var blnum = false;
            //verifica longitud
            if ( pswd.length < 8 ) {
                $('#total').removeClass('passValid').addClass('passInvalid');
                bltotal=true;
            } else {
                $('#total').removeClass('passInvalid').addClass('passValid');
                bltotal=false;
            }
            
            //verifica que tenga una letra
            if ( pswd.match(/[A-z]/) ) {
                $('#letra').removeClass('passInvalid').addClass('passValid');
                blletra=true;
            } else {
                $('#letra').removeClass('passValid').addClass('passInvalid');
                blletra = false;
            }
            
            //verifica que tenga una mayuscula
            if ( pswd.match(/[A-Z]/) ) {
                $('#mayus').removeClass('passInvalid').addClass('passValid');
                blmayus=true;
            } else {
                $('#mayus').removeClass('passValid').addClass('passInvalid');
                blmayus=false;
            }
            
            //verifica que tenga un numero
            if ( pswd.match(/\d/) ) {
                $('#numero').removeClass('passInvalid').addClass('passValid');
                blnum=true;
            } else {
                $('#numero').removeClass('passValid').addClass('passInvalid');
                blnum= false;
            }
            
            if(bltotal && blletra && blmayus && blnum){
                passValido = true;
            }else{
                passValido = false;
            }
        })
        .focus(function() {
            $('#passInfo').show();
        })
        .blur(function() {
            $('#passInfo').hide();
        }
    );
    
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
        $.post('../../ajax/getCarreras',
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

