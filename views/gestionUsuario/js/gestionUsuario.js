$(document).ready( function () {
    $('#tbUsuarios').DataTable( {
        "language": {
          "emptyTable": "No hay informaci&oacute;n disponible."
        }
    } );
    $('#linkNuevoUsr').click(function(){
        $('#frmPost').submit();
    });
});