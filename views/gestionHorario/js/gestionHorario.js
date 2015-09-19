$(document).ready( function () {
    $('#tbHorarios').DataTable({
        language: {
            emptyTable: "No hay informaci&oacute;n disponible.",
            sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda"
        }
    });
    
    $('#linkNuevoHor').click(function(){
        $('#frmPost').submit();
    });
} );