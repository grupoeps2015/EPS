$(document).ready(function(){
    $('#frSecciones').validate({
        rules:{
            slAnio:{
                required: true
            },
            slCiclo:{
                required: true
            },
            slTiposPeriodo:{
                required: true
            },
            slTiposAsign:{
                required: true
            }
        },
        messages:{
            slAnio:{
                required: "Seleccione un año"
            },
            slCiclo:{
                required: "Seleccione un ciclo"
            },
            slTiposPeriodo:{
                required: "Seleccione un tipo de período"
            },
            slTiposAsign:{
                required: "Seleccione un tipo de asignación"
            }
        }
    });
    
    $("#slAnio").change(function(){
        if(!$("#slAnio").val()){
            $("#slCiclo").html('');
            $("#slCiclo").append('<option value="" disabled>-- Ciclo --</option>')
        }else{
            getCiclosAjax();
        }
    });
    
    $("#txtFechaInicial").focusout(function(){
        if(!existeFecha($("#txtFechaInicial").val())){
            $("#txtFechaInicial").val("");
            alert("Fecha inválida");
        }
    });
    
    $("#txtFechaFinal").focusout(function(){
        if(!existeFecha($("#txtFechaFinal").val())){
            $("#txtFechaFinal").val("");
            alert("Fecha inválida");
        }
    });
    
    function getCiclosAjax(){
        $.post('/EPS/ajax/getCiclosAjax',
               {anio: $("#slAnio").val()},
               function(datos){
                    $("#slCiclo").html('');
                    if(datos.length>0){
                        $("#slCiclo").append('<option value="">-- Ciclo --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slCiclo").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slCiclo").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    function existeFecha(fecha){
        var reg = /[/]|[-]/;
        var fechaf = fecha.split(reg);
        var day, year;
        if(fechaf[0].trim().length == 4){
            day = fechaf[2];
            year = fechaf[0];
        }
        else{
            day = fechaf[0];
            year = fechaf[2];
        }
        
        var month = (parseInt(fechaf[1])-parseInt(1));
        var date = new Date(year,month,day);
        if(parseInt(date.getFullYear())==parseInt(year) && parseInt(date.getMonth())==parseInt(month) && parseInt(date.getDate())==parseInt(day)){
            return true;
        }
        else{
            return false;
        }
    }
    
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

