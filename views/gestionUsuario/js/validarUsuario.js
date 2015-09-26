$(document).ready(function(){
    
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
                bltotal=false;
            } else {
                $('#total').removeClass('passInvalid').addClass('passValid');
                bltotal=true;
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
        });
    
    $('#frmValidar').validate({
        rules:{
            slDeptos:{
                required: true
            },
            selMunis:{
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
            txtTelefono:{
                required: true,
                min: 22000000,
                max: 99999999
            },
            slPaises:{
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
            txtTelefono:{
                required: "Ingrese un numero telefonico sin guiones",
                min: "El numero de telefono debe tener solo 8 digitios",
                max: "El numero de telefono debe tener solo 8 digitios"
            },
            slPaises:{
                required: "Ingrese un pais para indicar nacionalidad"
            }
        }
    });
    
    $('#btnContinuar1').click(function(){
        var clave1 = $('#txtPasswordNuevo').val();
        var clave2 = $('#txtPasswordNuevo2').val();
        var respuesta = $('#txtRespuesta').val();
        var claveAceptada = false;
        var correoAceptado = false;
        var preguntaAceptada = false;
        
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if(!$('#txtCorreo').val()){
            spErrorCorreo.innerText = "Debe ingresar una direccion de correo";
        }else{
            if (regex.test($('#txtCorreo').val().trim())) {
                spErrorCorreo.innerText = "";
                correoAceptado = true;
            }else{
                spErrorCorreo.innerText = "El correo ingresado no es valido";
            }
        }
        
        if(clave1 === "" || clave2 === ""){
            spErrorClave.innerText = "Debe ingresar una clave de acceso y confirmarla";
        }else{
            if(passValido){
                if(clave1 !== clave2){
                    spErrorClave.innerText = "Las claves ingresadas no coinciden";
                }else{
                    spErrorClave.innerText = "";
                    claveAceptada = true;
                }
            }else{
                spErrorClave.innerText = "La clave no cumple con todos los requisitos";
            }
        }
        
        if(!$('#slPregunta').val()){
            spErrorPregunta.innerText = "Seleccione una pregunta secreta";
        }else{
            if(respuesta === ""){
                spErrorPregunta.innerText = "Ingrese una respuesta";
            }else{
                spErrorPregunta.innerText = "";
                preguntaAceptada = true;
            }
        }
        
        if(claveAceptada && preguntaAceptada && correoAceptado){
            $('#divGenerales').css("display", "none");
            $('#divEspecificos').css("display", "block");
            if($('#hdRol').val() == "1"){
                $('#divEmergencia').css("display", "block");
            }else{
                $('#divBotones').removeClass("col-md-8");
                $('#divBotones').addClass("col-md-6");
                $('#divEspecificos').removeClass("col-md-offset-2");
                $('#divEspecificos').addClass("col-md-offset-4");
                $('#divBotones').removeClass("col-md-offset-2");
                $('#divBotones').addClass("col-md-offset-3");
            }
            $('#divBotones').css("display", "block");
        }
    });
    
    $('#btnRegresar1').click(function(){
        $('#divGenerales').css("display", "block");
            $('#divEspecificos').css("display", "none");
            $('#divEmergencia').css("display", "none");
            $('#divBotones').css("display", "none");
    });
    
    $('#slPregunta').change(function(){
        if(!$("#slPregunta").val()){
            $('#txtRespuesta').prop("disabled",true);
            $('#txtRespuesta').attr("placeholder", "");
        }else{
            $('#txtRespuesta').prop("disabled",false);
            $('#txtRespuesta').attr("placeholder", "Escriba su Respuesta")
        }
    });
    
    function getMunicipio(){
        $.post('../../ajax/getMunicipio',
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