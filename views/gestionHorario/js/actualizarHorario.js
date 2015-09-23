$(document).ready(function(){
    $('#frCarreras').validate({
        rules:{
            txtMinutoInicial:{
                required: true
            },
            txtMinutoFinal:{
                required: true
            },
            txtHoraInicial:{
                required: true
            },
            txtHoraFinal:{
                required: true
            },
            slCatedraticos:{
                required: true
            },
            slDias:{
                required: true
            },
            slEdificios:{
                required: true
            },
            slSalones:{
                required: true
            },
            slJornadas:{
                required: true
            },
            slTiposPeriodos:{
                required: true
            },
            slPeriodos:{
                required: true
            }
        },
        messages:{
            txtMinutoInicial:{
                required: "Ingrese los minutos"
            },
            txtMinutoFinal:{
                required: "Ingrese los minutos"
            },
            txtHoraInicial:{
                required: "Ingrese la hora"
            },
            txtHoraFinal:{
                required: "Ingrese la hora"
            },
            slCatedraticos:{
                required: "Seleccione un catedrático"
            },
            slDias:{
                required: "Seleccione un día"
            },
            slEdificios:{
                required: "Seleccione un edificio"
            },
            slSalones:{
                required: "Seleccione un salón"
            },
            slJornadas:{
                required: "Seleccione una jornada"
            },
            slTiposPeriodos:{
                required: "Seleccione un tipo de período"
            },
            slPeriodos:{
                required: "Seleccione un período"
            }
        }
    });
    
    $("#slTiposPeriodos").change(function(){
        if(!$("#slTiposPeriodos").val()){
            $("#slPeriodos").html('');
            $("#slPeriodos").append('<option value="" disabled>-- Período --</option>')
        }else{
            getPeriodosAjax();
        }
    });
    
    function getPeriodosAjax(){
        $.post('/EPS/ajax/getPeriodosAjax',
               'tipo=' + $("#slTiposPeriodos").val(),
               function(datos){
                    
                    if(datos.length>0){
                        $("#slPeriodos").html('');
                        $("#slPeriodos").append('<option value="">(Seleccione)</option>');
                        for(var i =0; i < datos.length; i++){
                            $("#slPeriodos").append('<option value="' + datos[i].codigo + '">' + datos[i].minutos + ' minutos</option>' );
                        }
                    }else{
                        $("#slPeriodos").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    $("#slEdificios").change(function(){
        if(!$("#slEdificios").val()){
            $("#slSalones").html('');
            $("#slSalones").append('<option value="" disabled>-- Salón --</option>')
        }else{
            getSalonesAjax();
        }
    });
    
    function getSalonesAjax(){
        $.post('/EPS/ajax/getSalonesAjax',
               'edificio=' + $("#slEdificios").val(),
               function(datos){
                    
                    if(datos.length>0){
                        $("#slSalones").html('');
                        for(var i =0; i < datos.length; i++){
                            $("#slSalones").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slSalones").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    $("#txtMinutoInicial,#txtHoraInicial,#slPeriodos,#slTiposPeriodos").change(function(){
        var minutosArreglados = parseInt($("#txtMinutoInicial").val()) < 10 ? '0' + parseInt($("#txtMinutoInicial").val()) : parseInt($("#txtMinutoInicial").val());
        $("#txtMinutoInicial").val(minutosArreglados);
        var horasArregladas = parseInt($("#txtHoraInicial").val()) < 10 ? '0' + parseInt($("#txtHoraInicial").val()) : parseInt($("#txtHoraInicial").val());
        $("#txtHoraInicial").val(horasArregladas);
        if($("#txtHoraInicial").val() && $("#txtMinutoInicial").val() && $("#slPeriodos").val()){
            var minutosPeriodo = parseInt($("#slPeriodos option:selected").text());
            var minutosIngresados = parseInt($("#txtHoraInicial").val()) * 60 + parseInt($("#txtMinutoInicial").val());
            var minutosFinal = parseInt(minutosPeriodo) + parseInt(minutosIngresados);
            var horas = Math.floor( minutosFinal / 60 );
            var minutos = minutosFinal % 60;
 
            //Anteponiendo un 0 a las horas si son menos de 10 
            horas = horas < 10 ? '0' + horas : horas;
 
            //Anteponiendo un 0 a los minutos si son menos de 10 
            minutos = minutos < 10 ? '0' + minutos : minutos;

            var result = horas + ":" + minutos;
            $("#txtHoraFinal").val(horas);
            $("#txtMinutoFinal").val(minutos);
        }else{
            $("#txtHoraFinal").val("");
            $("#txtMinutoFinal").val("");
        }
    });
    
    $('#btnActualizarHor').click(function(){
        if (getDisponibilidadSalonAjax()){
            if (getDisponibilidadCatedraticoAjax()){
                $('#frCarreras').submit();
            }
            else{
                alert("Imposible guardar: El catedrático se encuentra ocupado en el horario indicado.");
            }
        }
        else{
            alert("Imposible guardar: El salón se encuentra ocupado en el horario indicado.");
        }
    });
    
    function getDisponibilidadSalonAjax(){
        var cadena = false;
        var ciclo = $('#slCiclo').val();
        var salon = $('#slSalones').val();
        var dia = $('#slDias').val();
        var inicio = $("#txtHoraInicial").val()+":"+$("#txtMinutoInicial").val();
        var fin = $("#txtHoraFinal").val()+":"+$("#txtMinutoFinal").val();
        if(ciclo && salon && dia && inicio && fin){
            $.ajax({
              type: "POST",
              url: '/EPS/ajax/getDisponibilidadSalonAjax',
              data: {ciclo:ciclo, salon:salon, dia:dia, inicio:inicio, fin:fin},
              async: false,
              success: function(datos){
                        if(datos.length>0){
                            if(datos[0].id==$('#hdHorario').val()){
                                cadena = true;
                            }
                            else{
                                cadena = false;
                            }
                        }else{
                            cadena = true;
                        }
                   },
              dataType: 'json'
            });
        }
        else{
            cadena = true;
        }
        return cadena;
     }
     
     function getDisponibilidadCatedraticoAjax(){
        var cadena = false;
        var ciclo = $('#slCiclo').val();
        var cat = $('#slCatedraticos').val();
        var dia = $('#slDias').val();
        var inicio = $("#txtHoraInicial").val()+":"+$("#txtMinutoInicial").val();
        var fin = $("#txtHoraFinal").val()+":"+$("#txtMinutoFinal").val();
        if(ciclo && cat && dia && inicio && fin){
            $.ajax({
              type: "POST",
              url: '/EPS/ajax/getDisponibilidadCatedraticoAjax',
              data: {ciclo:ciclo, cat:cat, dia:dia, inicio:inicio, fin:fin},
              async: false,
              success: function(datos){
                        if(datos.length>0){
                            cadena = false;
                        }else{
                            cadena = true;
                        }
                   },
              dataType: 'json'
            });
        }
        else{
            cadena = true;
        }
            
        return cadena;
     }
});

