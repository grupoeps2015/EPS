$(document).ready(function(){
    
    $('#frUnidad').validate({
        rules:{
            txtCodigoUni:{
                required: true,
                min: 1,
                max: 10000
            },
            txtNombreUni:{
                required: true
            },
            slTipos:{
                required: true
            }
        },
        messages:{
            txtCodigoUni:{
                required: "Ingrese el codigo de la nueva unidad",
                min: "el codigo no puede ser menor o igual a 0",
                max: "el codigo es demasiado grande"
            },
            txtNombreUni:{
                required: "Ingrese el nombre de la nueva unidad"
            },
            slTipos:{
                required: "Elija el tipo de unidad que se esta creando"
            }
        }
    });
    
    $('#cbTienePadre').click(function(){
        if($(this).is(':checked')){
            $('#slExistentes').prop("disabled",false);
        }else{
            $('#slExistentes').prop("disabled",true);
            $('#slExistentes').val("NULL");
        }
    });
});