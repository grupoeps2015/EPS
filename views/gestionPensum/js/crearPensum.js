var nodeid = "";
var chkOtros = false;
var nodoSeleccionado = false;


$(document).ready(function() {
    if (/undefined/.test(hv)) {
        if (/prerrequisitos=}]/.test(window.location.href)) {
            var mensaje = "\"" + window.location.href + "\"";
            var posicion = mensaje.indexOf('?');
            // alert(mensaje.substring(1,posicion));
            window.location.href = mensaje.substring(1, posicion);

        }
    }

    var hv = $('#hdPrerrequisitos').attr("value");
    if (/Undefined index/.test(hv) || hv === "" || hv === null || hv.search("NO_P_PRERREQUISITO") > -1) {
        //alert(hv);
    }

    else {

        var childrens = hv.replace(/,'is_open':true/g, "").replace(/'/g, '"');
        var getContact = JSON.parse(childrens);
        //alert(getContact[0].name);
    }


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
            label: 'Prerrequisitos',
            children: getContact
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
            document.getElementById("textbox").disabled = true;
            document.getElementById("txtOtrosPrerrequisitos").hidden = false;
        }
        else
        {
            chkOtros = false;
            document.getElementById("txtOtrosPrerrequisitos").disabled = true;
            document.getElementById("slCursos").disabled = false;
            document.getElementById("txtOtrosPrerrequisitos").hidden = true;
            document.getElementById("textbox").disabled = false;
        }
    });

});

function agregar() {



    //if (nodoSeleccionado && nodeid !== "") {
    var parent_node = $('#arbolPensum').tree('getNodeById', -1);
    var idNuevo = $("#slCursos").val();
    var idCurso = $("#hdIdCurso").val();
    if (idCurso === idNuevo) {

        alert("No puedes asignar de prerrequisito el mismo curso");
        return;
    }

    for (var i = 0; i < parent_node.children.length; i++) {
        var child = parent_node.children[i];
        var idChild = child.id;
        if (idNuevo === idChild) {
            alert("El prerrequisito fue agregado previamente.");
            return;
        }
    }

    var nombreNuevo = $("#slCursos option:selected").text().trim();
    var valorEntrada = document.getElementById('txtOtrosPrerrequisitos').value;
    var level = parent_node.getLevel();
    if (idNuevo !== "" && !chkOtros) {
        if (idNuevo !== parent_node && level !== 2) {
            $('#arbolPensum').tree('appendNode', {label: nombreNuevo, id: idNuevo, tipo: "1", valor: "-1"}, parent_node);
            $('#arbolPensum').tree('openNode', parent_node);
            $('#arbolPensum').tree('selectNode', null);
        }
        else if (level === 2) {
            alert("No puedes agregar un prerrequisito a un prerrequisito.");
        } else
        {
            alert("El padre es el mismo que el hijo.");
        }
    }
    else if (valorEntrada !== "" && chkOtros) {
        //id = 0 ->No posee id
        for (var i = 0; i < parent_node.children.length; i++) {
            var tipoChild = child.tipo;
            if (tipoChild == 2 ) {
                alert("Ya fue agregado un prerrequisito de creditos, para modificarlo elimina el existente e ingresalo de nuevo.");
                return;
            }
        }
        if (idNuevo !== parent_node && level !== 2) {
            var creditosValorEntrada = "Creditos >= " + valorEntrada;
            $('#arbolPensum').tree('appendNode', {label: creditosValorEntrada, id: "0", tipo: "2", valor: valorEntrada}, parent_node);
            $('#arbolPensum').tree('openNode', parent_node);
            $('#arbolPensum').tree('selectNode', null);

        } else if (level === 2) {
            alert("No puedes agregar un prerrequisito a un prerrequisito.");
        }

    }
    nodoSeleccionado = false;
    nodeid = "";
    var a = $('#arbolPensum').tree('toJson');
    var res = a.toString().substring(60, a.toString().length - 2);
    var re = /"/gi;
    var newstr = res.replace(re, "'");
    if (/prerrequisitos/.test(window.location.href)) {
        var mensaje = "\"" + window.location.href + "\"";
        var posicion = mensaje.indexOf('?');
        // alert(mensaje.substring(1,posicion));
        window.location.href = mensaje.substring(1, posicion);
        window.location.href = mensaje.substring(1, posicion) + "?prerrequisitos=" + newstr;
    } else {
        window.location.href = window.location.href + "?prerrequisitos=" + newstr;
    }
//    }
    //   else {
    //   alert("Debe seleccionar <Prerrequisitos> para continuar definiendo la estructura.");
    // }


}

function mostrar() {

    var a = $('#arbolPensum').tree('toJson');
    var res = a.toString().substring(60, a.toString().length - 2);
    var re = /"/gi;
    var newstr = res.replace(re, "'");
    if (/prerrequisitos/.test(window.location.href)) {
        var mensaje = "\"" + window.location.href + "\"";
        var posicion = mensaje.indexOf('?');
        // alert(mensaje.substring(1,posicion));
        window.location.href = mensaje.substring(1, posicion);
        window.location.href = mensaje.substring(1, posicion) + "?prerrequisitos=" + newstr;
    } else {
        window.location.href = window.location.href + "?prerrequisitos=" + newstr;
    }

}

function displayNodes() {
    var nodes = "";
    var parent_node = $('#arbolPensum').tree('getNodeById', -1);
    for (var i = 0; i < parent_node.children.length; i++) {
        var child = parent_node.children[i];
        nodes = nodes + " CURSO " + i + ": " + child.name;
        //alert('--'+child.name);
        if (parent_node.children[i].children.length > 0) {
            for (var j = 0; j < parent_node.children[i].children.length; j++)
            {
                var child1 = parent_node.children[i].children[j];
                nodes = nodes + " PRERREQUISITO " + j + ": " + child1.name;
                //alert('--'+child1.name);
            }
        }
        alert(parent_node.children[i]);
    }


}

function remover() {
    var parent_node = $('#arbolPensum').tree('getNodeById', nodeid.id);
    $('#arbolPensum').tree('removeNode', parent_node);
    $('#arbolPensum').tree('selectNode', null);

    var a = $('#arbolPensum').tree('toJson');
    var res = a.toString().substring(60, a.toString().length - 2);
    var re = /"/gi;
    var newstr = res.replace(re, "'");
    if (/prerrequisitos/.test(window.location.href)) {
        var mensaje = "\"" + window.location.href + "\"";
        var posicion = mensaje.indexOf('?');
        // alert(mensaje.substring(1,posicion));
        window.location.href = mensaje.substring(1, posicion);
        window.location.href = mensaje.substring(1, posicion) + "?prerrequisitos=" + newstr;
    } else {
        if (newstr.toString() === '}]') {
            alert('ES IGUALITO');
        }
        window.location.href = window.location.href + "?prerrequisitos=" + newstr;
    }
}

/*function actualizar() {
 var parent_node = $('#arbolPensum').tree('getNodeById', nodeid.id);
 $('#arbolPensum').tree('updateNode',parent_node,{label: 'Prueba'});
 }*/

jQuery.fn.filterByText = function(textbox, selectSingleMatch) {
    return this.each(function() {
        var select = this;
        var options = [];
        $(select).find('option').each(function() {
            options.push({value: $(this).val(), text: $(this).text()});
        });
        $(select).data('options', options);
        $(textbox).bind('change keyup', function() {
            var options = $(select).empty().data('options');
            var search = $(this).val().trim();
            var regex = new RegExp(search, "gi");

            $.each(options, function(i) {
                var option = options[i];
                if (option.text.match(regex) !== null) {
                    $(select).append(
                            $('<option>').text(option.text).val(option.value)
                            );
                }
            });
            if (selectSingleMatch === true && $(select).children().length === 1) {
                $(select).children().get(0).selected = true;
            }
        });
    });
};

$(function() {
    $('#slCursos').filterByText($('#textbox'), false);
    $("select option").click(function() {
        alert(1);
    });
});

