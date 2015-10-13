$(document).ready(function() {
    
    $('#frCursoPensum').validate({
        rules: {
            slCursos: {
                required: true
            },
            slAreas: {
                required: true
            },
            txtNumeroCiclo: {
                required: true
            },
            slTipoCiclo:{
                required: true
            },
            txtCreditos:{
                required: true
            }
        },
        messages: {
            slCursos: {
                required: "Es necesario seleccionar un curso."
            },
            slAreas: {
                required: "Es necesario seleccionar un área."
            },
            txtNumeroCiclo: {
                required: "Es necesario definir un número de ciclo."
            },
            slTipoCiclo:{
                required: "Es necesario seleccionar un tipo de ciclo."
            },
            txtCreditos:{
                required: "Si el curso no tiene créditos ingresar 0."
            }
        }
    });
});
