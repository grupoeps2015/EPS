$(document).ready( function () {
    $('#tbCursos').DataTable( {
        language: {
          emptyTable: "No hay informaci&oacute;n disponible."
        }
    } );
    
    $('#linkSeccion').click(function(){
        $('#frmPost1').submit();
    });
    
    $('#linkNuevoUsr').click(function(){
        $('#frmPost2').submit();
    });
    
});