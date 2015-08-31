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
        $this->_view->lstUsr = $this->_post->informacionUsuario();
        $this->_view->titulo = 'Gestión de usuarios - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER, array('admCrearUsuario'));
        $this->_view->setJs("public", array('jquery.dataTables.min'));
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar(ADM_FOLDER, 'admCrearUsuario');
    }

    public function agregarCurso() {
           
        $this->_view->tiposCurso = $this->_post->getTiposCurso();

        $this->_view->titulo = 'Agregar Curso - ' . APP_TITULO;

        $this->_view->renderizar(ADMH_FOLDER, 'agregarCurso', 'admHistoriaCrearCurso');
    }

}

?>
