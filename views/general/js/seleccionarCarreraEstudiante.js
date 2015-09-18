$(document).ready( function () {
 
    $("#slCarreras").change(function(){
        if(!$("#slCarreras").val()){
            $('#btnConsultar').prop("disabled",true);
        }else{
            $('#btnConsultar').prop("disabled",false);
        }
    });

} );