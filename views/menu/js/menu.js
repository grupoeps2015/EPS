$(document).ready(function(){
        
    $('li.padres').hover(function() {
        $(this).children('ul.hijos').show('slow');
    });
    //$('li.padres').mouseleave(function(event) {
        //$('ul.hijos').hide('slow');
    //});
    $('#titulomenu').click(function() {
        $('ul.hijos').hide('slow');
    });
});
   

