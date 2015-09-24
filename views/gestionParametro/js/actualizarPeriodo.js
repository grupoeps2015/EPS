$(document).ready(function(){
    $(function($){
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
    });
    
    $("#txtFechaInicial").datepicker();
    $("#txtFechaFinal").datepicker();
    
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
    
    $("#txtFechaInicial").change(function(){
        if(!existeFecha($("#txtFechaInicial").val())){
            $("#txtFechaInicial").val("");
            alert("Fecha inválida");
        }
    });
    
    $("#txtFechaFinal").change(function(){
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
        if(fecha != ""){
            var fechaf = fecha.split('/');
            var day, year;
                day = fechaf[0];
                year = fechaf[2];

            var month = (parseInt(fechaf[1])-parseInt(1));
            var date = new Date(year,month,day);
            if(parseInt(date.getFullYear())==parseInt(year) && parseInt(date.getMonth())==parseInt(month) && parseInt(date.getDate())==parseInt(day)){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return true;
        }
    }
    
});