$(document).ready(function(){
    $('#tbCursos').DataTable({
        language:{
            emptyTable: "No hay informaci&oacute;n disponible.",
            sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda",
            info: "Se muestran del _START_ al _END_ de _TOTAL_ registros",
            infoEmpty: "No hay registros que mostrar",
            paginate:{
                next: "Siguiente",
                previous: "Anterior"
            },
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros"
        }
    } );
    
    $('#linkSeccion').click(function(){
        $('#frmPost1').submit();
    });
    
    $('#linkNuevoUsr').click(function(){
        $('#frmPost2').submit();
    });
    
});