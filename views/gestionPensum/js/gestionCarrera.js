$(document).ready( function () {
    $('#tbCarreras').DataTable( {
        "language": {
          "emptyTable": "No hay informaci&oacute;n disponible."
        }
    } );
    
    $('#linkNuevoCar').click(function(){
       $('#frmPost').submit();
    });
} );