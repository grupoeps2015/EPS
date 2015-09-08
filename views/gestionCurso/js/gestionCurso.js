$(document).ready( function () {
    $('#tbCursos').DataTable();
    
    $('#linkSeccion').click(function(){
        $('#frmPost1').submit();
    });
    
    $('#linkNuevoUsr').click(function(){
        $('#frmPost2').submit();
    });
    
});