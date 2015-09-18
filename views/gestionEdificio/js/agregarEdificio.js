$(document).ready( function () {
    $('#frEdificios').validate({
        rules:{
            txtNombre:{
                required: true
            },
            txtDescripcion:{
                required: true
            },
            txtDescripcionParametro:{
                required: true
            },
            txtExtensionParametro:{
                required: true
            },
            slCentroUnidadAcademica:{
                required: true
            },
            slTipoParametro:{
                required: true
            }
        },
        messages:{
            txtNombreParametro:{
                required: "Es necesario ingresar el nombre del parámetro."
            },
            txtValorParametro:{
                required: "Es necesario ingresar el valor del parámetro."
            },
            txtDescripcionParametro:{
                required: "Es necesario ingresar la descripción del parámetro."
            },
            txtExtensionParametro:{
                required: "El necesario ingresar la extensión del parámetro."
            },
            slCentroUnidadAcademica:{
                required: "Elija un centro y unidad académica."
            },
            slTipoParametro:{
                required: "Elija un tipo de parámetro."
            }
        }
    }); 
} );