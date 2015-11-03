$(document).ready(function(){
    var tabla= $('#tbCursosAprobados').DataTable({
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
    });  
    var oTableTools = new TableTools( tabla, {
        "sSwfPath" : "{!URLFOR($Resource.TableToolsZip, 'swf/ZeroClipboard.swf')}",
        "buttons": [
                    "copy",
                    "csv",
                    "xls",
                    "pdf"
                   ]
      });
            $('#tbCursosAprobados').before( oTableTools.dom.container );
    
    
} );