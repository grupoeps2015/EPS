<?php

/**
 * Description of gestionRetrasadasController
 *
 * @author amoino   
 */
class gestionRetrasadasController extends Controller {

    private $_post;
    private $_encriptar;
    private $_ajax;
    private $_generaorden;

    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->getLibrary('wsGeneraOrdenPago');
        $this->_session = new session();
        if (!$this->_session->validarSesion()) {
            $this->redireccionar('login/salir');
            exit;
        }
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionRetrasadas');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index() {
        $this->_view->titulo = 'Asignación Retrasadas - ' . APP_TITULO;
        $this->_view->setJs(array('gestionRetrasadas'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionRetrasadas');
    }
    
     public function listadoAsignaciones() {
        //$idCarrera = $this->getInteger('slCarreras'); 
        //$idEstudiante = $this->getInteger('slEstudiantes');
        $idUsuario = $_SESSION['usuario'];
        $idCarrera = $_SESSION['carrera'];
       
        $info = $this->_post->allAsignaciones($idUsuario,$idCarrera);
        if (is_array($info)) {
            $this->_view->lstAsignaciones = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Asignacion de Retrasadas - ' . APP_TITULO;
        $this->_view->setJs(array('listadoAsignaciones'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoAsignaciones');
    }
    
    public function generarOrdenPago(){
        $this->_generaorden = new wsGeneraOrdenPago();
        $cadena = implode(',', $this->_generaorden->generaOrdenPago());
        echo $cadena;
    }
}