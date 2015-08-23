$(document).ready(function(){
    
    function getMunicipio(){
        $.post('/EPS/ajax/getMunicipio',
               'Depto=' + $("#slDeptos").val(),
               function(datos){
                   $("#slMunis").html('');
                   for(var i =0; i < datos.length; i++){
                       $("#slMunis").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                   }
               },
               'json');
    }
    
    $("#slDeptos").change(function(){
        if(!$("#slDeptos").val()){
            $("#slMunis").html('');
        }else{
            getMunicipio();
        }
    });
    
});