$(document).ready(function(){
	//
	$(document).on('click','caption',function(){
		//obtener la tabla que contiene el caption clickeado
		var objTabla=$(this).parent();
			//el cuerpo de la tabla esta visible?
			//lo siguiente es unicamente para cambiar el icono del caption
			if(objTabla.find('tbody').is(':visible')){
				//eliminamos la clase clsContraer
				$(this).removeClass('clsContraer');
				//agregamos la clase clsExpandir
				$(this).addClass('clsExpandir');
			}else{
				//eliminamos la clase clsExpadir
				$(this).removeClass('clsExpandir');
				//agregamos la clase clsContraer
				$(this).addClass('clsContraer');
			}
			//mostramos u ocultamos el cuerpo de la tabla
			objTabla.find('tbody').toggle();
	});
		
	//evento que se dispara al hacer clic en el boton para agregar una nueva fila
	$(document).on('click','.clsAgregarFila',function(){
		//almacenamos en una variable todo el contenido de la nueva fila que deseamos
		//agregar. pueden incluirse id's, nombres y cualquier tag... sigue siendo html
		var strNueva_Fila='<tr>'+
			'<td><select class="clsCurso form-control input-lg"><option>Seleccione</option></select></td>'+
			'<td><select class="clsSeccion form-control input-lg"><option>Seleccione</option></select></td>'+
			'<td align="right"><input type="button" value="-" class="clsEliminarFila btn btn-danger btn-lg btn-warning"></td>'+
		'</tr>';
				
		/*obtenemos el padre del boton presionado (en este caso queremos la tabla, por eso
		utilizamos get(3)
			table -> padre 3
				tfoot -> padre 2
					tr -> padre 1
						td -> padre 0
		nosotros queremos utilizar el padre 3 para agregarle en la etiqueta
		tbody una nueva fila*/
		var objTabla=$(this).parents().get(3);
				
		//agregamos la nueva fila a la tabla
		$(objTabla).find('tbody').append(strNueva_Fila);
				
		//si el cuerpo la tabla esta oculto (al agregar una nueva fila) lo mostramos
		if(!$(objTabla).find('tbody').is(':visible')){
			//le hacemos clic al titulo de la tabla, para mostrar el contenido
			$(objTabla).find('caption').click();
		}
	});
	
	//cuando se haga clic en cualquier clase .clsEliminarFila se dispara el evento
	$(document).on('click','.clsEliminarFila',function(){
		/*obtener el cuerpo de la tabla; contamos cuantas filas (tr) tiene
		si queda solamente una fila le preguntamos al usuario si desea eliminarla*/
		var objCuerpo=$(this).parents().get(2);
			if($(objCuerpo).find('tr').length==1){
				if(!confirm('Esta es el única fila de la lista ¿Desea eliminarla?')){
					return;
				}
			}
					
		/*obtenemos el padre (tr) del td que contiene a nuestro boton de eliminar
		que quede claro: estamos obteniendo dos padres
					
		el asunto de los padres e hijos funciona exactamente como en la vida real
		es una jergarquia. imagine un arbol genealogico y tendra todo claro ;)
				
			tr	--> padre del td que contiene el boton
				td	--> hijo de tr y padre del boton
					boton --> hijo directo de td (y nieto de tr? si!)
		*/
		var objFila=$(this).parents().get(1);
			/*eliminamos el tr que contiene los datos del contacto (se elimina todo el
			contenido (en este caso los td, los text y logicamente, el boton */
			$(objFila).remove();
	});
	
	//evento que se produce al hacer clic en el boton que elimina una tabla completamente
	$(document).on('click','.clsEliminarTabla',function(){
		var objTabla=$(this).parents().get(3);
			//bajamos la opacidad de la tabla hasta estar invisible
			$(objTabla).animate({'opacity':0},500,function(){
				//eliminar la tabla
				$(this).remove();
			});
	});
	
	//boton para clonar cualquiera de las tablas
	$(document).on('click','.clsClonarTabla',function(){
		var objTabla=$(this).parents().get(4);
			//agregamos un clon de la tabla a la capa contenedora
			$('#divContenedor').append($(objTabla).clone());
	});
        
        $(document).on('focus','.clsCurso',function(){
            var objFila=$(this).parents().get(1);
			/*eliminamos el tr que contiene los datos del contacto (se elimina todo el
			contenido (en este caso los td, los text y logicamente, el boton */
                        var item1 = $( "select.clsCurso" );
                        var a = getTipoCiclo();
                        $(objFila).find(item1).html(a);
                        $(objFila).find(item1).change();
                //var idi = $(this).val();
		//alert("hola " + idi);
	});
        
        $(document).on('change','.clsCurso',function(){
            var objFila=$(this).parents().get(1);
			/*eliminamos el tr que contiene los datos del contacto (se elimina todo el
			contenido (en este caso los td, los text y logicamente, el boton */
                        var item1 = $( "select.clsSeccion" );
                        var a = getCiclosAjax($(this).val());
                        $(objFila).find(item1).html(a);
                //var idi = $(this).val();
		//alert("hola " + idi);
	});
        
    function getTipoCiclo(){
        var cadena = "";
        $.ajax({
          type: "POST",
          url: '/EPS/ajax/getTipoCiclo',
          data: {tipoCiclo:1},
          async: false,
          success: function(datos){
                    cadena += '<option value="-1">Seleccione</option>';
                    if(datos.length>0){
                        for(var i =0; i < datos.length; i++){
                            cadena += '<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>';
                        }
                    }else{
                        cadena += '<option value="" disabled>No hay informaci&oacute;n disponible</option>';
                    }
               },
          dataType: 'json'
        });
        return cadena;
    }
    function getCiclosAjax(tipo){
        var cadena = "";
        $.ajax({
          type: "POST",
          url: '/EPS/ajax/getCiclosAjax',
          data: {tipo:tipo},
          async: false,
          success: function(datos){
                    cadena += '<option value="-1">Seleccione</option>';
                    if(datos.length>0){
                        for(var i =0; i < datos.length; i++){
                            cadena += '<option value="' + datos[i].codigo + '">' + datos[i].nombre + '</option>';
                        }
                    }else{
                        cadena += '<option value="" disabled>No hay informaci&oacute;n disponible</option>';
                    }
               },
          dataType: 'json'
        });
        return cadena;
    }
			
});