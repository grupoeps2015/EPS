$(document).ready( function () {
    $("#slTipos").change(function(){
        if(!$("#slTipos").val()){
            $("#slAnio").html('');
            $("#slCiclo").html('');
            $("#slSeccion").html('');
            $("#slAnio").append('<option value="" disabled>-- A&ntilde;o --</option>')
            $("#slCiclo").append('<option value="" disabled>-- Ciclo --</option>')
            $("#slSeccion").append('<option value="" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getAniosAjax();
        }
    });
    
    $("#slAnio").change(function(){
        if(!$("#slAnio").val()){
            $("#slCiclo").html('');
            $("#slSeccion").html('');
            $("#slCiclo").append('<option value="" disabled>-- Ciclo --</option>')
            $("#slSeccion").append('<option value="" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getCiclosAjax();
        }
    });
    
    function getAniosAjax(){
        $.post('/EPS/ajax/getAniosAjax',
               'tipo=' + $("#slTipos").val(),
               function(datos){
                    $("#slAnio").html('');
                    if(datos.length>0 ){
                        $("#slAnio").append('<option value="">-- A&ntilde;o --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slAnio").append('<option value="' + datos[i].anio + '">' + datos[i].anio + '</option>' );
                        }
                    }else{
                        $("#slAnio").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    function getCiclosAjax(){
        $.post('/EPS/ajax/getCiclosAjax',
               'anio=' + $("#slAnio").val(),
               function(datos){
                    $("#slCiclo").html('');
                    if(datos.length>0){
                        $("#slCiclo").append('<option value="">-- Ciclo --</option>' );
                        for(var i=0; i < datos.length; i++){
                            $("#slCiclo").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slCiclo").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    $("#slCiclo").change(function(){
        if(!$("#slCiclo").val()){
            $("#slSeccion").html('');
            $("#slSeccion").append('<option value="" disabled>-- Secci&oacute;n Asignada --</option>')
        }else{
            getDocenteSeccion();
        }
    });
    
    function getDocenteSeccion(){
        $.post('/EPS/ajax/getDocenteSeccion',
                { cat: $("#idCatedratico").val(), ciclo: $("#slCiclo").val() },
               function(datos){
                   $("#slSeccion").html('');
                    if(datos.length>0){
                        for(var i =0; i < datos.length; i++){
                            $("#slSeccion").append('<option value="' + datos[i].idcurso + '">' + datos[i].infoseccion + '</option>' );
                        }
                    }else{
                        $("#slSeccion").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
});


