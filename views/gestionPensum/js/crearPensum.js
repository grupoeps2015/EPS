var nodeid = "";
var chkOtros = false;
var nodoSeleccionado = false;

$(document).ready(function() {

    $('#divPensum').css("display", "block");

    $('#frPensum').validate({
        rules: {
        },
        messages: {
        }
    });

    var data = [
        {
            id: -1,
            label: 'Pensum',
            children: [
                //{ label: 'nodo_child1',id:Math.random().toString(36).substr(2, 9) },
                //{ label: 'nodo_child2',id:Math.random().toString(36).substr(2, 9) }
            ]
        }
    ];

    var padre = $('#arbolPensum').tree({
        data: data,
        autoOpen: true
        //dragAndDrop: true
    });


    //Seleccionado


    $('#arbolPensum').bind(
            'tree.select',
            function(event) {
                if (event.node) {
                    // node was selected
                    nodoSeleccionado = true;
                    nodeid = $('#arbolPensum').tree('getSelectedNode');
                    //nodeid = event.node.id;
                    //alert(node.name);
                }
                else {
                    // event.node is null
                    // a node was deselected
                    // e.previous_node contains the deselected node
                }
            }
    );

    $('#chkOtrosPrerrequisitos').change(function() {
        if (document.getElementById("chkOtrosPrerrequisitos").checked) {
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
    if (nodoSeleccionado && nodeid !== "") {
        var parent_node = $('#arbolPensum').tree('getNodeById', nodeid.id);
        var idNuevo = $("#slCursos").val();
        var nombreNuevo = $("#slCursos option:selected").text().trim();
        var valorEntrada = document.getElementById('txtOtrosPrerrequisitos').value;
        var level = parent_node.getLevel();
        if (idNuevo !== "" && !chkOtros) {
            if (idNuevo !== parent_node && level !==2 ) {
                $('#arbolPensum').tree('appendNode', {label: nombreNuevo, id: idNuevo, tipo: "1", valor: "-1"}, parent_node);
                $('#arbolPensum').tree('openNode', parent_node);
                $('#arbolPensum').tree('selectNode', null);
            }
            else if(level === 2){
                        alert("No puedes agregar un prerrequisito a un prerrequisito.");        
            }else
            {
                alert("El padre es el mismo que el hijo.");
            }
        }
        else if (valorEntrada !== "" && chkOtros) {
            //id = 0 ->No posee id
            var creditosValorEntrada = "Creditos >= " + valorEntrada;
            $('#arbolPensum').tree('appendNode', {label: creditosValorEntrada, id: 0, tipo: "2", valor: valorEntrada}, parent_node);
            $('#arbolPensum').tree('openNode', parent_node);
            $('#arbolPensum').tree('selectNode', null);
        }
        nodoSeleccionado = false;
        nodeid = "";

    }
    else {
        alert("Debe seleccionar un elemento del pensum para continuar definiendo la estructura.");
    }
}

function mostrar() {
    alert($('#arbolPensum').tree('toJson'));
}

function displayNodes() {
    var nodes = "";
    var parent_node = $('#arbolPensum').tree('getNodeById', -1);
    for (var i = 0; i < parent_node.children.length; i++) {
        var child = parent_node.children[i];
        nodes = nodes +" CURSO "+i+": "+child.name; 
        //alert('--'+child.name);
        if(parent_node.children[i].children.length >0){
            for(var j=0; j<parent_node.children[i].children.length; j++)
             {
             var child1 = parent_node.children[i].children[j];
             nodes = nodes+ " PRERREQUISITO "+j+": "+child1.name;
              //alert('--'+child1.name);
             }      
        }
       
    }
    alert(nodes);
}

function remover() {
    var parent_node = $('#arbolPensum').tree('getNodeById', nodeid.id);
    $('#arbolPensum').tree('removeNode', parent_node);
    $('#arbolPensum').tree('selectNode', null);
}

/*function actualizar() {
 var parent_node = $('#arbolPensum').tree('getNodeById', nodeid.id);
 $('#arbolPensum').tree('updateNode',parent_node,{label: 'Prueba'});
 }*/



