$(document).ready( function () {
    $('#tbParametros').DataTable( {
        language: {
            emptyTable: "No hay informaci&oacute;n disponible.",
            sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda"
        }
    } );
    
     $('#linkNuevoPar').click(function(){
       $('#frmPost').submit();
    });
    
} );