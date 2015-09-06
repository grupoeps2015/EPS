$(document).ready( function () {
    $('#tbUsuarios').DataTable();
    
    $('#linkNuevoUsr').click(function(){
        $('#frmPost').submit();
    });
});