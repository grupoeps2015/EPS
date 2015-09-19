$(document).ready( function () {
    $('#tbUsuarios').DataTable( {
        language: {
            emptyTable: "No hay informaci&oacute;n disponible.",
            sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda"
        }
    } );
    $('#linkNuevoUsr').click(function(){
        $('#frmPost').submit();
    });
});