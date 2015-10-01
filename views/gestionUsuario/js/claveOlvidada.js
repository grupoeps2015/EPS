$(document).ready(function(){
    var passValido = false;
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
        
    $('#btnBuscar').click(function(){
        var id = parseInt($('#txtId').val());
        spAviso.innerText="";
        if(id < 1000000 || id > 299999999 || !$('#txtId').val()){
            spErrorId.innerText = "El número de carnet/registro no es correcto";
            $('#tbInfoUsr').css("display","none");
        }else{
            spErrorId.innerText = "";
            obtenerInfo(id);
        }
    });
    
    $('#btnCambiar').click(function(){
        var clave1 = $('#txtPasswordNuevo').val();
        var clave2 = $('#txtPasswordNuevo2').val();
        var respuesta = $('#txtRespuesta').val();
        var claveAceptada = false;
        var preguntaAceptada = false;
        
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
        
        if(respuesta === ""){
            spErrorPregunta.innerText = "Ingrese una respuesta";
        }else{
            spErrorPregunta.innerText = "";
            preguntaAceptada = true;
        }
        
        if(claveAceptada && preguntaAceptada){
            $('#frmValidar').submit();
        }
    });
    
    function obtenerInfo(id){
        var estado = 0;
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getEstadoUsuario',
               'idUsuario=' + id,
               function(datos){
                   if(datos.length>0){
                       estado = parseInt(datos[0].estado);
                       if(estado === 0){
                           //usuario pendiente de validacion
                           spErrorId.innerText = "El usuario esta pendiente de activación, verifique su correo eléctronico para mas información o dirigase a la oficina de control académico";
                           spPregunta.innerText = "";
                           $('#tbInfoUsr').css("display","none");
                       }else if(estado === -1){
                          //usuario desactivado
                          spPregunta.innerText = "";
                          spErrorId.innerText = "El usuario solicitado no se encuentra activado, contacte a un administrador o diríjase a la oficina de control académico";
                          $('#tbInfoUsr').css("display","none");
                       }else if(estado === 1){
                           //usuario activado
                           spPregunta.innerText = datos[0].pregunta;
                           $('#tbInfoUsr').css("display","block");
                           $('#hdEnvio').val(id);
                       }else{
                           //estado desconocido
                           spPregunta.innerText = "";
                           spErrorId.innerText = "El usuario solicitado no existe en el sistema";
                           $('#tbInfoUsr').css("display","none");
                       }
                   }else{
                       spErrorId.innerText = "El usuario solicitado no existe en el sistema";
                       $('#tbInfoUsr').css("display","none");
                   }
               },
               'json');
    }
    
});