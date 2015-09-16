$(document).ready( function () {
    $('#tbParametros').DataTable( {
        "language": {
          "emptyTable": "No hay informaci&oacute;n disponible."
        }
    } );
    
     $('#linkNuevoPar').click(function(){
       $('#frmPost').submit();
    });
    
} );