$(document).ready( function () {
    $('#slExistentes').change(function(){
        if($('#slExistentes').val() === "NULL"){
            $('#btnAgregar').prop("disabled",true);
        }else{
            $('#btnAgregar').prop("disabled",false);
        }
    });
    
    $('#tbUnidadesAcademicas').DataTable( {
        language: {
            emptyTable: "No hay informaci&oacute;n disponible.",
            sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda"
        }
    } );
    
} );