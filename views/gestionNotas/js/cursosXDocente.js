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
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getAniosAjax',
               'tipo=' + $("#slTipos").val(),
               function(datos){
                    $("#slAnio").html('');
                    if(datos.length>0 ){
                        $("#slAnio").append('<option value="">-- A&ntilde;o --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slAnio").append('<option value="' + datos[i].anio + '">' + datos[i].anio + '</option>' );
                        }
                    }else{
                        $("#slAnio").append('<option value="" disabled>No hay info.</option>' );
                    }
               },
               'json');
    }
    
    function getCiclosAjax(){
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getCiclosAjax',
               'anio=' + $("#slAnio").val(),
               function(datos){
                    $("#slCiclo").html('');
                    if(datos.length>0){
                        $("#slCiclo").append('<option value="">-- Ciclo --</option>' );
                        for(var i=0; i < datos.length; i++){
                            $("#slCiclo").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slCiclo").append('<option value="" disabled>No hay info.</option>' );
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
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getDocenteSeccion',
               { cat: $("#idCatedratico").val(), ciclo: $("#slCiclo").val() },
               function(datos){
                   $("#slSeccion").html('');
                   $("#slCursoxSeccion").html('');
                    if(datos.length>0){
                        for(var i =0; i < datos.length; i++){
                            $("#slSeccion").append('<option value="' + datos[i].idseccion + '">' + datos[i].infoseccion + '</option>' );
                            $("#slCursoxSeccion").append('<option value="' + datos[i].idseccion + '">' + datos[i].idcurso + '</option>' );
                        }
                        $("#btnActividades").prop("disabled",false);
                    }else{
                        $("#slSeccion").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                        $("#btnActividades").prop("disabled",true);
                    }
               },
               'json');
    }
    
    $("#slSeccion").change(function() {
        var id = $("#slSeccion").val();
        $("#slCursoxSeccion").val(id);
    });
    
    $("#btnActividades").click(function() {
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getIdTrama',
            { 
                cat: $("#idCatedratico").val(), 
                ciclo: $("#slCiclo").val(), 
                sec: $("#slSeccion").val(), 
                cur: $("#slCursoxSeccion").val() 
            },
            function(datos){
                if(datos.length>0){
                    var identificador = parseInt(datos[0].spidtrama);
                    mostrarListado(identificador);
                }else{
                    mostrarListado(0);
                }
            },
            'json');
    });
    
    function mostrarListado(){
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getIdTrama',
            { 
                cat: $("#idCatedratico").val(), 
                ciclo: $("#slCiclo").val(), 
                sec: $("#slSeccion").val(), 
                cur: $("#slCursoxSeccion").val() 
            },
            function(datos){
                if(datos.length>0){
                    alert(datos[0].spidtrama);
                    /*for(var i =0; i < datos.length; i++){
                        $("#slSeccion").append('<option value="' + datos[i].idseccion + '">' + datos[i].infoseccion + '</option>' );
                        $("#slCursoxSeccion").append('<option value="' + datos[i].idseccion + '">' + datos[i].idcurso + '</option>' );
                    }*/
                }else{
                    alert('no hay info');
                }
            },
            'json');
    }
    
});


