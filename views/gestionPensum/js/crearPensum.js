var nodeid = "";
var chkOtros = false;
var nodoSeleccionado = false;
$(document).ready(function(){
    
    $('#divPensum').css("display", "block");
    
    $('#frPensum').validate({
        rules:{
            
        },
        messages:{
            
        }
    }); 
    
    var data = [
			{
			 id:-1,
			 label: 'Pensum',
			 children: [
			 //{ label: 'nodo_child1',id:Math.random().toString(36).substr(2, 9) },
			 //{ label: 'nodo_child2',id:Math.random().toString(36).substr(2, 9) }
                        ]
			}
	];
	var padre=$('#arbolPensum').tree({
        data: data,
        autoOpen: true,
        dragAndDrop: true
    });
		
	
    //Seleccionado
    $('#arbolPensum').on('click',function (e) {
            nodoSeleccionado = true;
            nodeid = $('#arbolPensum').tree('getSelectedNode');
        }
    );
        
    $('#chkOtrosPrerrequisitos').change(function() {
        if(document.getElementById("chkOtrosPrerrequisitos").checked){
            chkOtros = true;
            document.getElementById("txtOtrosPrerrequisitos").disabled = false;
            document.getElementById("slCursos").disabled = true;            
        }
        else
        {
            chkOtros = false;
            document.getElementById("txtOtrosPrerrequisitos").disabled = true;
            document.getElementById("slCursos").disabled = false;               
        }
    });
  
});

function agregar() {
    if(nodoSeleccionado){
            var parent_node = $('#arbolPensum').tree('getNodeById', nodeid.id);
            var idNuevo=$("#slCursos").val();           
            var nombreNuevo=$("#slCursos option:selected").text().trim();
            var valorEntrada = document.getElementById('txtOtrosPrerrequisitos').value;
        if(idNuevo !== "" && !chkOtros){
            $('#arbolPensum').tree('appendNode',{label: nombreNuevo,id: idNuevo, tipo:"1", valor: ""}, parent_node);
            $('#arbolPensum').tree('openNode', parent_node);
        }
        else if(valorEntrada !== "" && chkOtros){
            //id = 0 ->No posee id
            var creditosValorEntrada = "Creditos >= " + valorEntrada;
            $('#arbolPensum').tree('appendNode',{label: creditosValorEntrada,id: 0, tipo:"2", valor: valorEntrada}, parent_node);
            $('#arbolPensum').tree('openNode', parent_node);
        } 
        nodoSeleccionado = false;
    }
    else{
        alert("Debe seleccionar un elemento del pensum para continuar definiendo la estructura.")
    }
}

function mostrar() {alert($('#arbolPensum').tree('toJson'));}

function remover() {
		var parent_node = $('#arbolPensum').tree('getNodeById', nodeid.id);
        $('#arbolPensum').tree('removeNode',parent_node);
    }

/*function actualizar() {
        var parent_node = $('#arbolPensum').tree('getNodeById', nodeid.id);
        $('#arbolPensum').tree('updateNode',parent_node,{label: 'Prueba'});
    }*/



