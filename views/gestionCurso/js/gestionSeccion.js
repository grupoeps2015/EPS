$(document).ready( function () {
    $('#tbSecciones').DataTable({
        language: {
          emptyTable: "No hay informaci&oacute;n disponible.",
          sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda"
        }
    });
    
    $('#linkSeccionNueva').click(function(){
        $('#frmPost').submit();
    });
    
    $('#linkGestionHorario').click(function(){
        $('#frmPostHorario').submit();
    });
    
} );