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
        //$this->_view->setJs(array('listadoAsignaciones'));
        //$this->_view->setJs(array('jquery.dataTables.min'), "public");
        //$this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoAsignaciones');
        
    }
    
     public function inicio() {
        //$idCarrera = $this->getInteger('slCarreras'); 
        //$idEstudiante = $this->getInteger('slEstudiantes');
        //$idUsuario = $_SESSION['usuario'];
        //$idCarrera = $_SESSION['carrera'];
       
        $this->_view->titulo = 'Gestión de retrasadas - ' . APP_TITULO;
        //$this->_view->setJs(array('listadoAsignaciones'));
        //$this->_view->setJs(array('jquery.dataTables.min'), "public");
        //$this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('inicio');
        
    }
    
    public function generarOrdenPago($carnet,$nombre){
        //$carnet=200610816;
        $unidad=14;
        $extension=0;
        $carrera=1;
        //$nombre='TRINIDAD PINEDA JORGE';
        $nombre2 = strtoupper($nombre);
        $monto=10;
        $anio=2014;
        $rubro=4;
        $varianterubro=1;
        $tipocurso='CURSO';
        $curso='084';
        $seccion='B';
        $subtotal=10;
        
        $this->_generaorden = new wsGeneraOrdenPago();
        $cadena = implode(',', $this->_generaorden->generaOrdenPago($carnet,$unidad,$extension,$carrera,$nombre2,$monto,$anio,$rubro,$varianterubro,$tipocurso,$curso,$seccion,$subtotal));
        echo $cadena;
    }
}