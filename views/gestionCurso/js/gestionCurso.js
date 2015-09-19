$(document).ready( function () {
    $('#tbCursos').DataTable( {
        language: {
          emptyTable: "No hay informaci&oacute;n disponible.",
          sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda"
        }
    } );
    
    $('#linkSeccion').click(function(){
        $('#frmPost1').submit();
    });
    
    $('#linkNuevoUsr').click(function(){
        $('#frmPost2').submit();
    });
    
});