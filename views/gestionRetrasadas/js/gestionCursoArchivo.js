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
        },
        "bPaginate": false
    } );
    
    $("#marcarTodos").change(function() {        
        if(this.checked) {   
            $("input[type=checkbox]").prop('checked', true);
        }
        else
        {            
            $("input[type=checkbox]").prop('checked', false);
        }
    
    });    
    
});

