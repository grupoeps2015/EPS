$(document).ready(function() {

    $('#frPensum').validate({
        rules: {
            slCarreras: {
                required: true
            },
            txtTiempo: {
                required: true
            },
            inputFecha: {
                required: true,
                date: true
            },
            slTipos:{
                required: true
            }
        },
        messages: {
            slCarreras: {
                required: "Selecciona una carrera"
            },
            txtTiempo: {
                required: "Indica la el número de ciclos que durará el pensum"
            },
            inputFecha: {
                required: "Selecciona un fecha válida"
            },
            slTipos:{
                required: "Selecciona un tipo de pensum"
            }
        }


    });
    
});
