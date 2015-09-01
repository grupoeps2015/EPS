<?php

/**
 * Description of admCrearUsuarioController
 *
 * @author Rickardo, Maythee
 */
class admHistoriaCrearCursoController extends Controller {

    private $_post;
    private $_encriptar;

    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ADMH_FOLDER, 'admHistoriaCrearCurso');
        $this->_ajax = $this->loadModel("", "ajax");
    }

    public function index() {
        $this->_view->lstCur = $this->_post->informacionCurso();
        $this->_view->titulo = 'Gestión de cursos - ' . APP_TITULO;
        $this->_view->setJs(ADMH_FOLDER, array('admHistoriaCrearCurso'));
        $this->_view->setJs("public", array('jquery.dataTables.min'));
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar(ADMH_FOLDER, 'admHistoriaCrearCurso');
    }

    public function agregarCurso() {
           
        $this->_view->tiposCurso = $this->_post->getTiposCurso();

        $this->_view->titulo = 'Agregar Curso - ' . APP_TITULO;
        
        $arrayCur = array();
        
        
        $this->_view->datos = $_POST;
        if (!$this->getInteger('slTiposCurso')) {
            $this->_view->renderizar(ADMH_FOLDER, 'agregarCurso', 'admHistoriaCrearCurso');
            exit;
        }
        if (!$this->getTexto('txtNombre')) {
            $this->_view->renderizar(ADMH_FOLDER, 'agregarCurso', 'admHistoriaCrearCurso');
            exit;
        }
        if (!$this->getTexto('txtNombre')) {
            $this->_view->renderizar(ADMH_FOLDER, 'agregarCurso', 'admHistoriaCrearCurso');
            exit;
        }
        if (!$this->getTexto('slTraslape')) {
            $this->_view->renderizar(ADMH_FOLDER, 'agregarCurso', 'admHistoriaCrearCurso');
            exit;
        }
        $tipoCurso = $this->getInteger('slTiposCurso');
        $codigoCurso = $this->getTexto('txtCodigo');
        $nombreCurso = $this->getTexto('txtNombre');
        $traslapeCurso = $this->getTexto('slTraslape');
        
        $arrayCur['tipocurso'] = $tipoCurso;
        $arrayCur['codigo'] = $codigoCurso;
        $arrayCur['nombre'] = $nombreCurso;
        $arrayCur['traslape'] = $traslapeCurso;
        $arrayCur['estado'] = 1;
        
        $respuesta = $this->_post->agregarCurso($arrayCur);
        if(isset($respuesta[0][0])){
            $this->_view->datos = NULL;
        }
        
        $this->_view->renderizar(ADMH_FOLDER, 'agregarCurso', 'admHistoriaCrearCurso');    
    }
    
    public function eliminarCurso($intNuevoEstado, $intIdCurso) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $this->_post->eliminarCurso($intIdCurso, $intNuevoEstado);

            $this->redireccionar('admHistoriaCrearCurso');
        } else {
            echo "Error al desactivar curso";
        }
        //$this->redireccionar('admHistoriaCrearCurso');
        //$this->_view->cambio = $intNuevoEstado;
        //$this->_view->titulo = 'Eliminar curso - ' . APP_TITULO;
        //$this->_view->renderizar(ADM_FOLDER, 'eliminarUsuario', 'admCrearUsuario');
    }

}

?>
