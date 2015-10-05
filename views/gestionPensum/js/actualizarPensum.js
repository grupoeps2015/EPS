$(document).ready(function() {
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
    $('#frPensum').validate({
        rules: {
            slCarreras: {
                required: true
            },
            txtTiempo: {
                required: true
            },
            inputFecha: {
                required: true
            },
            slTipos:{
                required: true
            }
        },
        messages: {
            slCarreras: {
                required: "Selecciona la carrera que deseas"
            },
            txtTiempo: {
                required: "Indica la el número de ciclos que durará el pensum"
            },
            inputFecha: {
                required: "Selecciona un fecha válida"
            },
            slTipos:{
                required: "Selecciona un tipo de pensum"
            }
        }
    });
    $("#inputFecha").datepicker();
    $("#inputFecha").change(function(){
        if(!existeFecha($("#inputFecha").val())){
            $("#inputFecha").val("");
            alert("Fecha inválida");
        }
    });
    
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
