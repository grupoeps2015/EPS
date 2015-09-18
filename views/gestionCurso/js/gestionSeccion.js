$(document).ready( function () {
    $('#tbSecciones').DataTable({
        language: {
          emptyTable: "No hay informaci&oacute;n disponible."
        }
    });
    
    $('#linkSeccionNueva').click(function(){
        $('#frmPost').submit();
    });
    
    $('#linkGestionHorario').click(function(){
        $('#frmPostHorario').submit();
    });
    
} );