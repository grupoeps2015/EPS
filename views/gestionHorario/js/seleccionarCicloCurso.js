$(document).ready( function () {
    (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        //this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( '<input type="text" value="text" placeholder="Ingrese el código del curso a buscar"/>' )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "form-control input-lg myclass" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            $('#btnConsultar').prop("disabled",false);
            this._trigger( "select", event, function(){
              item: ui.item.option;
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "form-control input-lg" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
        if (this.input.val() == ""){
        }
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        $('#btnConsultar').prop("disabled",true);
        this.input
          .val( "" )
          .attr( "title", value + " no encontrado" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $("#slSec").combobox();
  });
    
    
    
    $('#frmGenerales').validate({
        rules:{
            txtAnio:{
                required: true
            },
            txtCiclo:{
                required: true
            }
        },
        messages:{
            txtAnio:{
                required: "Ingrese el año"
            },
            txtCiclo:{
                required: "Ingrese el número de ciclo"
            }
        }
    });
    
    $("#slAnio").change(function(){
        if(!$("#slAnio").val()){
            $("#slCiclo").html('');
            $("#slCiclo").append('<option value="" disabled>-- Ciclo --</option>')
            $('#btnConsultar').prop("disabled",true);
        }else{
            getCiclosAjax("slAnio","slCiclo");
        }
    });
    
    $("#slCiclo").change(function(){
        if(!$("#slCiclo").val()){
            $('#btnConsultar').prop("disabled",true);
        }else{
        }
    });
    
    $("#slAnioO").change(function(){
        if(!$("#slAnioO").val()){
            $("#slCicloO").html('');
            $("#slCicloO").append('<option value="" disabled>-- Ciclo --</option>')
            $('#btnCopia').prop("disabled",true);
        }else{
            getCiclosAjax("slAnioO","slCicloO");
        }
    });
    
    $("#slCicloO").change(function(){
        if(!$("#slCicloO").val() || !$("#slCicloD").val() || $("#slCicloO").val()==$("#slCicloD").val()){
            $('#btnCopia').prop("disabled",true);
        }else{
            $('#btnCopia').prop("disabled",false);
        }
    });
    
    $("#slAnioD").change(function(){
        if(!$("#slAnioD").val()){
            $("#slCicloD").html('');
            $("#slCicloD").append('<option value="" disabled>-- Ciclo --</option>')
            $('#btnCopia').prop("disabled",true);
        }else{
            getCiclosAjax("slAnioD","slCicloD");
        }
    });
    
    $("#slCicloD").change(function(){
        if(!$("#slCicloO").val() || !$("#slCicloD").val() || $("#slCicloO").val()==$("#slCicloD").val()){
            $('#btnCopia').prop("disabled",true);
        }else{
            $('#btnCopia').prop("disabled",false);
        }
    });
    
    $('#frEstudiantes').submit(function() {
          if(!$("#slCiclo").val() || !$("#slSec").val()){
              return false;
          }
          return true;
    });
    
    function getCiclosAjax(controlAnio,controlCiclo){
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getCiclosAjax',
               {anio: $("#"+controlAnio).val()},
               function(datos){
                    $("#"+controlCiclo).html('');
                    if(datos.length>0){
                        $("#"+controlCiclo).append('<option value="">-- Ciclo --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#"+controlCiclo).append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#"+controlCiclo).append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    $('#linkNuevoCic').click(function(){
        getSiguienteCicloAjax();
    });
    
    function getSiguienteCicloAjax(){
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getSiguienteCicloAjax',
               {tipo: $("#slTipos").val()},
               function(datos){
                    if(datos.length>0){
                        $("#txtAnio").val(datos[0].anio);
                        $("#txtCiclo").val(datos[0].ciclo);
                    }
               },
               'json');
    }
    
} );