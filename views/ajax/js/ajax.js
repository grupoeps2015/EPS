$(document).ready(function(){
    var getMunicipio = function(){
        $.post('/EPS/ajax/getMunicipio',
               'depto=' + $("#slDepartamentos").val(),
               function(datos){
                   $("#slMunicipios").html("");
                   for(var i =0; i < datos.length; i++){
                       $("#slMunicipios").append('<opcion> value="' + i + '">' + i + '</option>' );
                   }
                   $("#slMunicipios").append('<opcion> value="100">cien</option>' );
               },
               'json');
        $("#sp").text("se llamo la funcion");
    }
    
    $("#slDepartamentos").change(function(){
        if(!$("#slDepartamentos").val()){
            $("#sp").text("");
            $("#slMunicipios").html("");
        }else{
            getMunicipio();
        }
    });
});