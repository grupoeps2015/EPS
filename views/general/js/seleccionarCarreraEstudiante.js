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
 
        this.input = $( '<input type="text" value="text" placeholder="Ingrese el carnet del estudiante a buscar"/>' )
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
            getCarreras();
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
        $("#slCarreras").html('');
        $("#slCarreras").append('<option value="">-- Carrera --</option>' );
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
  
    $("#slCarreras").change(function(){
        if(!$("#slCarreras").val()){
            $('#btnConsultar').prop("disabled",true);
        }else{
            $('#btnConsultar').prop("disabled",false);
        }
    });

    $("#slAnio").change(function(){
        if(!$("#slAnio").val()){
            $("#slCarreras").html('');
            $("#slCarreras").append('<option value="">-- Carrera --</option>' );
            $("#slEstudiantes").html('');
            $("#slEstudiantes").append('<option value="">-- Estudiante --</option>' );
            $("#slEstudiantes").combobox();
            $(".myclass").val("");
            $('#btnConsultar').prop("disabled",true);
        }else{
            getEstAjax();
            $("#slEstudiantes").combobox();
        }
    });
    
    function getCarreras(){
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getCarrerasEstudianteAjax',
               'est=' + $("#slEstudiantes").val(),
               function(datos){
                    $("#slCarreras").html('');
                    if(datos.length>0){
                        $("#slCarreras").append('<option value="">-- Carrera --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slCarreras").append('<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slCarreras").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
    
    function getEstAjax(){
        var base_url = $("#hdBASE_URL").val();
        $.post(base_url+'ajax/getEstudiantesAnioInscripcionAjax',
               'anio=' + $("#slAnio").val(),
               function(datos){
                    $("#slEstudiantes").html('');
                    if(datos.length>0){
                        $("#slEstudiantes").append('<option value="">-- Estudiante --</option>' );
                        for(var i =0; i < datos.length; i++){
                            $("#slEstudiantes").append('<option value="' + datos[i].codigo + '">[' + datos[i].carnet + '] ' + datos[i].nombre + '</option>' );
                        }
                    }else{
                        $("#slEstudiantes").append('<option value="" disabled>No hay informaci&oacute;n disponible</option>' );
                    }
               },
               'json');
    }
} );