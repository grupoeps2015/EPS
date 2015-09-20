$(document).ready( function () {
    $('#slExistentes').change(function(){
        if($('#slExistentes').val() === "NULL"){
            $('#btnAgregar').prop("disabled",true);
        }else{
            $('#btnAgregar').prop("disabled",false);
        }
    });
    
    $('#slPropias').change(function(){
        if($('#slPropias').val() === "NULL"){
            $('#btnQuitar').prop("disabled",true);
        }else{
            $('#btnQuitar').prop("disabled",false);
        }
    });
    
    $('#tbUnidadesAcademicas').DataTable( {
        language: {
            emptyTable: "No hay informaci&oacute;n disponible.",
            sZeroRecords: "No se encontro informaci&oacute;n compatible con la busqueda"
        }
    } );
    
} );