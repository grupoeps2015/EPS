$(document).ready( function () {
    $('#tbHorarios').DataTable( {
        language: {
          emptyTable: "No hay informaci&oacute;n disponible."
        }
    } );
    $('#linkNuevoHor').click(function(){
        $('#frmPost').submit();
    });
} );